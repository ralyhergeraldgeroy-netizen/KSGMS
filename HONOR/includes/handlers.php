<?php
/**
 * POST Request Handlers
 */

require_once __DIR__ . '/../config/constants.php';

function handleWizardReservation($pdo) {
    header('Content-Type: application/json');

    if (empty($_SESSION['guest_user'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthenticated access attempt.']);
        exit;
    }

    global $ROOM_PRICES, $FOOD_PRICES;

    $customer_name = $_SESSION['guest_user'];
    $room_selected = $_POST['room'] ?? '';
    $foods_selected = isset($_POST['foods']) ? json_decode($_POST['foods'], true) : [];

    $base_room_cost = $ROOM_PRICES[$room_selected] ?? 0;
    $gastronomy_cost = 0;

    foreach ($foods_selected as $food_item) {
        if (isset($FOOD_PRICES[$food_item])) {
            $gastronomy_cost += $FOOD_PRICES[$food_item];
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

function handleDeleteBooking($pdo, &$error_message, &$success_message) {
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
