<?php
require_once 'includes/auth.php';
require_login();
$u = current_user();
$n = $pdo->prepare('SELECT COUNT(*) FROM items WHERE user_id = ?');
$n->execute([$u['id']]);
$title = 'Dashboard'; include 'includes/header.php';
?>
<div class="card">
<h1>Kumusta, <?= e($u['fullname']) ?>!</h1>
<p>Role: <strong><?= e($u['role']) ?></strong> &middot; Mga item mo: <strong><?= (int)$n->fetchColumn() ?></strong></p>
<a class="btn" href="items.php">Pamahalaan ang items</a>
<?php if ($u['role'] === 'admin'): ?><a class="btn alt" href="admin.php">Admin panel</a><?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
