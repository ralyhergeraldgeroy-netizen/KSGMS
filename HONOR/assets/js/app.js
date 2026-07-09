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
        if (data.success) {
            document.getElementById('successPopup').classList.remove('hidden');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => console.error('Wizard submission failure:', err));
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

document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.chartData !== 'undefined') {
        initChart(window.chartData);
    }
});
