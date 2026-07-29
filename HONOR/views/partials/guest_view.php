<?php
/**
 * Guest View Partial
 * @var bool $isGuestLoggedIn
 * @var array $guest_bookings
 * @var array $suites
 * @var array $foods
 * @var string $csrf_token
 */
?>

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
            Begin Luxury Booking Flow
        </button>
    <?php endif; ?>
</div>

<?php if ($isGuestLoggedIn): ?>
    <div id="guestOrdersDashboard" class="max-w-4xl mx-auto bg-neutral-950 border-2 border-yellow-500/30 rounded-2xl p-6 shadow-[0_0_25px_rgba(0,0,0,0.5)]">
        <div class="border-b border-neutral-800 pb-4 mb-4 flex items-center justify-between">
            <h3 class="text-xs font-black tracking-widest uppercase text-yellow-400">Your Architectural Manifest & Orders</h3>
            <span class="text-[10px] font-mono text-neutral-500 uppercase"><?= count($guest_bookings) ?> active logs</span>
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

    <!-- Booking Wizard -->
    <div id="stepProgressTimeline" class="hidden max-w-md mx-auto flex items-center justify-between px-6 py-3 bg-neutral-950 border-2 border-yellow-500/40 rounded-xl text-xs uppercase tracking-widest font-black shadow-[0_0_15px_rgba(234,179,8,0.15)]">
        <div id="step1Indicator" class="text-yellow-400 flex items-center gap-2">
            <span class="w-6 h-6 rounded-full bg-yellow-400 text-black flex items-center justify-center font-black">1</span> Suites
        </div>
        <div class="text-yellow-500/40">➔</div>
        <div id="step2Indicator" class="text-white/40 flex items-center gap-2">
            <span class="w-6 h-6 rounded-full bg-neutral-800 text-white/50 flex items-center justify-center font-bold">2</span> Dining
        </div>
    </div>

    <!-- Room Selection -->
    <section id="roomSection" class="hidden space-y-8 pt-6 border-t-2 border-yellow-500/20">
        <div class="text-center">
            <h2 class="text-xs font-black tracking-widest uppercase text-yellow-400">Step One</h2>
            <p class="text-3xl font-black text-white tracking-tight uppercase">Select Your Sanctuary Base</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($suites as $suite): ?>
                <div class="bg-neutral-950 border-2 border-neutral-800 rounded-2xl p-6 space-y-6 hover:border-yellow-400 transition-all shadow-[0_4px_20px_rgba(0,0,0,0.8)] flex flex-col justify-between">
                    <div class="space-y-4">
                        <?php
$images = [
    'Ocean Oasis Suite' => 'assets/images/ocean-oasis.jpg',
    'Minimalist Skyline' => 'assets/images/minimalist-skyline.jpg',
    'Botanical Sanctuary' => 'assets/images/botanical-sanctuary.jpg',
    'Emerald Canopy Treehouse' => 'assets/images/emerald-canopy.jpg',
    'Sunset Crag Pavilion' => 'assets/images/sunset-crag.jpg'
];
?>

<img
    src="<?= $images[$suite[0]] ?>"
    alt="<?= htmlspecialchars($suite[0]) ?>"
    class="aspect-video w-full object-cover rounded-xl border border-neutral-700/50">
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

    <!-- Food Selection -->
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
            <?php foreach ($foods as $food): ?>
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
                Complete Reservation Plan & Check Out
            </button>
        </div>
    </section>
<?php endif; ?>
