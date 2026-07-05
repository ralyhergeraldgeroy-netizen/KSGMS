<?php
include 'config.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {

    if (!isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid Token");
    }

    $password_input = $_POST['admin_password'] ?? '';

    if ($password_input === ADMIN_PASSWORD) {
        $_SESSION['is_admin'] = true;
        unset($_SESSION['guest_user']);

        $success_message = "Admin Login Successful";
    } else {
        $error_message = "Wrong Password";
    }
}
?>
