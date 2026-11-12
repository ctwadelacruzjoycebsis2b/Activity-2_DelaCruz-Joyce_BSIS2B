<?php
require_once 'includes/config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email = strtolower(trim($_POST['email'] ?? ''));
    $s = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $s->execute([$email]);
    $user = $s->fetch();
    if ($user && password_verify($_POST['password'] ?? '', $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $user['id'], 'fullname' => $user['fullname'], 'email' => $user['email'], 'role' => $user['role']];
        header('Location: dashboard.php'); exit;
    }
    $error = 'Mali ang email o password.';
}
$title = 'Sign in'; include 'includes/header.php';
?>
<div class="card narrow">
<h1>Sign in</h1>
<?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>
<form method="post">
  <input type="hidden" name="csrf" value="<?= csrf() ?>">
  <label>Email <input type="email" name="email" required></label>
  <label>Password <input type="password" name="password" required></label>
  <button class="btn">Sign in</button>
</form>
<p>Wala pang account? <a href="register.php">Register</a></p>
</div>
<?php include 'includes/footer.php'; ?>
