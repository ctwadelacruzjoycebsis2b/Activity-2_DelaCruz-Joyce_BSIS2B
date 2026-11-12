<?php
require_once 'includes/auth.php';
require_role('admin');   // ACCESS CONTROL: admin lang
$me = current_user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $id = (int)($_POST['id'] ?? 0);
    if ($id === (int)$me['id']) {
        flash('Hindi mo puwedeng baguhin ang sarili mong account dito.');
    } elseif (($_POST['action'] ?? '') === 'role') {
        $role = $_POST['role'] === 'admin' ? 'admin' : 'user';
        $pdo->prepare('UPDATE users SET role = ? WHERE id = ?')->execute([$role, $id]);
        flash('Na-update ang role.');
    } elseif (($_POST['action'] ?? '') === 'delete') {
        $pdo->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
        flash('Na-delete ang user.');
    }
    header('Location: admin.php'); exit;
}
$users = $pdo->query('SELECT id, fullname, email, role, created_at FROM users ORDER BY id')->fetchAll();
$title = 'Admin'; include 'includes/header.php';
?>
<h1>Pamamahala ng Users</h1>
<div class="card">
<table>
<tr><th>Pangalan</th><th>Email</th><th>Role</th><th>Aksyon</th></tr>
<?php foreach ($users as $r): ?>
<tr>
  <td><?= e($r['fullname']) ?></td><td><?= e($r['email']) ?></td><td><?= e($r['role']) ?></td>
  <td>
  <?php if ((int)$r['id'] !== (int)$me['id']): ?>
    <form method="post" class="inline">
      <input type="hidden" name="csrf" value="<?= csrf() ?>"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
      <input type="hidden" name="action" value="role">
      <input type="hidden" name="role" value="<?= $r['role'] === 'admin' ? 'user' : 'admin' ?>">
      <button class="btn small"><?= $r['role'] === 'admin' ? 'Gawing user' : 'Gawing admin' ?></button>
    </form>
    <form method="post" class="inline" onsubmit="return confirm('I-delete ang user na ito?')">
      <input type="hidden" name="csrf" value="<?= csrf() ?>"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
      <input type="hidden" name="action" value="delete">
      <button class="btn small danger">Delete</button>
    </form>
  <?php else: ?>Ikaw ito<?php endif; ?>
  </td>
</tr>
<?php endforeach; ?>
</table>
</div>
<?php include 'includes/footer.php'; ?>
