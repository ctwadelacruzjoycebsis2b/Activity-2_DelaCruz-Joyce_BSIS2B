<?php
// ACCESS CONTROL helpers
require_once __DIR__ . '/config.php';

function is_logged_in() { return isset($_SESSION['user']); }
function current_user() { return $_SESSION['user'] ?? null; }

function require_login() {
    if (!is_logged_in()) { flash('Mag-login muna.'); header('Location: login.php'); exit; }
}
function require_role($role) {
    require_login();
    if ($_SESSION['user']['role'] !== $role) { http_response_code(403); include __DIR__ . '/403.php'; exit; }
}
