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

            <input type="text"
       name="username"
       placeholder="Username"
       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
       required
       class="w-full mb-4 px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-lg text-white">

     <input
    type="password"
    name="password"
    placeholder="SECURITY PASSWORD"
    required
    maxlength="16"
    class="w-full mb-4 px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-xl text-white tracking-widest">

            <button type="submit"
                    name="customer_login"
                    class="w-full bg-yellow-400 hover:bg-yellow-300 text-black font-bold py-3 rounded-lg">
                Login
            </button>
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
        <form action="index.php" method="POST" class="space-y-4" novalidate>
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
    <h3 class="text-base font-black text-white tracking-widest uppercase">
        Create Luxury Account
    </h3>
    <p class="text-[10px] text-yellow-400 ...">
        Unlock Asset Allocation Gateways
    </p>
</div>



<form action="index.php" method="POST" class="space-y-4" onsubmit="return validateSignupPassword()">

            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <div class="space-y-3">
                <input type="text" name="username" required placeholder="CHOOSE USERNAME"
                    class="w-full px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-xl text-xs text-white tracking-wider font-bold focus:border-yellow-400 focus:outline-none placeholder-neutral-500">
                <input type="email" name="email" required placeholder="EMAIL ADDRESS"
                    class="w-full px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-xl text-xs text-white tracking-wider font-bold focus:border-yellow-400 focus:outline-none placeholder-neutral-500">
               
                    <input
type="password"
id="signupPassword"
name="password"
placeholder="SECURITY PASSWORD"
required
maxlength="16"
class="w-full px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-xl text-white placeholder-neutral-500">
    

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
        <button
            onclick="if (typeof closePopup === 'function') { closePopup(); } else { document.getElementById('successPopup').classList.add('hidden'); }"
            class="mt-5 bg-yellow-400 text-black px-6 py-2 rounded-lg font-bold">
            OK
        </button>
    </div>
</div>

<!-- Password Requirement Popup (client-side signup validation) -->
<div id="passwordPopup" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-[9999]">
    <div class="bg-black border-2 border-yellow-400 rounded-2xl p-6 w-96">
        <h2 class="text-yellow-400 text-2xl font-bold text-center">
            Invalid Password
        </h2>

        <p class="text-white mt-4">Your password must:</p>

        <ul class="text-white mt-3 space-y-2 list-disc pl-5">
            <li>Contain at least <b>1 uppercase letter</b></li>
            <li>Contain at least <b>1 number</b></li>
            <li>Maximum of <b>16 characters</b></li>
            <li>Use only letters, numbers, and underscore (_)</li>
        </ul>

        <button
            onclick="if (typeof closePasswordPopup === 'function') { closePasswordPopup(); } else { document.getElementById('passwordPopup').classList.add('hidden'); }"
            class="mt-6 w-full bg-yellow-400 text-black font-bold py-3 rounded-lg">
            OK
        </button>
    </div>
</div>

<!-- Admin Wrong Password Popup -->
<div id="adminWrongPasswordPopup"
     class="hidden fixed inset-0 bg-black/80 backdrop-blur-md flex items-center justify-center z-[9999] p-4">

    <div class="bg-black border-2 border-red-500 rounded-2xl p-8 text-center w-full max-w-sm shadow-[0_0_30px_rgba(239,68,68,0.4)]">

        <p class="text-red-400 text-xl font-bold">
            Incorrect password.
        </p>

        <button
            onclick="if (typeof closeAdminWrongPasswordPopup === 'function') { closeAdminWrongPasswordPopup(); } else { document.getElementById('adminWrongPasswordPopup').classList.add('hidden'); }"
            class="mt-6 w-full bg-red-500 hover:bg-red-400 text-white font-bold py-3 rounded-lg transition">
            OK
        </button>

    </div>
</div>