<?php
/**
 * KSGM Resorts Management System
 * Main Entry Point
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load dependencies
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/handlers.php';
require_once __DIR__ . '/includes/functions.php';

$error_message = null;
$success_message = null;

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['process_wizard_reservation'])) {
        handleWizardReservation($pdo);
    }

    if (isset($_POST['admin_login'])) {
        handleAdminLogin($pdo, $error_message, $success_message);
    }

    if (isset($_POST['customer_login'])) {
        handleCustomerLogin($pdo, $error_message, $success_message);
    }

    if (isset($_POST['guest_signup'])) {
        handleGuestSignup($pdo, $error_message, $success_message);
    }

    if (isset($_POST['delete_booking'])) {
        handleDeleteBooking($pdo, $error_message, $success_message);
    }
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    handleLogout();
}

// Session state
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
$isGuestLoggedIn = isset($_SESSION['guest_user']) && !empty($_SESSION['guest_user']);
$csrf_token = generateCsrfToken();

// Data retrieval
$guest_bookings = [];
$adminData = null;

if ($isGuestLoggedIn) {
    $guest_bookings = getGuestBookings($pdo, $_SESSION['guest_user']);
}

if ($isAdmin) {
    $adminData = getAdminData($pdo);
}

$suites = getSuites();
$foods = getFoods();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KSGM Resorts — Neon Luxury Ecosystem</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/app.js" defer></script>
</head>
<body class="<?= !$isAdmin ? 'text-white antialiased min-h-screen relative overflow-x-hidden' : 'text-slate-900 antialiased min-h-screen relative overflow-x-hidden' ?>">

<!-- Galaxy Background -->
<div class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-br from-black via-slate-900 to-indigo-950"></div>
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-purple-700 rounded-full blur-[180px] opacity-30"></div>
    <div class="absolute bottom-0 right-0 w-[450px] h-[450px] bg-blue-700 rounded-full blur-[170px] opacity-30"></div>
    <div class="absolute top-1/2 left-1/2 w-[300px] h-[300px] bg-yellow-400 rounded-full blur-[140px] opacity-20 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute inset-0 opacity-40" style="background-image: radial-gradient(white 1px, transparent 1px), radial-gradient(white 1px, transparent 1px); background-size: 70px 70px, 120px 120px; background-position: 0 0, 35px 35px;"></div>
</div>

<nav class="<?= !$isAdmin ? 'bg-black/90 border-b-2 border-yellow-500 shadow-[0_2px_20px_rgba(234,179,8,0.2)]' : 'bg-slate-900 text-white shadow-xl border-b border-slate-700' ?> sticky top-0 z-50 transition-all">
    <div class="max-w-[1400px] mx-auto px-6 h-20 flex items-center justify-between">
        <a href="index.php" class="text-2xl font-black tracking-widest uppercase <?= !$isAdmin ? 'text-yellow-400 drop-shadow-[0_0_8px_rgba(234,179,8,0.6)]' : 'text-yellow-400' ?>">
            ksgm
        </a>
        <div class="flex items-center gap-6">
            <?php if ($isAdmin): ?>
                <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Mode: Administrator</span>
                <a href="?action=logout" class="bg-slate-900 text-white font-semibold text-xs px-4 py-2.5 rounded-lg hover:bg-slate-800 transition-all">Leave Dashboard</a>
            <?php elseif ($isGuestLoggedIn): ?>
                <span class="text-xs font-bold text-yellow-400 tracking-wide uppercase border border-yellow-500/50 bg-yellow-500/10 px-3 py-1.5 rounded-lg">Guest: <?= htmlspecialchars($_SESSION['guest_user']) ?></span>
                <a href="?action=logout" class="text-xs font-black text-black bg-yellow-400 hover:bg-yellow-300 shadow-[0_0_15px_rgba(234,179,8,0.4)] px-4 py-2.5 rounded-lg transition-all tracking-wide uppercase">Log Out</a>
            <?php else: ?>
                <button onclick="toggleCustomerLoginModal(true)" class="text-xs font-black text-black bg-yellow-400 hover:bg-yellow-300 px-5 py-2.5 rounded-lg">Customer Login</button>
                <button onclick="toggleSignupModal(true)" class="text-xs font-black tracking-widest text-yellow-400/80 hover:text-yellow-400 uppercase transition-all focus:outline-none">Sign up</button>
                <button onclick="toggleLoginModal(true)" class="text-xs font-black text-yellow-400 border border-yellow-400 px-5 py-2.5 rounded-lg ml-2">Admin Login</button>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="max-w-[1400px] mx-auto p-6 min-h-[calc(100vh-80px)] overflow-visible relative z-10">
    <?php if (!empty($error_message)): ?>
        <div class="p-4 bg-rose-950 border-2 border-rose-500 text-rose-200 font-bold rounded-xl text-sm shadow-[0_0_15px_rgba(244,63,94,0.2)]">
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <div class="p-4 bg-emerald-950 border-2 border-emerald-500 text-emerald-200 font-bold rounded-xl text-sm shadow-[0_0_15px_rgba(16,185,129,0.2)]">
            <?= htmlspecialchars($success_message) ?>
        </div>
    <?php endif; ?>

    <?php if (!$isAdmin): ?>
        <?php include __DIR__ . '/views/partials/guest_view.php'; ?>
    <?php else: ?>
        <?php include __DIR__ . '/views/partials/admin_view.php'; ?>
    <?php endif; ?>

</main>

<?php include __DIR__ . '/views/partials/modals.php'; ?>

<script>
    window.chartData = <?= json_encode($adminData['chart_data'] ?? []) ?>;
</script>
</body>
</html>
