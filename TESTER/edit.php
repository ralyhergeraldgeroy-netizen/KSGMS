<?php
session_start();

require_once 'config/database.php';
require_once 'config/constants.php';
require_once 'includes/functions.php';

if (!isset($_GET['id'])) {
    die("Invalid booking.");
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->execute([$id]);
$booking = $stmt->fetch();

if (!$booking) {
    die("Booking not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resort = $_POST['resort_name'] ?? '';
    $room = $_POST['room_number'] ?? '';
    $selectedFoods = $_POST['food_items'] ?? [];
    $checkin = $_POST['check_in'] ?? $booking['check_in'];
    $checkout = $_POST['check_out'] ?? $booking['check_out'];
    $remarks = trim($_POST['remarks'] ?? '');

    // Check-out must be a real date after check-in
    if (!empty($checkin) && !empty($checkout) && strtotime($checkout) <= strtotime($checkin)) {
        $checkout = date('Y-m-d', strtotime($checkin . ' +3 days'));
    }

    // Enforce a 1 day - 1 year (365 day) stay length
    if (!empty($checkin) && !empty($checkout)) {
        $nightsRequested = (strtotime($checkout) - strtotime($checkin)) / 86400;
        if ($nightsRequested < 1 || $nightsRequested > 365) {
            $checkout = date('Y-m-d', strtotime($checkin . ' +3 days'));
        }
    }

    if (strlen($remarks) > 500) {
        $remarks = substr($remarks, 0, 500);
    }

    // Calculate room price
    $roomPrice = $ROOM_PRICES[$resort] ?? 0;

    // Calculate food price
    $foodTotal = 0;

    foreach ($selectedFoods as $food) {
        if (isset($FOOD_PRICES[$food])) {
            $foodTotal += $FOOD_PRICES[$food];
        }
    }

    // Final total
    $totalPrice = $roomPrice + $foodTotal;

    $food = implode(", ", $selectedFoods);

    $update = $pdo->prepare("
        UPDATE bookings
        SET
            resort_name = ?,
            room_number = ?,
            food_items = ?,
            total_price = ?,
            check_in = ?,
            check_out = ?,
            remarks = ?
        WHERE id = ?
    ");

    $update->execute([
        $resort,
        $room,
        $food,
        $totalPrice,
        $checkin,
        $checkout,
        $remarks,
        $id
    ]);

    header("Location: index.php");
    exit;
}

$currentFoods = !empty($booking['food_items'])
    ? explode(", ", $booking['food_items'])
    : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Booking</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<body class="bg-gray-900 flex justify-center items-start min-h-screen py-10 px-4 overflow-y-auto">

<div class="bg-white p-6 md:p-8 rounded-xl w-full max-w-7xl">

<h2 class="text-2xl font-bold mb-6 text-gray-900">
    Edit Booking
</h2>

<form method="POST">

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">

<!-- COLUMN 1: BOOKING DETAILS -->
<div>

<!-- RESORT -->

<label class="font-bold text-gray-800">
    Resort / Suite
</label>

<select
    name="resort_name"
    id="resort_name"
    class="w-full border p-2 rounded mb-4"
    onchange="calculateTotal()"
>

<?php foreach ($ROOM_PRICES as $roomName => $roomPrice): ?>

<option
    value="<?= htmlspecialchars($roomName) ?>"
    data-price="<?= $roomPrice ?>"
    <?= $booking['resort_name'] === $roomName ? 'selected' : '' ?>
>
    <?= htmlspecialchars($roomName) ?> — $<?= number_format($roomPrice, 2) ?>
</option>

<?php endforeach; ?>

</select>


<!-- ROOM NUMBER -->

<label class="font-bold text-gray-800">
    Room Number
</label>

<input
    type="number"
    name="room_number"
    value="<?= htmlspecialchars($booking['room_number']) ?>"
    class="w-full border p-2 rounded mb-4"
>


<!-- CHECK-IN DATE -->

<label class="font-bold text-gray-800">
    Check-in Date
</label>

<input
    type="text"
    id="check_in"
    name="check_in"
    autocomplete="off"
    readonly
    value="<?= htmlspecialchars($booking['check_in'] ? date('Y-m-d', strtotime($booking['check_in'])) : '') ?>"
    class="w-full border p-2 rounded mb-4 cursor-pointer bg-white"
>


<!-- CHECK-OUT DATE -->

<label class="font-bold text-gray-800">
    Check-out Date
</label>

<input
    type="text"
    id="check_out"
    name="check_out"
    autocomplete="off"
    readonly
    value="<?= htmlspecialchars($booking['check_out'] ? date('Y-m-d', strtotime($booking['check_out'])) : '') ?>"
    class="w-full border p-2 rounded mb-4 cursor-pointer bg-white"
>


<!-- REMARKS -->

<label class="font-bold text-gray-800">
    Special Request / Remarks
</label>

<textarea
    name="remarks"
    rows="4"
    maxlength="500"
    placeholder="Any special request..."
    class="w-full border p-2 rounded mb-4"
><?= htmlspecialchars($booking['remarks'] ?? '') ?></textarea>

</div>


<!-- COLUMN 2: FOOD -->
<div>

<label class="font-bold text-gray-800">
    Food
</label>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-1 gap-3 mb-5 mt-2">

<?php foreach ($FOOD_PRICES as $foodName => $foodPrice): ?>

<label class="flex items-center justify-between border p-3 rounded">

    <div>

        <input
            type="checkbox"
            name="food_items[]"
            value="<?= htmlspecialchars($foodName) ?>"
            data-price="<?= $foodPrice ?>"
            onchange="calculateTotal()"

            <?= in_array($foodName, $currentFoods) ? 'checked' : '' ?>
        >

        <span class="ml-2">
            <?= htmlspecialchars($foodName) ?>
        </span>

    </div>

    <span class="font-bold text-gray-700">
        $<?= number_format($foodPrice, 2) ?>
    </span>

</label>

<?php endforeach; ?>

</div>

</div>


<!-- COLUMN 3: PRICE + ACTIONS -->
<div>

<!-- PRICE BREAKDOWN -->

<div class="bg-gray-100 rounded-lg p-4 mb-5">

    <div class="flex justify-between mb-2">

        <span class="font-semibold">
            Room Price
        </span>

        <span id="roomPriceDisplay">
            $0.00
        </span>

    </div>


    <div class="flex justify-between mb-2">

        <span class="font-semibold">
            Food Total
        </span>

        <span id="foodPriceDisplay">
            $0.00
        </span>

    </div>


    <hr class="my-3">


    <div class="flex justify-between text-xl font-bold">

        <span>
            Total Price
        </span>

        <span id="totalPriceDisplay">
            $0.00
        </span>

    </div>

</div>


<!-- HIDDEN TOTAL -->

<input
    type="hidden"
    name="total_price"
    id="total_price"
>


<!-- BUTTONS -->

<div class="flex gap-3">

<button
    type="submit"
    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700"
>
    Save Changes
</button>

<a
    href="index.php"
    class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700"
>
    Cancel
</a>

</div>

</div>

</div>

</form>

</div>


<script>

function calculateTotal() {

    // Get selected room
    const roomSelect = document.getElementById('resort_name');

    const selectedRoom =
        roomSelect.options[roomSelect.selectedIndex];

    const roomPrice =
        parseFloat(selectedRoom.dataset.price) || 0;


    // Calculate food
    let foodTotal = 0;

    const foods =
        document.querySelectorAll(
            'input[name="food_items[]"]:checked'
        );

    foods.forEach(function(food) {

        foodTotal +=
            parseFloat(food.dataset.price) || 0;

    });


    // Calculate final total
    const total =
        roomPrice + foodTotal;


    // Display
    document.getElementById('roomPriceDisplay').textContent =
        '$' + roomPrice.toFixed(2);

    document.getElementById('foodPriceDisplay').textContent =
        '$' + foodTotal.toFixed(2);

    document.getElementById('totalPriceDisplay').textContent =
        '$' + total.toFixed(2);


    // Save total to hidden input
    document.getElementById('total_price').value =
        total.toFixed(2);
}


// Calculate when page loads
calculateTotal();

// Calendar-style date pickers for check-in / check-out
const checkInEl = document.getElementById('check_in');
const checkOutEl = document.getElementById('check_out');

const checkOutPicker = flatpickr(checkOutEl, {
    dateFormat: 'Y-m-d'
});

const checkInPicker = flatpickr(checkInEl, {
    dateFormat: 'Y-m-d',
    onChange: function(selectedDates) {
        if (!selectedDates.length) return;
        const minCheckout = new Date(selectedDates[0]);
        minCheckout.setDate(minCheckout.getDate() + 1);
        const maxCheckout = new Date(selectedDates[0]);
        maxCheckout.setDate(maxCheckout.getDate() + 365);

        checkOutPicker.set('minDate', minCheckout);
        checkOutPicker.set('maxDate', maxCheckout);

        const currentCheckout = checkOutPicker.selectedDates[0];
        if (!currentCheckout || currentCheckout < minCheckout || currentCheckout > maxCheckout) {
            checkOutPicker.setDate(minCheckout, true);
        }
    }
});

</script>

</body>
</html>