<?php
require_once 'includes/config.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $name = trim($_POST['fullname'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $pass = $_POST['password'] ?? '';
    $pass2 = $_POST['password2'] ?? '';

    if ($name === '') $errors[] = 'Ilagay ang buong pangalan.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Hindi valid ang email.';
    if (strlen($pass) < 8) $errors[] = 'Hindi bababa sa 8 characters ang password.';
    if ($pass !== $pass2) $errors[] = 'Hindi magkatugma ang mga password.';

    if (!$errors) {
        $s = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $s->execute([$email]);
        if ($s->fetch()) {
            $errors[] = 'May account na ang email na ito.';
        } else {
            $pdo->prepare('INSERT INTO users (fullname, email, password_hash) VALUES (?,?,?)')
                ->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT)]);
            flash('Nakagawa na ng account. Puwede ka nang mag-login.');
            header('Location: login.php'); exit;
        }
    }
}
$title = 'Register'; include 'includes/header.php';
?>
<div class="card narrow">
<h1>Register</h1>
<?php foreach ($errors as $er): ?><div class="error"><?= e($er) ?></div><?php endforeach; ?>
<form method="post">
  <input type="hidden" name="csrf" value="<?= csrf() ?>">
  <label>Buong pangalan <input name="fullname" required value="<?= e($_POST['fullname'] ?? '') ?>"></label>
  <label>Email <input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>"></label>
  <label>Password <input type="password" name="password" required minlength="8"></label>
  <label>Ulitin ang password <input type="password" name="password2" required></label>
  <button class="btn">Gumawa ng account</button>
</form>
<p>May account na? <a href="login.php">Sign in</a></p>
</div>
<?php include 'includes/footer.php'; ?>
