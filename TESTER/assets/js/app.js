/**
 * KSGM Resorts Application JavaScript
 */

let currentSelectedRoom = '';
let currentRoomPrice = 0;

function toggleSignupModal(show) {
    document.getElementById('signupModal').classList.toggle('hidden', !show);
}

function toggleLoginModal(show) {
    document.getElementById('loginModal').classList.toggle('hidden', !show);
}

function toggleCustomerLoginModal(show) {
    document.getElementById('customerLoginModal').classList.toggle('hidden', !show);
}

function startBookingWizard() {
    document.getElementById('welcomeIntroBlock').classList.add('hidden');
    const guestDashboard = document.getElementById('guestOrdersDashboard');
    if (guestDashboard) {
        guestDashboard.classList.add('hidden');
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
    syncCheckoutMin();
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

const MIN_STAY_NIGHTS = 1;
const MAX_STAY_NIGHTS = 365;

let checkinPicker = null;
let checkoutPicker = null;

function initDatePickers() {
    const checkinEl = document.getElementById('checkinDate');
    const checkoutEl = document.getElementById('checkoutDate');
    if (!checkinEl || !checkoutEl || typeof flatpickr === 'undefined') return;
    if (checkinPicker) return; // already initialized

    const today = new Date();
    const tomorrow = new Date();
    tomorrow.setDate(today.getDate() + MIN_STAY_NIGHTS);

    const sharedTheme = {
        dateFormat: 'Y-m-d',
        disableMobile: true,
        appendTo: document.body
    };

    checkoutPicker = flatpickr(checkoutEl, {
        ...sharedTheme,
        minDate: tomorrow,
        maxDate: new Date(new Date().setDate(today.getDate() + MAX_STAY_NIGHTS)),
        defaultDate: tomorrow
    });

    checkinPicker = flatpickr(checkinEl, {
        ...sharedTheme,
        minDate: 'today',
        defaultDate: today,
        onChange: function(selectedDates) {
            if (!selectedDates.length) return;
            syncCheckoutMin(selectedDates[0]);
        }
    });
}

function syncCheckoutMin(checkinDate) {
    const checkinDateInput = document.getElementById('checkinDate');
    if (!checkoutPicker) return;

    const base = checkinDate || (checkinDateInput && checkinDateInput.value ? new Date(checkinDateInput.value + 'T00:00:00') : null);
    if (!base) return;

    const minCheckout = new Date(base);
    minCheckout.setDate(minCheckout.getDate() + MIN_STAY_NIGHTS);

    const maxCheckout = new Date(base);
    maxCheckout.setDate(maxCheckout.getDate() + MAX_STAY_NIGHTS);

    checkoutPicker.set('minDate', minCheckout);
    checkoutPicker.set('maxDate', maxCheckout);

    const currentCheckout = checkoutPicker.selectedDates[0];
    if (!currentCheckout || currentCheckout < minCheckout || currentCheckout > maxCheckout) {
        checkoutPicker.setDate(minCheckout, true);
    }
}

function submitFinalReservation() {
    const checkinDateInput = document.getElementById('checkinDate');
    const checkinDate = checkinDateInput ? checkinDateInput.value : '';

    if (!checkinDate) {
        alert('Please select your preferred check-in date.');
        if (checkinDateInput) checkinDateInput.focus();
        return;
    }

    const todayStr = new Date().toISOString().split('T')[0];
    if (checkinDate < todayStr) {
        alert('Check-in date cannot be in the past.');
        if (checkinDateInput) checkinDateInput.focus();
        return;
    }

    const checkoutDateInput = document.getElementById('checkoutDate');
    const checkoutDate = checkoutDateInput ? checkoutDateInput.value : '';

    if (!checkoutDate) {
        alert('Please select your preferred check-out date.');
        if (checkoutDateInput) checkoutDateInput.focus();
        return;
    }

    if (checkoutDate <= checkinDate) {
        alert('Check-out date must be after the check-in date.');
        if (checkoutDateInput) checkoutDateInput.focus();
        return;
    }

    const nightsRequested = Math.round(
        (new Date(checkoutDate + 'T00:00:00') - new Date(checkinDate + 'T00:00:00')) / 86400000
    );

    if (nightsRequested < MIN_STAY_NIGHTS || nightsRequested > MAX_STAY_NIGHTS) {
        alert('Reservations must be between ' + MIN_STAY_NIGHTS + ' day and ' + MAX_STAY_NIGHTS + ' days (1 year).');
        if (checkoutDateInput) checkoutDateInput.focus();
        return;
    }

    const remarksInput = document.getElementById('specialRequestRemarks');
    const remarks = remarksInput ? remarksInput.value.trim() : '';

    const selectedFoods = [];
    document.querySelectorAll('input[name="food_selection[]"]:checked').forEach(box => {
        selectedFoods.push(box.value);
    });

    const formData = new FormData();
    formData.append('process_wizard_reservation', '1');
    formData.append('room', currentSelectedRoom);
    formData.append('foods', JSON.stringify(selectedFoods));
    formData.append('checkin_date', checkinDate);
    formData.append('checkout_date', checkoutDate);
    formData.append('remarks', remarks);

    fetch('index.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('successPopup').classList.remove('hidden');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => console.error('Wizard submission failure:', err));
}
function showPasswordRules() {
    document.getElementById("passwordRules").classList.remove("hidden");
}

function hidePasswordRules() {
    document.getElementById("passwordRules").classList.add("hidden");
}

function checkPasswordRules() {

    let password = document.getElementById("signupPassword").value;

    let hasUpper = /[A-Z]/.test(password);
    let hasNumber = /[0-9]/.test(password);
    let validLength = password.length <= 16;
    let noSpecial = /^[A-Za-z0-9_]*$/.test(password);

    document.getElementById("ruleUpper").className =
        hasUpper ? "text-green-400" : "text-red-400";
    document.getElementById("ruleUpper").innerHTML =
        (hasUpper ? "✅" : "❌") + " Must contain at least 1 uppercase letter";

    document.getElementById("ruleNumber").className =
        hasNumber ? "text-green-400" : "text-red-400";
    document.getElementById("ruleNumber").innerHTML =
        (hasNumber ? "✅" : "❌") + " Must contain at least 1 number";

    document.getElementById("ruleLength").className =
        validLength ? "text-green-400" : "text-red-400";
    document.getElementById("ruleLength").innerHTML =
        (validLength ? "✅" : "❌") + " Maximum of 16 characters";

    document.getElementById("ruleSpecial").className =
        noSpecial ? "text-green-400" : "text-red-400";
    document.getElementById("ruleSpecial").innerHTML =
        (noSpecial ? "✅" : "❌") + " No special characters (only letters, numbers, and underscore \"_\")";
}

function closePopup() {
    window.location.reload();
}

function initChart(chartData) {
    const chartCanvas = document.getElementById('suiteDistributionPieChart');
    if (!chartCanvas) return;

    const ctx = chartCanvas.getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: chartData.map(item => item.resort_name),
            datasets: [{
                data: chartData.map(item => item.count),
                backgroundColor: ['#7a16ec27', '#15ffb9', '#854d0e', '#fef08a', '#a16207'],
                borderWidth: 0,
                radius: '100%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        font: { size: 10 }
                    }
                }
            }
        }
    });
}

function showPasswordPopup() {
    document.getElementById("passwordPopup").classList.remove("hidden");
}

function closePasswordPopup() {
    const passwordPopup = document.getElementById("passwordPopup");
    const signupModal = document.getElementById("signupModal");

    if (passwordPopup) {
        passwordPopup.classList.add("hidden");
    }

    // Bring the signup form back so the user can fix their password
    if (signupModal) {
        signupModal.classList.remove("hidden");
    }

    // Refocus the password field and clear it for a fresh attempt
    const passwordInput = document.getElementById("signupPassword");
    if (passwordInput) {
        passwordInput.value = '';
        passwordInput.focus();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.chartData !== 'undefined') {
        initChart(window.chartData);
    }
    initDatePickers();
});

function validateSignupPassword() {

    const password = document.getElementById("signupPassword").value;

    // At least 1 uppercase, 1 number, max 16 chars, letters/numbers/underscore only
    const regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z0-9_]{1,16}$/;

    if (!regex.test(password)) {

        // Show popup
        document.getElementById("passwordPopup").classList.remove("hidden");

        // Prevent form submission
        return false;
    }

    // Allow signup
    return true;
}

function showAdminWrongPasswordPopup() {
    const adminModal = document.getElementById('loginModal');
    const wrongPopup = document.getElementById('adminWrongPasswordPopup');

    if (adminModal) {
        adminModal.classList.add('hidden');
    }

    if (wrongPopup) {
        wrongPopup.classList.remove('hidden');
    }
}

function closeAdminWrongPasswordPopup() {
    const wrongPopup = document.getElementById('adminWrongPasswordPopup');
    const adminModal = document.getElementById('loginModal');

    if (wrongPopup) {
        wrongPopup.classList.add('hidden');
    }

    if (adminModal) {
        adminModal.classList.remove('hidden');
    }

    // Clear password after wrong login
    const passwordInput = document.querySelector(
        '#loginModal input[name="admin_password"]'
    );

    if (passwordInput) {
        passwordInput.value = '';
        passwordInput.focus();
    }
}

function searchBookings() {
    const searchInput = document.getElementById("bookingSearch");
    const table = document.getElementById("bookingsTable");

    if (!searchInput || !table) return;

    const searchValue = searchInput.value.toLowerCase().trim();
    const rows = table.querySelectorAll("tbody tr");

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();

        if (text.includes(searchValue)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

// Search while typing
document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("bookingSearch");

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            searchBookings();
        });
    }

});