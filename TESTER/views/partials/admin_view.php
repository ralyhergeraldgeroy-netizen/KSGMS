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

                <button type="button"
                onclick="openFoodModal()"
                  class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition text-sm">

               <span>🍴</span>
                     Food Orders

                </button> 


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
                <div class="relative flex items-center">

                    <input
                        type="text"
                        id="topSearch"
                        onkeyup="searchBookings(event)"
                        oninput="showSearchSuggestions()"
                        autocomplete="off"
                        placeholder="Search bookings..."
                        class="w-40 sm:w-52 lg:w-72 px-4 py-2.5 rounded-l-lg bg-white text-slate-800 text-sm outline-none"
                    >

                    <button
                        type="button"
                        onclick="searchBookings()"
                        class="bg-yellow-400 text-black px-4 py-2.5 rounded-r-lg font-bold">
                        🔎
                    </button>

                    <!-- SEARCH SUGGESTIONS DROPDOWN -->
                    <div
                        id="searchSuggestions"
                        class="hidden absolute top-full left-0 mt-1 w-full max-h-72 overflow-y-auto bg-white text-slate-800 rounded-lg shadow-xl border border-slate-200 z-[60]"
                    ></div>

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
                    <div class="px-5 py-4 border-b border-slate-200">

                        <div>

                            <h3 class="font-bold text-slate-800">
                                ▦ Booking Management
                            </h3>

                            <p class="text-xs text-slate-400 mt-1">
                                Manage all customer reservations.
                            </p>

                        </div>

                    </div>


                    <!-- TABLE -->
                    <div class="overflow-x-auto">
                    <table id="bookingsTable" class="w-full text-left border-collapse text-xs bg-white">

                            <thead class="bg-slate-100">

<tr>

    <th class="p-4">
        ID
    </th>

    <th class="p-4">
        Check-in
    </th>

    <th class="p-4">
        Check-out
    </th>

    <th class="p-4">
        Customer Name
    </th>

    <th class="p-4">
        Resort
    </th>

    <th class="p-4">
        Room
    </th>

    <th class="p-4">
        Food Ordered
    </th>

    <th class="p-4">
        Remarks
    </th>

    <th class="p-4">
        Total
    </th>

    <th class="p-4">
        Actions
    </th>

</tr>

</thead>

                            <tbody id="bookingTableBody"
                                class="divide-y divide-slate-200">

                            <?php if (empty($bookings)): ?>

                                <tr>

                                    <td
                                        colspan="10"
                                        class="p-10 text-center text-slate-400"
                                    >
                                        No bookings found.
                                    </td>

                                </tr>

                            <?php else: ?>

                                <?php foreach ($bookings as $row): ?>

                        <tr
                                        class="booking-row hover:bg-slate-50 transition"
                                        data-id="<?= $row['id'] ?>"
                                        data-search="<?= htmlspecialchars(
                                        strtolower(
                                        $row['customer_name'] . ' ' .
                                        $row['resort_name'] . ' ' .
                                        $row['room_number'] . ' ' .
                                        ($row['food_items'] ?? '') . ' ' .
                                        ($row['remarks'] ?? '')
                                                )
                                                ) ?>"
    >

        <!-- ID -->
        <td class="p-4 font-bold text-slate-400">
            #<?= $row['id'] ?>
        </td>


                                        <!-- CHECK-IN -->
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


                                        <!-- CHECK-OUT -->
                                        <td class="p-4 whitespace-nowrap">

                                            <?php if (!empty($row['check_out'])): ?>

                                                <div class="font-semibold text-slate-800">
                                                    <?= date('M d, Y', strtotime($row['check_out'])) ?>
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


                                        <!-- REMARKS -->
                                        <td class="p-4 max-w-[200px]">

                                            <?php if (!empty($row['remarks'])): ?>

                                                <span
                                                    title="<?= htmlspecialchars($row['remarks']) ?>"
                                                    class="text-slate-600"
                                                >
                                                    <?= htmlspecialchars($row['remarks']) ?>
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

 </div>

<!-- FOOD ORDER MODAL -->

<div id="foodModal"
class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">


<div class="bg-white rounded-xl shadow-xl w-11/12 md:w-2/3 max-h-[80vh] overflow-y-auto">


    <div class="flex justify-between items-center px-6 py-4 border-b">

        <h2 class="text-xl font-black text-slate-800">
            🍴 Customer Food Orders
        </h2>


        <button onclick="closeFoodModal()"
        class="text-red-600 font-bold text-xl">
            ✕
        </button>

    </div>



    <div class="p-6">


    <table class="w-full text-left text-sm">


    <thead class="bg-slate-100">

<tr>

    <th class="p-4">
        Name
    </th>

    <th class="p-4">
        Food Order
    </th>

</tr>

</thead>


<tbody>

<?php foreach ($bookings as $row): ?>

<?php if(!empty($row['food_items'])): ?>

<tr class="border-b">

    <td class="p-4 font-bold">
        <?= htmlspecialchars($row['customer_name']) ?>
    </td>


    <td class="p-4">
        <?= htmlspecialchars($row['food_items']) ?>
    </td>

</tr>

<?php endif; ?>

<?php endforeach; ?>

</tbody>





    </div>


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

    const bookingsData = <?= json_encode(array_map(function ($row) {
        return [
            'id' => $row['id'],
            'customer_name' => $row['customer_name'],
            'resort_name' => $row['resort_name'],
            'room_number' => $row['room_number'],
            'total_price' => $row['total_price'],
        ];
    }, $bookings)) ?>;

    function showSearchSuggestions() {

        const topSearch = document.getElementById('topSearch');
        const dropdown = document.getElementById('searchSuggestions');

        if (!topSearch || !dropdown) return;

        const query = topSearch.value.toLowerCase().trim();

        if (!query) {
            dropdown.classList.add('hidden');
            dropdown.innerHTML = '';
            return;
        }

        const matches = bookingsData.filter(function (b) {
            return (
                String(b.customer_name).toLowerCase().includes(query) ||
                String(b.resort_name).toLowerCase().includes(query) ||
                String(b.room_number).toLowerCase().includes(query)
            );
        }).slice(0, 8);

        if (matches.length === 0) {
            dropdown.innerHTML =
                '<div class="p-3 text-sm text-slate-400">No matching bookings.</div>';
            dropdown.classList.remove('hidden');
            return;
        }

        dropdown.innerHTML = matches.map(function (b) {
            return (
                '<div class="p-3 border-b last:border-b-0 border-slate-100 hover:bg-slate-50 cursor-pointer" ' +
                'onclick="selectSearchResult(' + b.id + ')">' +
                    '<div class="font-bold text-sm">' + escapeHtml(b.customer_name) + '</div>' +
                    '<div class="text-xs text-slate-500">' +
                        escapeHtml(b.resort_name) + ' &middot; Room ' + escapeHtml(String(b.room_number)) +
                    '</div>' +
                '</div>'
            );
        }).join('');

        dropdown.classList.remove('hidden');
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function selectSearchResult(bookingId) {

        const topSearch = document.getElementById('topSearch');
        const dropdown = document.getElementById('searchSuggestions');
        const match = bookingsData.find(function (b) { return b.id == bookingId; });

        if (match && topSearch) {
            topSearch.value = match.customer_name;
        }

        if (dropdown) {
            dropdown.classList.add('hidden');
            dropdown.innerHTML = '';
        }

        searchBookings();

        const targetRow = document.querySelector('.booking-row[data-id="' + bookingId + '"]');

        if (targetRow) {
            targetRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
            targetRow.classList.add('ring-2', 'ring-yellow-400');
            setTimeout(function () {
                targetRow.classList.remove('ring-2', 'ring-yellow-400');
            }, 2000);
        }
    }

    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('searchSuggestions');
        const topSearch = document.getElementById('topSearch');
        if (!dropdown || !topSearch) return;
        if (e.target !== topSearch && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    function searchBookings(event) {

        if (event && event.key === 'Enter') {
            event.preventDefault();
        }

        const topSearch =
            document.getElementById('topSearch');

        const searchValue = topSearch ? topSearch.value.toLowerCase().trim() : '';

        const rows =
            document.querySelectorAll('.booking-row');

        let visibleCount = 0;

        rows.forEach(function(row) {

            const searchableText =
                row.getAttribute('data-search') || '';

            if (searchableText.includes(searchValue)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }

        });

        const tbody = document.getElementById('bookingTableBody');
        let noResultsRow = document.getElementById('noResultsRow');

        if (visibleCount === 0 && rows.length > 0) {

            if (!noResultsRow && tbody) {
                noResultsRow = document.createElement('tr');
                noResultsRow.id = 'noResultsRow';
                noResultsRow.innerHTML =
                    '<td colspan="10" class="p-10 text-center text-slate-400">No matching bookings found.</td>';
                tbody.appendChild(noResultsRow);
            } else if (noResultsRow) {
                noResultsRow.style.display = '';
            }

        } else if (noResultsRow) {
            noResultsRow.style.display = 'none';
        }

    }
 
function openFoodModal(){

    let modal = document.getElementById("foodModal");

    if(modal){
        modal.classList.remove("hidden");
    }else{
        alert("Food modal not found");
    }

}


function closeFoodModal(){

    document.getElementById("foodModal")
    .classList.add("hidden");

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