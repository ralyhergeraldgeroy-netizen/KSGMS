<?php
session_start();

require_once 'config/database.php';
require_once 'config/constants.php';
require_once 'includes/functions.php';

if (!isset($_GET['id'])) {
    die("Invalid booking.");
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM bookings WHERE id=?");
$stmt->execute([$id]);
$booking = $stmt->fetch();

if (!$booking) {
    die("Booking not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $resort = $_POST['resort_name'];
    $room = $_POST['room_number'];
    $food = implode(", ", $_POST['food_items'] ?? []);
    $price = $_POST['total_price'];

    $update = $pdo->prepare("
        UPDATE bookings
        SET
            resort_name=?,
            room_number=?,
            food_items=?,
            total_price=?
        WHERE id=?
    ");

    $update->execute([
        $resort,
        $room,
        $food,
        $price,
        $id
    ]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Booking</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-900 flex justify-center items-center min-h-screen">

<div class="bg-white p-8 rounded-xl w-[500px]">

<h2 class="text-2xl font-bold mb-6">Edit Booking</h2>

<form method="POST">

<label class="font-bold">Resort</label>

<label class="font-bold">Resort</label>

<select name="resort_name" class="w-full border p-2 rounded mb-4">

    <option value="Ocean Oasis Suite" <?= $booking['resort_name']=="Ocean Oasis Suite" ? "selected" : "" ?>>
        Ocean Oasis Suite
    </option>

    <option value="Minimalist Skyline" <?= $booking['resort_name']=="Minimalist Skyline" ? "selected" : "" ?>>
        Minimalist Skyline
    </option>

    <option value="Botanical Sanctuary" <?= $booking['resort_name']=="Botanical Sanctuary" ? "selected" : "" ?>>
        Botanical Sanctuary
    </option>

    <option value="Emerald Canopy Treehouse" <?= $booking['resort_name']=="Emerald Canopy Treehouse" ? "selected" : "" ?>>
        Emerald Canopy Treehouse
    </option>

    <option value="Sunset Crag Pavilion" <?= $booking['resort_name']=="Sunset Crag Pavilion" ? "selected" : "" ?>>
        Sunset Crag Pavilion
    </option>

</select>

<label class="font-bold">Room Number</label>

<input
type="number"
name="room_number"
value="<?= $booking['room_number'] ?>"
class="w-full border p-2 rounded mb-4">

<label class="font-bold">Food</label>

<?php
$currentFoods = explode(", ", $booking['food_items']);
?>

<div class="space-y-2 mb-4">

<label class="block">
    <input type="checkbox" name="food_items[]" value="Citrus Seared King Scallops"
    <?= in_array("Citrus Seared King Scallops", $currentFoods) ? "checked" : "" ?>>
    Citrus Seared King Scallops
</label>

<label class="block">
    <input type="checkbox" name="food_items[]" value="Truffle Infused Kelp Ramen"
    <?= in_array("Truffle Infused Kelp Ramen", $currentFoods) ? "checked" : "" ?>>
    Truffle Infused Kelp Ramen
</label>

<label class="block">
    <input type="checkbox" name="food_items[]" value="Glazed Atlantic Cod"
    <?= in_array("Glazed Atlantic Cod", $currentFoods) ? "checked" : "" ?>>
    Glazed Atlantic Cod
</label>

<label class="block">
    <input type="checkbox" name="food_items[]" value="Aged Wagyu Carpaccio"
    <?= in_array("Aged Wagyu Carpaccio", $currentFoods) ? "checked" : "" ?>>
    Aged Wagyu Carpaccio
</label>

</div>

<label class="font-bold">Total Price</label>

<input
type="number"
step="0.01"
name="total_price"
value="<?= $booking['total_price'] ?>"
class="w-full border p-2 rounded mb-6">

<div class="flex gap-3">

<button
type="submit"
class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
Save
</button>

<a
href="index.php"
class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
Cancel
</a>

</div>

</form>

</div>

</body>
</html>