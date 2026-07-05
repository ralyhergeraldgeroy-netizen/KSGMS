<?php
/**
 * KSGM Resorts Management System
 * Core Infrastructure Configuration, Database Layer, Wizard Handler, & Admin Engine
 * Theme: Premium Neon Black & Radiant Gold
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ADMIN_PASSWORD', 'admin123');

$error_message = null;
$success_message = null;

// Database Connection Settings
$host = 'localhost'; 
$db   = 'resort_db'; 
$user = 'root'; 
$pass = ''; 
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
    PDO::ATTR_EMULATE_PREPARES   => false
];

try { 
    $pdo = new PDO($dsn, $user, $pass, $options); 
} catch (\PDOException $e) { 
    die("A critical system infrastructure error occurred."); 
}

// --- BACKEND TRANSACTION HANDLER ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_wizard_reservation'])) {
    header('Content-Type: application/json');
    
    if (empty($_SESSION['guest_user'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthenticated access attempt.']);
        exit;
    }

    $customer_name = $_SESSION['guest_user'];
    $room_selected = $_POST['room'] ?? '';
    $foods_selected = isset($_POST['foods']) ? json_decode($_POST['foods'], true) : [];

    $room_prices = [
        'Ocean Oasis Suite' => 550,
        'Minimalist Skyline' => 420,
        'Botanical Sanctuary' => 310,
        'Emerald Canopy Treehouse' => 360,
        'Sunset Crag Pavilion' => 495
    ];

    $food_prices = [
        'Citrus Seared King Scallops' => 38,
        'Truffle Infused Kelp Ramen' => 29,
        'Glazed Atlantic Cod' => 42,
        'Aged Wagyu Carpaccio' => 55
    ];

    $base_room_cost = $room_prices[$room_selected] ?? 0;
    $gastronomy_cost = 0;
    foreach ($foods_selected as $food_item) {
        if (isset($food_prices[$food_item])) {
            $gastronomy_cost += $food_prices[$food_item];
        }
    }
    
    $total_calculated_invoice = $base_room_cost + $gastronomy_cost;
    $mock_room_number = rand(101, 505);
    $current_date = date('Y-m-d');
    $checkout_date = date('Y-m-d', strtotime('+3 days'));

    try {
        $stmt = $pdo->prepare("INSERT INTO bookings (customer_name, resort_name, room_number, check_in, check_out, total_price, food_items) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $customer_name, 
            $room_selected, 
            $mock_room_number, 
            $current_date, 
            $checkout_date, 
            $total_calculated_invoice,
            implode(", ", $foods_selected)
        ]);
        
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database write failure: ' . $e->getMessage()]);
    }
    exit;
}

// --- SECURITY AUTHENTICATION HANDLERS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Security violation: Invalid session token.");
    }
    if (($_POST['admin_password'] ?? '') === ADMIN_PASSWORD) {
        $_SESSION['is_admin'] = true;
        unset($_SESSION['guest_user']);
        $success_message = "Authenticated successfully as Administrator.";
    } else {
        $error_message = "Invalid administrative credentials.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guest_signup'])) {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Security violation: Invalid session token.");
    }

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "All registration fields are strictly required.";
    } else {
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
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}

$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
$isGuestLoggedIn = isset($_SESSION['guest_user']) && !empty($_SESSION['guest_user']);

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// --- ADMINISTRATIVE & GUEST DATA RECONCILIATION LAYER ---
$bookings = [];
$guest_bookings = [];
$total_sales = 0;
$chart_data = [];

// Fetch current guest's specific bookings if logged in
if ($isGuestLoggedIn) {
    try {
        $guest_stmt = $pdo->prepare("SELECT id, resort_name, room_number, total_price, food_items, check_in FROM bookings WHERE customer_name = ? ORDER BY id DESC");
        $guest_stmt->execute([$_SESSION['guest_user']]);
        $guest_bookings = $guest_stmt->fetchAll();
    } catch (\PDOException $e) {
        error_log($e->getMessage());
    }
}

if ($isAdmin) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_booking'])) {
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Security violation: Invalid session token.");
        }
        try {
            $delete = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
            $delete->execute([intval($_POST['booking_id'])]);
            $success_message = "Customer system record permanently purged.";
        } catch (\PDOException $e) {
            $error_message = "Purge execution failure: " . $e->getMessage();
        }
    }

    try {
        $sales_query = $pdo->query("SELECT SUM(total_price) AS grand_total FROM bookings");
        $total_sales = $sales_query->fetch()['grand_total'] ?? 0;

        $bookings_query = $pdo->query("SELECT id, customer_name, resort_name, room_number, total_price, food_items, check_in FROM bookings ORDER BY id DESC");
        $bookings = $bookings_query->fetchAll();

        // Aggregate suite counts for the Pie Chart analytics mapping
        $chart_query = $pdo->query("SELECT resort_name, COUNT(*) as count FROM bookings GROUP BY resort_name");
        $chart_data = $chart_query->fetchAll();
    } catch (\PDOException $e) {
        error_log($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>KSGM Resorts — Neon Luxury Ecosystem</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="<?= !$isAdmin ? 'bg-black text-white antialiased min-h-screen relative' : 'bg-slate-50 text-slate-900 antialiased min-h-screen' ?>">

    <nav class="<?= !$isAdmin ? 'bg-black/90 border-b-2 border-yellow-500 shadow-[0_2px_20px_rgba(234,179,8,0.2)]' : 'bg-white shadow-sm border-b border-slate-100' ?> sticky top-0 z-50 transition-all">
        <div class="max-w-[1400px] mx-auto px-6 h-20 flex items-center justify-between">
            <a href="index.php" class="text-2xl font-black tracking-widest uppercase <?= !$isAdmin ? 'text-yellow-400 drop-shadow-[0_0_8px_rgba(234,179,8,0.6)]' : 'text-slate-900' ?>">
                ksgm
            </a>
            
            <div class="flex items-center gap-6">
                <?php if ($isAdmin): ?>
                    <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Mode: Administrator</span>
                    <a href="?action=logout" class="bg-slate-900 text-white font-semibold text-xs px-4 py-2.5 rounded-lg hover:bg-slate-800 transition-all">← Leave Dashboard</a>
                <?php elseif ($isGuestLoggedIn): ?>
                    <span class="text-xs font-bold text-yellow-400 tracking-wide uppercase border border-yellow-500/50 bg-yellow-500/10 px-3 py-1.5 rounded-lg">Guest: <?= htmlspecialchars($_SESSION['guest_user']) ?></span>
                    <a href="?action=logout" class="text-xs font-black text-black bg-yellow-400 hover:bg-yellow-300 shadow-[0_0_15px_rgba(234,179,8,0.4)] px-4 py-2.5 rounded-lg transition-all tracking-wide uppercase">Log Out</a>
                <?php else: ?>
                    <button onclick="toggleSignupModal(true)" class="text-xs font-black tracking-widest text-yellow-400/80 hover:text-yellow-400 uppercase transition-all focus:outline-none">Sign up</button>
                    <button onclick="toggleLoginModal(true)" class="text-xs font-black text-black bg-yellow-400 hover:bg-yellow-300 px-5 py-2.5 rounded-lg transition-all shadow-[0_0_15px_rgba(234,179,8,0.4)] tracking-wide uppercase focus:outline-none">Log in</button>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="max-w-[1400px] mx-auto p-6 space-y-12 relative z-10">
        
        <?php if (!empty($error_message)): ?>
            <div class="p-4 bg-rose-950 border-2 border-rose-500 text-rose-200 font-bold rounded-xl text-sm shadow-[0_0_15px_rgba(244,63,94,0.2)]">
                ⚠️ <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="p-4 bg-emerald-950 border-2 border-emerald-500 text-emerald-200 font-bold rounded-xl text-sm shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                ✓ <?= htmlspecialchars($success_message) ?>
            </div>
        <?php endif; ?>

        <?php if (!$isAdmin): ?>
            <div id="welcomeIntroBlock" class="max-w-4xl mx-auto pt-16 pb-8 text-center flex flex-col items-center justify-center">
                <h1 class="text-7xl sm:text-9xl font-black tracking-tighter uppercase leading-none text-white select-none">
                    KSGM <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-amber-400 to-yellow-500 drop-shadow-[0_0_30px_rgba(234,179,8,0.6)]">LUXURY</span>
                </h1>
                <div class="w-32 h-[4px] bg-gradient-to-r from-yellow-500 to-amber-300 my-8 shadow-[0_0_10px_rgba(234,179,8,0.8)]"></div>
                <p class="max-w-2xl text-yellow-100/90 text-lg sm:text-xl font-medium leading-relaxed tracking-wide">
                    <?php if ($isGuestLoggedIn): ?>
                        Welcome, <span class="text-yellow-400 font-black underline decoration-2 drop-shadow-[0_0_5px_rgba(234,179,8,0.4)]"><?= htmlspecialchars($_SESSION['guest_user']) ?></span>. Your exclusive high-tier reservation portal is fully active. Build your customizable experience blueprint below.
                    <?php else: ?>
                        Indulge in ultra-minimalist architecture interwoven with glowing modern gold standard opulence. Create an account or log in to unlock instant resort asset assignment pathways.
                    <?php endif; ?>
                </p>

                <?php if ($isGuestLoggedIn): ?>
                    <button onclick="startBookingWizard()" class="mt-10 bg-gradient-to-r from-yellow-400 to-amber-500 text-black text-sm font-black tracking-widest uppercase px-10 py-5 rounded-xl shadow-[0_0_25px_rgba(234,179,8,0.5)] hover:scale-105 transition-all">
                        Begin Luxury Booking Flow →
                    </button>
                <?php endif; ?>
            </div>

            <?php if ($isGuestLoggedIn): ?>
                <div id="guestOrdersDashboard" class="max-w-4xl mx-auto bg-neutral-950 border-2 border-yellow-500/30 rounded-2xl p-6 shadow-[0_0_25px_rgba(0,0,0,0.5)]">
                    <div class="border-b border-neutral-800 pb-4 mb-4 flex items-center justify-between">
                        <h3 class="text-xs font-black tracking-widest uppercase text-yellow-400">Your Architectural Manifest & Orders</h3>
                        <span class="text-[10px] font-mono text-neutral-500 uppercase">
    <?= isset($guest_bookings) && is_array($guest_bookings) ? count($guest_bookings) : 0 ?> active logs
</span>
                    </div>
                    
                    <?php if (empty($guest_bookings)): ?>
                        <p class="text-neutral-500 text-xs italic text-center py-6">Your customized ledger is currently clean. No packages reserved yet.</p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($guest_bookings as $order): ?>
                                <div class="bg-black border border-neutral-800 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-yellow-500/50 transition-all">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-white font-black uppercase text-sm tracking-wide"><?= htmlspecialchars($order['resort_name']) ?></span>
                                            <span class="bg-neutral-900 border border-neutral-700 text-yellow-400 font-mono font-bold text-[10px] px-2 py-0.5 rounded">Room <?= htmlspecialchars($order['room_number']) ?></span>
                                        </div>
                                        <p class="text-xs text-neutral-400 font-medium">
                                            <span class="text-yellow-500/70 font-semibold uppercase tracking-wider text-[10px] block sm:inline">Gastronomy additions:</span> 
                                            <?= !empty($order['food_items']) ? htmlspecialchars($order['food_items']) : '<span class="italic text-neutral-600">None</span>' ?>
                                        </p>
                                        <span class="block text-[10px] font-mono text-neutral-600">Issued timestamp: <?= htmlspecialchars($order['check_in']) ?></span>
                                    </div>
                                    <div class="text-left sm:text-right border-t border-neutral-900 sm:border-0 pt-2 sm:pt-0">
                                        <span class="text-[10px] block font-black tracking-widest uppercase text-neutral-500">Gross Total Cost</span>
                                        <span class="text-xl font-black text-yellow-400 drop-shadow-[0_0_8px_rgba(234,179,8,0.4)]">$<?= number_format($order['total_price'], 2) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($isGuestLoggedIn): ?>
                <div id="stepProgressTimeline" class="hidden max-w-md mx-auto flex items-center justify-between px-6 py-3 bg-neutral-950 border-2 border-yellow-500/40 rounded-xl text-xs uppercase tracking-widest font-black shadow-[0_0_15px_rgba(234,179,8,0.15)]">
                    <div id="step1Indicator" class="text-yellow-400 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-yellow-400 text-black flex items-center justify-center font-black">1</span> Suites
                    </div>
                    <div class="text-yellow-500/40">➔</div>
                    <div id="step2Indicator" class="text-white/40 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-neutral-800 text-white/50 flex items-center justify-center font-bold">2</span> Dining
                    </div>
                </div>

                <section id="roomSection" class="hidden space-y-8 pt-6 border-t-2 border-yellow-500/20">
                    <div class="text-center">
                        <h2 class="text-xs font-black tracking-widest uppercase text-yellow-400">Step One</h2>
                        <p class="text-3xl font-black text-white tracking-tight uppercase">Select Your Sanctuary Base</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php
                        $suites = [
                            ['Ocean Oasis Suite', 'Private pool & panoramic ocean viewport', 550],
                            ['Minimalist Skyline', 'Monolithic stone interior & elevated terrace', 420],
                            ['Botanical Sanctuary', 'Surrounded by organic lush island flora', 310],
                            ['Emerald Canopy Treehouse', 'Elevated platform among local redwoods', 360],
                            ['Sunset Crag Pavilion', 'West-facing rock bluff alignment', 495]
                        ];
                        foreach ($suites as $suite): ?>
                            <div class="bg-neutral-950 border-2 border-neutral-800 rounded-2xl p-6 space-y-6 hover:border-yellow-400 transition-all shadow-[0_4px_20px_rgba(0,0,0,0.8)] flex flex-col justify-between">
                                <div class="space-y-4">
                                    <div class="aspect-video w-full bg-gradient-to-br from-neutral-900 to-neutral-800 border border-neutral-700/50 rounded-xl flex items-center justify-center text-xs text-yellow-400/40 uppercase font-black tracking-widest">KSGM Asset Photo</div>
                                    <div class="flex justify-between items-start gap-2">
                                        <div>
                                            <h3 class="font-black text-base text-white uppercase tracking-wide"><?= $suite[0] ?></h3>
                                            <p class="text-xs text-neutral-400 mt-1"><?= $suite[1] ?></p>
                                        </div>
                                        <span class="text-xs font-mono font-black text-yellow-400 bg-yellow-500/10 border border-yellow-400/30 px-3 py-1 rounded-md shadow-[0_0_8px_rgba(234,179,8,0.2)]">$<?= $suite[2] ?></span>
                                    </div>
                                </div>
                                <button onclick="goToFoodStep('<?= $suite[0] ?>', <?= $suite[2] ?>)" class="w-full bg-yellow-400 hover:bg-yellow-300 text-black text-xs font-black py-3.5 rounded-xl uppercase tracking-widest shadow-[0_0_15px_rgba(234,179,8,0.2)] transition-all">Select Suite</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <section id="foodSection" class="hidden space-y-8 pt-6 border-t-2 border-yellow-500/20">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xs font-black tracking-widest uppercase text-yellow-400">Step Two</h2>
                            <p class="text-3xl font-black text-white tracking-tight uppercase">Curate Your Dining Package</p>
                            <p class="text-xs text-neutral-300 mt-2">Active Target Suite: <span id="selectedRoomBadge" class="bg-yellow-400 text-black px-2 py-0.5 rounded font-black text-[11px] uppercase tracking-wider shadow-[0_0_10px_rgba(234,179,8,0.3)]">None</span></p>
                        </div>
                        <button onclick="goBackToRooms()" class="text-xs font-black tracking-widest text-yellow-400 hover:text-white uppercase border-2 border-yellow-400/50 px-4 py-2.5 rounded-xl bg-yellow-400/5 transition-all self-start">
                            &larr; Return to Suites
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php
                        $foods = [
                            ['Citrus Seared King Scallops', 'Served with yuzu foam & volcanic salted glass crisp', 38],
                            ['Truffle Infused Kelp Ramen', 'Slow simmered clear dashi broth & greens', 29],
                            ['Glazed Atlantic Cod', 'Miso reduction base coated in wild clover honey glaze', 42],
                            ['Aged Wagyu Carpaccio', 'Ultra-thin shaved prime cut with olive reduction', 55]
                        ];
                        foreach ($foods as $food): ?>
                            <label class="bg-neutral-950 border-2 border-neutral-800 hover:border-yellow-400 rounded-xl p-5 flex items-center justify-between gap-4 cursor-pointer select-none transition-all group">
                                <div class="flex items-center gap-4">
                                    <input type="checkbox" name="food_selection[]" value="<?= $food[0] ?>" data-price="<?= $food[2] ?>" onchange="calculateLiveTotal()" class="w-5 h-5 rounded border-yellow-500/40 bg-black accent-yellow-400 cursor-pointer">
                                    <div>
                                        <h4 class="text-sm font-black uppercase tracking-wide text-white group-hover:text-yellow-400 transition-colors"><?= $food[0] ?></h4>
                                        <p class="text-xs text-neutral-400 mt-0.5"><?= $food[1] ?></p>
                                    </div>
                                </div>
                                <span class="font-mono text-xs font-black text-yellow-400 bg-yellow-500/10 px-3 py-1 rounded border border-yellow-500/20 shadow-[0_0_5px_rgba(234,179,8,0.1)]">$<?= $food[2] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <div class="p-6 bg-gradient-to-r from-neutral-950 to-neutral-900 border-2 border-yellow-500 rounded-xl flex items-center justify-between shadow-[0_0_20px_rgba(234,179,8,0.2)]">
                        <div>
                            <span class="text-neutral-400 block text-[10px] font-black uppercase tracking-widest">Client Ledger Profile</span>
                            <span class="text-white font-black text-base uppercase tracking-wide drop-shadow-[0_0_5px_rgba(255,255,255,0.3)]"><?= htmlspecialchars($_SESSION['guest_user']) ?></span>
                        </div>
                        <div class="text-right">
                            <span class="text-yellow-400 block text-[10px] font-black uppercase tracking-widest">Gross Estimated Total</span>
                            <span class="text-3xl font-black text-yellow-400 drop-shadow-[0_0_10px_rgba(234,179,8,0.6)]" id="liveTotalDisplay">$0.00</span>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button onclick="submitFinalReservation()" class="w-full bg-gradient-to-r from-yellow-400 via-amber-400 to-yellow-500 text-black text-sm font-black tracking-widest uppercase py-5 rounded-xl shadow-[0_0_30px_rgba(234,179,8,0.4)] hover:opacity-90 transition-all">
                            Complete Reservation Plan & Check Out &checkmark;
                        </button>
                    </div>
                </section>
            <?php endif; ?>

        <?php else: ?>
            <div class="space-y-8">
                <div>
                    <h1 class="text-3xl font-black tracking-tight text-slate-900">Administrative Dashboard</h1>
                    <p class="text-xs text-slate-500 mt-1">Real-time operational overview tracking sales performance and asset distribution metrics.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-1 flex flex-col gap-6">
                        <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm flex flex-col justify-between h-32">
                            <span class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Gross Collected Revenue</span>
                            <span class="text-4xl font-black text-emerald-600">$<?= number_format($total_sales, 2) ?></span>
                        </div>
                        <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm flex flex-col justify-between h-32">
                            <span class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Active Database Entries</span>
                           <span class="text-4xl font-black text-slate-900">
    <?= isset($bookings) && is_array($bookings) ? count($bookings) : 0 ?> records
</span>
                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-white border border-slate-200 p-6 rounded-2xl shadow-sm flex flex-col items-center justify-center">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 self-start">Resort Suite Distribution Metrics</h3>
                        <div class="w-full max-w-[280px] aspect-square relative">
                            <?php if (empty($chart_data)): ?>
                                <div class="absolute inset-0 flex items-center justify-center text-xs text-slate-400 italic">No allocation data to map.</div>
                            <?php else: ?>
                                <canvas id="suiteDistributionPieChart"></canvas>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Client Transactions</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-slate-100 text-slate-600 uppercase font-mono border-b border-slate-200">
                                    <th class="p-4">ID</th>
                                    <th class="p-4">Customer Name</th>
                                    <th class="p-4">Suite Assigned</th>
                                    <th class="p-4">Food Choices</th>
                                    <th class="p-4">Invoice Total</th>
                                    <th class="p-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php if (empty($bookings)): ?>
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-slate-400">No active choices found inside database.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($bookings as $row): ?>
                                        <tr class="hover:bg-slate-50 transition-all">
                                            <td class="p-4 font-mono text-slate-400">#<?= $row['id'] ?></td>
                                            <td class="p-4 font-bold text-slate-900"><?= htmlspecialchars($row['customer_name']) ?></td>
                                            <td class="p-4"><span class="bg-slate-100 text-slate-800 font-semibold px-2 py-1 rounded"><?= htmlspecialchars($row['resort_name']) ?> (Rm <?= $row['room_number'] ?>)</span></td>
                                            <td class="p-4 text-slate-600 max-w-[240px] truncate" title="<?= htmlspecialchars($row['food_items'] ?? '') ?>"><?= !empty($row['food_items']) ? htmlspecialchars($row['food_items']) : '<span class="text-slate-300 italic">None</span>' ?></td>
                                            <td class="p-4 font-bold text-emerald-600">$<?= number_format($row['total_price'], 2) ?></td>
                                            <td class="p-4 text-center">
                                                <form method="POST" onsubmit="return confirm('Purge this record permanently?');" class="inline-block m-0">
                                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                                    <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                                    <button type="submit" name="delete_booking" class="bg-rose-50 text-rose-600 hover:bg-rose-100 font-bold px-3 py-1.5 rounded-lg transition-all">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <div id="signupModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-md z-50 flex items-center justify-center p-4">
        <div class="bg-black border-2 border-yellow-500 p-8 rounded-2xl shadow-[0_0_30px_rgba(234,179,8,0.4)] w-full max-w-[400px] space-y-6 relative">
            <button onclick="toggleSignupModal(false)" class="absolute top-4 right-5 text-yellow-400 hover:text-white font-light text-2xl">&times;</button>
            <div class="text-center">
                <h3 class="text-base font-black text-white tracking-widest uppercase">Create Luxury Account</h3>
                <p class="text-[10px] text-yellow-400 tracking-wider uppercase font-bold mt-1">Unlock Asset Allocation Gateways</p>
            </div>
            <form action="index.php" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="space-y-3">
                    <input type="text" name="username" required placeholder="CHOOSE USERNAME" class="w-full px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-xl text-xs text-white tracking-wider font-bold focus:border-yellow-400 focus:outline-none placeholder-neutral-500">
                    <input type="email" name="email" required placeholder="EMAIL ADDRESS" class="w-full px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-xl text-xs text-white tracking-wider font-bold focus:border-yellow-400 focus:outline-none placeholder-neutral-500">
                    <input type="password" name="password" required placeholder="SECURITY PASSWORD" class="w-full px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-xl text-xs text-white tracking-widest focus:border-yellow-400 focus:outline-none placeholder-neutral-500">
                </div>
                <button type="submit" name="guest_signup" class="w-full bg-yellow-400 hover:bg-yellow-300 text-black font-black text-xs py-4 px-4 rounded-xl uppercase tracking-widest transition shadow-lg">Register & Login</button>
            </form>
        </div>
    </div>

    <div id="loginModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-md z-50 flex items-center justify-center p-4">
        <div class="bg-black border-2 border-yellow-500 p-8 rounded-2xl shadow-[0_0_30px_rgba(234,179,8,0.4)] w-full max-w-[400px] space-y-6 relative">
            <button onclick="toggleLoginModal(false)" class="absolute top-4 right-5 text-yellow-400 hover:text-white font-light text-2xl">&times;</button>
            <div class="text-center">
                <h3 class="text-base font-black text-white tracking-widest uppercase">Admin Gateway</h3>
                <p class="text-[10px] text-yellow-400 tracking-wider uppercase font-bold mt-1">Identity Verification Required</p>
            </div>
            <form action="index.php" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="space-y-3">
                    <input type="password" name="admin_password" required placeholder="ENTER ADMIN KEY" class="w-full px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-xl text-xs text-white tracking-widest text-center focus:border-yellow-400 focus:outline-none placeholder-neutral-500">
                </div>
                <button type="submit" name="admin_login" class="w-full bg-yellow-400 hover:bg-yellow-300 text-black font-black text-xs py-4 px-4 rounded-xl uppercase tracking-widest transition shadow-lg">Verify Key</button>
            </form>
        </div>
    </div>

    <script>
        let currentSelectedRoom = '';
        let currentRoomPrice = 0;

        function toggleSignupModal(show) { document.getElementById('signupModal').classList.toggle('hidden', !show); }
        function toggleLoginModal(show) { document.getElementById('loginModal').classList.toggle('hidden', !show); }

        function startBookingWizard() {
            document.getElementById('welcomeIntroBlock').classList.add('hidden');
            if(document.getElementById('guestOrdersDashboard')) {
                document.getElementById('guestOrdersDashboard').classList.add('hidden');
            }
            document.getElementById('stepProgressTimeline').classList.remove('hidden');
            document.getElementById('roomSection').classList.remove('hidden');
        }

        function goToFoodStep(roomName, price) {
            currentSelectedRoom = roomName;
            currentRoomPrice = price;
            
            document.getElementById('selectedRoomBadge').innerText = roomName;
            document.getElementById('roomSection').classList.add('hidden');
            document.getElementById('foodSection').classList.remove('hidden');
            
            document.getElementById('step1Indicator').className = "text-white/40 flex items-center gap-2";
            document.getElementById('step2Indicator').className = "font-black text-yellow-400 flex items-center gap-2";
            
            calculateLiveTotal();
        }

        function goBackToRooms() {
            document.getElementById('foodSection').classList.add('hidden');
            document.getElementById('roomSection').classList.remove('hidden');
            document.getElementById('step1Indicator').className = "font-black text-yellow-400 flex items-center gap-2";
            document.getElementById('step2Indicator').className = "text-white/40 flex items-center gap-2";
        }

        function calculateLiveTotal() {
            let total = currentRoomPrice;
            const checkboxes = document.querySelectorAll('input[name="food_selection[]"]:checked');
            checkboxes.forEach(box => {
                total += parseFloat(box.getAttribute('data-price'));
            });
            document.getElementById('liveTotalDisplay').innerText = '$' + total.toFixed(2);
        }

        function submitFinalReservation() {
            const selectedFoods = [];
            document.querySelectorAll('input[name="food_selection[]"]:checked').forEach(box => {
                selectedFoods.push(box.value);
            });

            const formData = new FormData();
            formData.append('process_wizard_reservation', '1');
            formData.append('room', currentSelectedRoom);
            formData.append('foods', JSON.stringify(selectedFoods));

            fetch('index.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    alert('Reservation processing successful! Reloading dynamic environment.');
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => console.error('Wizard submission failure:', err));
        }

        // Render Administrative Chart if Element Exists
        document.addEventListener("DOMContentLoaded", function() {
            const chartCanvas = document.getElementById('suiteDistributionPieChart');
            if (chartCanvas) {
                const ctx = chartCanvas.getContext('2d');
                const rawData = <?= json_encode($chart_data) ?>;
                
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: rawData.map(item => item.resort_name),
                        datasets: [{
                            data: rawData.map(item => item.count),
                            backgroundColor: ['#eab308', '#ca8a04', '#854d0e', '#fef08a', '#a16207'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } }
                    }
                });
            }
        });
    </script>
</body>
</html>
