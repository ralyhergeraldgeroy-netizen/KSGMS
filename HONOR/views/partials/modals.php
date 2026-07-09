<?php
/**
 * Modal Partials
 * @var string $csrf_token
 */
?>

<!-- Customer Login Modal -->
<div id="customerLoginModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-md z-50 flex items-center justify-center p-4">
    <div class="bg-black border-2 border-yellow-500 p-8 rounded-2xl w-full max-w-md relative">
        <button onclick="toggleCustomerLoginModal(false)" class="absolute top-4 right-5 text-yellow-400 text-2xl">&times;</button>
        <h2 class="text-white text-center text-2xl font-bold mb-6">Customer Login</h2>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input type="text" name="username" placeholder="Username" required
                class="w-full mb-4 px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-lg text-white">
            <input type="password" name="password" placeholder="Password" required
                class="w-full mb-4 px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-lg text-white">
            <button type="submit" name="customer_login"
                class="w-full bg-yellow-400 hover:bg-yellow-300 text-black font-bold py-3 rounded-lg">Login</button>
        </form>
    </div>
</div>

<!-- Admin Login Modal -->
<div id="loginModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-md z-50 flex items-center justify-center p-4">
    <div class="bg-black border-2 border-yellow-500 p-8 rounded-2xl shadow-[0_0_30px_rgba(234,179,8,0.4)] w-full max-w-[400px] space-y-6 relative">
        <button onclick="toggleLoginModal(false)" class="absolute top-4 right-5 text-yellow-400 hover:text-white font-light text-2xl">&times;</button>
        <div class="text-center">
            <h3 class="text-base font-black text-white tracking-widest uppercase">Admin Gateway</h3>
            <p class="text-[10px] text-yellow-400 tracking-wider uppercase font-bold mt-1">Identity Verification Required</p>
        </div>
        <form action="index.php" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <div class="space-y-3">
                <input type="password" name="admin_password" required placeholder="ENTER ADMIN KEY"
                    class="w-full px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-xl text-xs text-white tracking-widest text-center focus:border-yellow-400 focus:outline-none placeholder-neutral-500">
            </div>
            <button type="submit" name="admin_login"
                class="w-full bg-yellow-400 hover:bg-yellow-300 text-black font-black text-xs py-4 px-4 rounded-xl uppercase tracking-widest transition shadow-lg">Verify Key</button>
        </form>
    </div>
</div>

<!-- Signup Modal -->
<div id="signupModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-md z-50 flex items-center justify-center p-4">
    <div class="bg-black border-2 border-yellow-500 p-8 rounded-2xl shadow-[0_0_30px_rgba(234,179,8,0.4)] w-full max-w-[400px] space-y-6 relative">
        <button onclick="toggleSignupModal(false)" class="absolute top-4 right-5 text-yellow-400 hover:text-white font-light text-2xl">&times;</button>
        <div class="text-center">
            <h3 class="text-base font-black text-white tracking-widest uppercase">Create Luxury Account</h3>
            <p class="text-[10px] text-yellow-400 tracking-wider uppercase font-bold mt-1">Unlock Asset Allocation Gateways</p>
        </div>
        <form action="index.php" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <div class="space-y-3">
                <input type="text" name="username" required placeholder="CHOOSE USERNAME"
                    class="w-full px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-xl text-xs text-white tracking-wider font-bold focus:border-yellow-400 focus:outline-none placeholder-neutral-500">
                <input type="email" name="email" required placeholder="EMAIL ADDRESS"
                    class="w-full px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-xl text-xs text-white tracking-wider font-bold focus:border-yellow-400 focus:outline-none placeholder-neutral-500">
                <input type="password" name="password" required pattern="[A-Za-z]+"
                    title="Password must contain letters only. Numbers are not allowed."
                    placeholder="SECURITY PASSWORD"
                    class="w-full px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-xl text-xs text-white tracking-widest focus:border-yellow-400 focus:outline-none placeholder-neutral-500">
            </div>
            <button type="submit" name="guest_signup"
                class="w-full bg-yellow-400 hover:bg-yellow-300 text-black font-black text-xs py-4 px-4 rounded-xl uppercase tracking-widest transition shadow-lg">Register & Login</button>
        </form>
    </div>
</div>

<!-- Success Popup -->
<div id="successPopup" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-black border-2 border-yellow-400 rounded-xl p-8 text-center w-96">
        <h2 class="text-yellow-400 text-2xl font-bold">Success!</h2>
        <p class="text-white mt-3">Reservation processed successfully.</p>
        <button onclick="closePopup()" class="mt-5 bg-yellow-400 text-black px-6 py-2 rounded-lg font-bold">OK</button>
    </div>
</div>
