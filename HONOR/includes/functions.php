<?php
/**
 * Helper Functions
 */

function getGuestBookings($pdo, $username) {
    try {
        $stmt = $pdo->prepare("SELECT id, resort_name, room_number, total_price, food_items, check_in FROM bookings WHERE customer_name = ? ORDER BY id DESC");
        $stmt->execute([$username]);
        return $stmt->fetchAll();
    } catch (\PDOException $e) {
        error_log($e->getMessage());
        return [];
    }
}

function getAdminData($pdo) {
    $data = [
        'total_sales' => 0,
        'bookings' => [],
        'chart_data' => []
    ];

    try {
        $sales_query = $pdo->query("SELECT SUM(total_price) AS grand_total FROM bookings");
        $data['total_sales'] = $sales_query->fetch()['grand_total'] ?? 0;

        $bookings_query = $pdo->query("SELECT id, customer_name, resort_name, room_number, total_price, food_items, check_in FROM bookings ORDER BY id DESC");
        $data['bookings'] = $bookings_query->fetchAll();

        $chart_query = $pdo->query("SELECT resort_name, COUNT(*) as count FROM bookings GROUP BY resort_name");
        $data['chart_data'] = $chart_query->fetchAll();
    } catch (\PDOException $e) {
        error_log($e->getMessage());
    }

    return $data;
}

function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function getSuites() {
    return [
        ['Ocean Oasis Suite', 'Private pool & panoramic ocean viewport', 550],
        ['Minimalist Skyline', 'Monolithic stone interior & elevated terrace', 420],
        ['Botanical Sanctuary', 'Surrounded by organic lush island flora', 310],
        ['Emerald Canopy Treehouse', 'Elevated platform among local redwoods', 360],
        ['Sunset Crag Pavilion', 'West-facing rock bluff alignment', 495]
    ];
}

function getFoods() {
    return [
        ['Citrus Seared King Scallops', 'Served with yuzu foam & volcanic salted glass crisp', 38],
        ['Truffle Infused Kelp Ramen', 'Slow simmered clear dashi broth & greens', 29],
        ['Glazed Atlantic Cod', 'Miso reduction base coated in wild clover honey glaze', 42],
        ['Aged Wagyu Carpaccio', 'Ultra-thin shaved prime cut with olive reduction', 55]
    ];
}
