<?php require_once __DIR__ . '/config.php'; $u = $_SESSION['user'] ?? null; ?>
<!DOCTYPE html>
<html lang="fil">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? 'CTWA') ?> | Dela Cruz BSIS-2B</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="top">
  <a class="brand" href="index.php">delacruz.bsis2b.ctwa</a>
  <nav>
    <a href="errors_scopes.php">Errors &amp; Scopes</a>
    <?php if ($u): ?>
      <a href="dashboard.php">Dashboard</a>
      <a href="items.php">CRUD</a>
      <?php if ($u['role'] === 'admin'): ?><a href="admin.php">Admin</a><?php endif; ?>
      <a href="logout.php">Logout (<?= e($u['fullname']) ?>)</a>
    <?php else: ?>
      <a href="login.php">Sign in</a>
      <a href="register.php">Register</a>
    <?php endif; ?>
  </nav>
</header>
<main>
<?php if ($m = flash()): ?><div class="flash"><?= e($m) ?></div><?php endif; ?>
