<?php
// CRUD: READ + DELETE (list). Admin nakikita lahat; user sariling items lang.
require_once 'includes/auth.php';
require_login();
$u = current_user();
$isAdmin = $u['role'] === 'admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    csrf_check();
    $sql = 'DELETE FROM items WHERE id = ?' . ($isAdmin ? '' : ' AND user_id = ?');
    $pdo->prepare($sql)->execute($isAdmin ? [(int)$_POST['id']] : [(int)$_POST['id'], $u['id']]);
    flash('Na-delete ang item.');
    header('Location: items.php'); exit;
}

$q = $isAdmin
  ? $pdo->query('SELECT items.*, users.fullname FROM items JOIN users ON users.id = items.user_id ORDER BY items.id DESC')
  : $pdo->prepare('SELECT items.*, users.fullname FROM items JOIN users ON users.id = items.user_id WHERE user_id = ? ORDER BY items.id DESC');
if (!$isAdmin) $q->execute([$u['id']]);
$rows = $q->fetchAll();

$title = 'Items'; include 'includes/header.php';
?>
<h1>Items <a class="btn small" href="item_form.php">+ Magdagdag</a></h1>
<div class="card">
<?php if (!$rows): ?><p>Wala pang item. Pindutin ang “Magdagdag” para magsimula.</p><?php else: ?>
<table>
<tr><th>Title</th><th>Description</th><?php if ($isAdmin): ?><th>May-ari</th><?php endif; ?><th>Aksyon</th></tr>
<?php foreach ($rows as $r): ?>
<tr>
  <td><?= e($r['title']) ?></td><td><?= e($r['description']) ?></td>
  <?php if ($isAdmin): ?><td><?= e($r['fullname']) ?></td><?php endif; ?>
  <td>
    <a class="btn small" href="item_form.php?id=<?= (int)$r['id'] ?>">Edit</a>
    <form method="post" class="inline" onsubmit="return confirm('I-delete ang item?')">
      <input type="hidden" name="csrf" value="<?= csrf() ?>"><input type="hidden" name="action" value="delete">
      <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
      <button class="btn small danger">Delete</button>
    </form>
  </td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
