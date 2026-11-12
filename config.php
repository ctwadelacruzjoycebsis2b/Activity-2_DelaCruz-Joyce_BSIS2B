<?php
// Palitan ayon sa hosting mo (XAMPP default: root, walang password)
const DB_HOST = 'localhost';
const DB_NAME = 'ctwa_db';
const DB_USER = 'root';
const DB_PASS = '';

session_start();

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Hindi makakonekta sa database. I-import muna ang schema.sql at i-check ang includes/config.php.");
}

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function csrf() { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16)); return $_SESSION['csrf']; }
function csrf_check() { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(400); die('Invalid request.'); } }
function flash($msg = null) { if ($msg) { $_SESSION['flash'] = $msg; return; } $m = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $m; }
