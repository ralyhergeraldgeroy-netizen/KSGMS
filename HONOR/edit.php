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
            total_price = ?
        WHERE id = ?
    ");

    $update->execute([
        $resort,
        $room,
        $food,
        $totalPrice,
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

</head>

<body class="bg-gray-900 flex justify-center items-center min-h-screen overflow-hidden">

<div class="bg-white p-6 rounded-xl w-full max-w-[500px]">

<h2 class="text-2xl font-bold mb-6 text-gray-900">
    Edit Booking
</h2>

<form method="POST">

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


<!-- FOOD -->

<label class="font-bold text-gray-800">
    Food
</label>

<div class="space-y-3 mb-5">

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

</script>

</body>
</html>