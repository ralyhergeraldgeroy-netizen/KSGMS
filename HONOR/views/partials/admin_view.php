<?php
/**
 * KSGM Professional Admin Dashboard
 */

$total_sales = $adminData['total_sales'] ?? 0;
$bookings = $adminData['bookings'] ?? [];
$chart_data = $adminData['chart_data'] ?? [];

$totalBookings = count($bookings);

$todayBookings = 0;
$totalFoodOrders = 0;

foreach ($bookings as $row) {

    if (
        !empty($row['check_in']) &&
        date('Y-m-d', strtotime($row['check_in'])) === date('Y-m-d')
    ) {
        $todayBookings++;
    }

    if (!empty($row['food_items'])) {
        $foods = array_filter(explode(', ', $row['food_items']));
        $totalFoodOrders += count($foods);
    }
}
?>

<div class="min-h-screen -m-6 flex bg-slate-100 text-slate-800">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-slate-900 text-white flex-shrink-0 hidden md:flex flex-col">

        <!-- BRAND -->
        <div class="h-20 flex items-center px-6 border-b border-slate-700">
            <div>
                <h1 class="text-2xl font-black tracking-widest text-yellow-400">
                    KSGM
                </h1>

                <p class="text-[9px] text-slate-400 uppercase tracking-[0.25em]">
                    Resorts Management
                </p>
            </div>
        </div>

        <!-- MENU -->
        <div class="flex-1 px-4 py-6">

            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest px-3 mb-3">
                Core
            </p>

            <a href="#dashboard"
               class="flex items-center gap-3 px-4 py-3 rounded-lg bg-yellow-400 text-black font-bold text-sm mb-2">
                <span>▣</span>
                Dashboard
            </a>


            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest px-3 mt-7 mb-3">
                Management
            </p>

            <a href="#bookings"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition text-sm">
                <span>▤</span>
                Bookings
            </a>

            <a href="#resorts"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition text-sm">
                <span>⌂</span>
                Resorts
            </a>

            <a href="#food"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition text-sm">
                <span>🍴</span>
                Food Orders
            </a>


            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest px-3 mt-7 mb-3">
                System
            </p>

            <a href="index.php?action=logout"
               class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-red-600 hover:text-white transition text-sm">
                <span>↪</span>
                Logout
            </a>

        </div>


        <!-- SIDEBAR FOOTER -->
        <div class="p-4 border-t border-slate-700">

            <p class="text-[10px] text-slate-500">
                Logged in as:
            </p>

            <p class="text-sm font-bold text-yellow-400 mt-1">
                Administrator
            </p>

        </div>

    </aside>


    <!-- MAIN CONTENT -->
    <section class="flex-1 min-w-0">

        <!-- MOBILE / TOP HEADER -->
        <header class="h-20 bg-slate-800 text-white flex items-center justify-between px-5 md:px-8 shadow-lg">

            <div class="flex items-center gap-4">

                <div class="md:hidden text-yellow-400 text-xl">
                    ☰
                </div>

                <div>
                    <p class="text-xs text-slate-400">
                        KSGM RESORTS
                    </p>

                    <p class="font-bold">
                        Administrative Panel
                    </p>
                </div>

            </div>


            <!-- SEARCH -->
            <div class="hidden sm:flex items-center">

                <input
                    type="text"
                    id="topSearch"
                    onkeyup="searchBookings()"
                    placeholder="Search bookings..."
                    class="w-52 lg:w-72 px-4 py-2.5 rounded-l-lg bg-white text-slate-800 text-sm outline-none"
                >

                <button
                    type="button"
                    class="bg-yellow-400 text-black px-4 py-2.5 rounded-r-lg font-bold">
                    🔎
                </button>

            </div>

        </header>


        <!-- DASHBOARD CONTENT -->
        <main id="dashboard" class="p-5 md:p-8">

            <!-- TITLE -->
            <div class="mb-6">

                <h1 class="text-3xl md:text-4xl font-black text-slate-900">
                    Dashboard
                </h1>

                <div class="mt-3 bg-slate-200 rounded-lg px-4 py-3 text-sm text-slate-600">
                    Dashboard / Overview
                </div>

            </div>


            <!-- STAT CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

                <!-- REVENUE -->
                <div class="bg-blue-600 text-white rounded-lg shadow-lg overflow-hidden">

                    <div class="p-5">

                        <p class="text-sm font-semibold opacity-90">
                            Total Revenue
                        </p>

                        <h2 class="text-3xl font-black mt-2">
                            $<?= number_format($total_sales, 2) ?>
                        </h2>

                    </div>

                    <div class="bg-blue-700 px-5 py-3 text-sm font-semibold">
                        Gross collected revenue
                    </div>

                </div>


                <!-- BOOKINGS -->
                <div class="bg-yellow-500 text-white rounded-lg shadow-lg overflow-hidden">

                    <div class="p-5">

                        <p class="text-sm font-semibold">
                            Total Bookings
                        </p>

                        <h2 class="text-3xl font-black mt-2">
                            <?= $totalBookings ?>
                        </h2>

                    </div>

                    <div class="bg-yellow-600 px-5 py-3 text-sm font-semibold">
                        Active reservations
                    </div>

                </div>


                <!-- TODAY -->
                <div class="bg-green-600 text-white rounded-lg shadow-lg overflow-hidden">

                    <div class="p-5">

                        <p class="text-sm font-semibold">
                            Today's Bookings
                        </p>

                        <h2 class="text-3xl font-black mt-2">
                            <?= $todayBookings ?>
                        </h2>

                    </div>

                    <div class="bg-green-700 px-5 py-3 text-sm font-semibold">
                        Check-ins today
                    </div>

                </div>


                <!-- FOOD -->
                <div class="bg-red-600 text-white rounded-lg shadow-lg overflow-hidden">

                    <div class="p-5">

                        <p class="text-sm font-semibold">
                            Food Orders
                        </p>

                        <h2 class="text-3xl font-black mt-2">
                            <?= $totalFoodOrders ?>
                        </h2>

                    </div>

                    <div class="bg-red-700 px-5 py-3 text-sm font-semibold">
                        Food selections
                    </div>

                </div>

            </div>


            <!-- CHARTS -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">

                <!-- RESORT CHART -->
                <div id="resorts"
                     class="bg-white rounded-lg border border-slate-200 shadow-sm">

                    <div class="px-5 py-4 border-b border-slate-200">

                        <h3 class="font-bold text-slate-800">
                            ◒ Resort Distribution
                        </h3>

                    </div>

                    <div class="p-5">

                        <div class="relative h-[280px]">
                            <canvas id="suiteDistributionPieChart"></canvas>
                        </div>

                    </div>

                </div>


                <!-- BOOKING BAR CHART -->
                <div class="bg-white rounded-lg border border-slate-200 shadow-sm">

                    <div class="px-5 py-4 border-b border-slate-200">

                        <h3 class="font-bold text-slate-800">
                            ▥ Booking Statistics
                        </h3>

                    </div>

                    <div class="p-5">

                        <div class="relative h-[280px]">
                            <canvas id="bookingBarChart"></canvas>
                        </div>

                    </div>

                </div>

            </div>


            <!-- BOOKINGS TABLE -->
            <div id="bookings"
                 class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">

                <!-- TABLE HEADER -->
                <div class="px-5 py-4 border-b border-slate-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    <div>

                        <h3 class="font-bold text-slate-800">
                            ▦ Booking Management
                        </h3>

                        <p class="text-xs text-slate-400 mt-1">
                            Manage all customer reservations.
                        </p>

                    </div>


                    <!-- TABLE SEARCH -->
                    <div class="flex items-center">

                        <span class="text-sm text-slate-600 mr-2">
                            Search:
                        </span>

                        <input
                            type="text"
                            id="tableSearch"
                            onkeyup="searchBookings()"
                            class="border border-slate-300 rounded-lg px-3 py-2 text-sm w-56 outline-none focus:border-blue-500"
                        >

                    </div>

                </div>


                <!-- TABLE -->
                <div class="overflow-x-auto">
                   <table id="bookingsTable" class="w-full text-left border-collapse text-xs bg-white">

                    <table class="w-full text-left text-sm">

                        <thead>

                            <tr class="bg-slate-100 text-slate-600 uppercase text-[11px] tracking-wider">

                                <th class="p-4">
                                    ID
                                </th>

                                <th class="p-4">
                                    Date
                                </th>

                                <th class="p-4">
                                    Customer
                                </th>

                                <th class="p-4">
                                    Resort
                                </th>

                                <th class="p-4">
                                    Room
                                </th>

                                <th class="p-4">
                                    Food
                                </th>

                                <th class="p-4">
                                    Total
                                </th>

                                <th class="p-4 text-center">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody id="bookingTableBody"
                               class="divide-y divide-slate-200">

                        <?php if (empty($bookings)): ?>

                            <tr>

                                <td
                                    colspan="8"
                                    class="p-10 text-center text-slate-400"
                                >
                                    No bookings found.
                                </td>

                            </tr>

                        <?php else: ?>

                            <?php foreach ($bookings as $row): ?>

                       <tr
                                    class="booking-row hover:bg-slate-50 transition"
                                    data-search="<?= htmlspecialchars(
                                    strtolower(
                                    $row['customer_name'] . ' ' .
                                    $row['resort_name'] . ' ' .
                                    $row['room_number'] . ' ' .
                                    ($row['food_items'] ?? '')
                                               )
                                               ) ?>"
>

    <!-- ID -->
    <td class="p-4 font-bold text-slate-400">
        #<?= $row['id'] ?>
    </td>


                                    <!-- DATE -->
                                    <td class="p-4 whitespace-nowrap">

                                        <?php if (!empty($row['check_in'])): ?>

                                            <div class="font-semibold text-slate-800">
                                                <?= date('M d, Y', strtotime($row['check_in'])) ?>
                                            </div>

                                        <?php else: ?>

                                            <span class="text-slate-400">
                                                No date
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- CUSTOMER -->
                                    <td class="p-4">

                                        <span class="font-bold text-slate-800">
                                            <?= htmlspecialchars($row['customer_name']) ?>
                                        </span>

                                    </td>


                                    <!-- RESORT -->
                                    <td class="p-4">

                                        <span class="font-semibold text-slate-700">
                                            <?= htmlspecialchars($row['resort_name']) ?>
                                        </span>

                                    </td>


                                    <!-- ROOM -->
                                    <td class="p-4">

                                        <span class="bg-slate-100 px-3 py-1 rounded-full font-bold text-slate-700">
                                            <?= htmlspecialchars($row['room_number']) ?>
                                        </span>

                                    </td>


                                    <!-- FOOD -->
                                    <td class="p-4 max-w-[220px]">

                                        <?php if (!empty($row['food_items'])): ?>

                                            <span
                                                title="<?= htmlspecialchars($row['food_items']) ?>"
                                                class="text-slate-600"
                                            >
                                                <?= htmlspecialchars($row['food_items']) ?>
                                            </span>

                                        <?php else: ?>

                                            <span class="text-slate-400 italic">
                                                None
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- TOTAL -->
                                    <td class="p-4">

                                        <span class="font-black text-green-600">
                                            $<?= number_format($row['total_price'], 2) ?>
                                        </span>

                                    </td>


                                    <!-- ACTIONS -->
                                    <td class="p-4">

                                        <div class="flex justify-center items-center gap-2">

                                            <a
                                                href="edit.php?id=<?= $row['id'] ?>"
                                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-lg shadow-sm transition"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this booking permanently?');"
                                            >

                                                <input
                                                    type="hidden"
                                                    name="csrf_token"
                                                    value="<?= htmlspecialchars($csrf_token ?? '') ?>"
                                                >

                                                <input
                                                    type="hidden"
                                                    name="booking_id"
                                                    value="<?= $row['id'] ?>"
                                                >

                                                <button
                                                    type="submit"
                                                    name="delete_booking"
                                                    class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded-lg shadow-sm transition"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>


            <!-- FOOTER -->
            <div class="text-center text-xs text-slate-400 mt-6">

                KSGM Resorts Management System © <?= date('Y') ?>

            </div>

        </main>

    </section>

</div>


<script>

/* ==========================================
   BOOKING SEARCH
========================================== */

function searchBookings() {

    const tableSearch =
        document.getElementById('tableSearch');

    const topSearch =
        document.getElementById('topSearch');

    let searchValue = '';

    if (tableSearch && tableSearch.value) {
        searchValue = tableSearch.value.toLowerCase().trim();
    } 
    else if (topSearch && topSearch.value) {
        searchValue = topSearch.value.toLowerCase().trim();
    }

    const rows =
        document.querySelectorAll('.booking-row');

    rows.forEach(function(row) {

        const searchableText =
            row.getAttribute('data-search') || '';

        if (searchableText.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }

    });

}


/* ==========================================
   BOOKING BAR CHART
========================================== */

document.addEventListener('DOMContentLoaded', function() {

    const canvas =
        document.getElementById('bookingBarChart');

    if (!canvas) return;

    const data =
        <?= json_encode($chart_data) ?>;

    const labels =
        data.map(item => item.resort_name);

    const values =
        data.map(item => Number(item.count));


    new Chart(canvas, {

        type: 'bar',

        data: {

            labels: labels,

            datasets: [{

                label: 'Bookings',

                data: values,

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    }

                }

            }

        }

    });

});

</script>