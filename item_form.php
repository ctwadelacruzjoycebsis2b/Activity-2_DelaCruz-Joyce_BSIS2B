<?php
// CRUD: CREATE + UPDATE
require_once 'includes/auth.php';
require_login();
$u = current_user();
$isAdmin = $u['role'] === 'admin';
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$item = ['title' => '', 'description' => ''];

if ($id) {
    $s = $pdo->prepare('SELECT * FROM items WHERE id = ?');
    $s->execute([$id]);
    $item = $s->fetch();
    if (!$item || (!$isAdmin && (int)$item['user_id'] !== (int)$u['id'])) { http_response_code(403); die('Walang access sa item na ito.'); }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $t = trim($_POST['title'] ?? '');
    $d = trim($_POST['description'] ?? '');
    if ($t === '') { $error = 'Kailangan ang title.'; $item = ['title' => $t, 'description' => $d]; }
    else {
        if ($id) $pdo->prepare('UPDATE items SET title = ?, description = ? WHERE id = ?')->execute([$t, $d, $id]);
        else     $pdo->prepare('INSERT INTO items (user_id, title, description) VALUES (?,?,?)')->execute([$u['id'], $t, $d]);
        flash($id ? 'Na-update ang item.' : 'Nadagdag ang item.');
        header('Location: items.php'); exit;
    }
}
$title = $id ? 'Edit item' : 'Bagong item'; include 'includes/header.php';
?>
<div class="card narrow">
<h1><?= $id ? 'I-edit ang item' : 'Bagong item' ?></h1>
<?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>
<form method="post">
  <input type="hidden" name="csrf" value="<?= csrf() ?>"><input type="hidden" name="id" value="<?= $id ?>">
  <label>Title <input name="title" required maxlength="120" value="<?= e($item['title']) ?>"></label>
  <label>Description <textarea name="description" rows="4"><?= e($item['description']) ?></textarea></label>
  <button class="btn">I-save</button> <a href="items.php">Kanselahin</a>
</form>
</div>
<?php include 'includes/footer.php'; ?>
