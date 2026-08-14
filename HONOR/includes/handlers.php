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
    $checkin_date = trim($_POST['checkin_date'] ?? '');
    $remarks = trim($_POST['remarks'] ?? '');

    // Validate the preferred check-in date (required, valid, and not in the past)
    $dateObj = DateTime::createFromFormat('Y-m-d', $checkin_date);
    $isValidDate = $dateObj && $dateObj->format('Y-m-d') === $checkin_date;

    if (!$isValidDate) {
        echo json_encode(['success' => false, 'message' => 'Please select a valid check-in date.']);
        exit;
    }

    $today = new DateTime('today');
    if ($dateObj < $today) {
        echo json_encode(['success' => false, 'message' => 'Check-in date cannot be in the past.']);
        exit;
    }

    // Cap remarks length as a safety net even though the client already limits it
    if (strlen($remarks) > 500) {
        $remarks = substr($remarks, 0, 500);
    }

    $base_room_cost = $ROOM_PRICES[$room_selected] ?? 0;
    $gastronomy_cost = 0;

    foreach ($foods_selected as $food_item) {
        if (isset($FOOD_PRICES[$food_item])) {
            $gastronomy_cost += $FOOD_PRICES[$food_item];
        }
    }

    $total_calculated_invoice = $base_room_cost + $gastronomy_cost;
    $mock_room_number = rand(101, 505);
    $checkout_date = $dateObj->modify('+3 days')->format('Y-m-d');

    try {
        $stmt = $pdo->prepare("INSERT INTO bookings (customer_name, resort_name, room_number, check_in, check_out, total_price, food_items, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $customer_name,
            $room_selected,
            $mock_room_number,
            $checkin_date,
            $checkout_date,
            $total_calculated_invoice,
            implode(", ", $foods_selected),
            $remarks
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