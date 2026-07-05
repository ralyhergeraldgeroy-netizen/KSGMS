<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ADMIN_PASSWORD', 'admin123');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
