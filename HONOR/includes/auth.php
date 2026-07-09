<?php
/**
 * Authentication Handlers
 */

function validateCsrfToken($session_token, $posted_token) {
    if (!isset($posted_token) || !hash_equals($session_token, $posted_token)) {
        die("Security violation: Invalid session token.");
    }
}

function handleAdminLogin($pdo, &$error_message, &$success_message) {
    global $ROOM_PRICES, $FOOD_PRICES;
    require_once __DIR__ . '/../config/constants.php';

    validateCsrfToken($_SESSION['csrf_token'], $_POST['csrf_token']);

    if (($_POST['admin_password'] ?? '') === ADMIN_PASSWORD) {
        $_SESSION['is_admin'] = true;
        unset($_SESSION['guest_user']);
        $success_message = "Authenticated successfully as Administrator.";
    } else {
        $error_message = "Invalid administrative credentials.";
    }
}

function handleCustomerLogin($pdo, &$error_message, &$success_message) {
    validateCsrfToken($_SESSION['csrf_token'], $_POST['csrf_token']);

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['guest_user'] = $user['username'];
        $_SESSION['is_admin'] = false;
        $success_message = "Customer logged in successfully.";
    } else {
        $error_message = "Invalid username or password.";
    }
}

function handleGuestSignup($pdo, &$error_message, &$success_message) {
    validateCsrfToken($_SESSION['csrf_token'], $_POST['csrf_token']);

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "All registration fields are strictly required.";
        return;
    }

    try {
        $check = $pdo->prepare("SELECT id FROM user WHERE email = ? OR username = ?");
        $check->execute([$email, $username]);

        if ($check->fetch()) {
            $error_message = "Username or Email address already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
            $insert = $pdo->prepare("INSERT INTO user (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
            $insert->execute([$username, $email, $hashed_password]);

            $_SESSION['guest_user'] = $username;
            $_SESSION['is_admin'] = false;
            $success_message = "Welcome aboard! Account created successfully.";
        }
    } catch (\PDOException $e) {
        $error_message = "Account creation failed due to system database constraints.";
    }
}

function handleLogout() {
    session_destroy();
    header("Location: index.php");
    exit;
}
