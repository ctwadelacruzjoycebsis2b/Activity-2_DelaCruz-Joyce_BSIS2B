<?php $title = 'Home'; include 'includes/header.php'; ?>
<h1>Mga Aralin</h1>
<div class="grid">
  <a class="tile" href="errors_scopes.php"><h2>Errors &amp; Variable Scopes</h2><p>Notice, Warning, Fatal, Parse errors at Global, Local, Static scope.</p></a>
  <a class="tile" href="<?= $u ? 'dashboard.php' : 'register.php' ?>"><h2>Sign In and Register with Database</h2><p>Gumawa ng account at mag-login gamit ang MySQL.</p></a>
  <a class="tile" href="admin.php"><h2>Access Control and Management</h2><p>Admin-only na page at pamamahala ng users.</p></a>
  <a class="tile" href="items.php"><h2>CRUD Operations</h2><p>Create, Read, Update, Delete ng mga item.</p></a>
</div>
<?php include 'includes/footer.php'; ?>
