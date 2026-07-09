<?php
/**
 * Admin View Partial
 * @var array $adminData
 * @var string $csrf_token
 */
$total_sales = $adminData['total_sales'] ?? 0;
$bookings = $adminData['bookings'] ?? [];
?>

<div class="flex flex-col min-h-full gap-6">
    <div>
        <h1 class="text-3xl font-bold tracking-tight text-slate-50">Administrative Dashboard</h1>
        <p class="text-xs text-slate-100 mt-1">Real-time operational overview tracking sales performance and asset distribution metrics.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 flex flex-col gap-6">
            <div class="bg-white/90 backdrop-blur-md border border-slate-300 p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300">
                <span class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Gross Collected Revenue</span>
                <span class="text-4xl font-black text-emerald-600">$<?= number_format($total_sales, 2) ?></span>
            </div>
            <div class="bg-white/90 backdrop-blur-md border border-slate-300 p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300">
                <span class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Active Database Entries</span>
                <span class="text-4xl font-black text-slate-900"><?= count($bookings) ?> records</span>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white/90 border border-slate-300 rounded-2xl shadow-xl p-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Resort Suite Distribution Metrics</h3>
            <div class="relative w-full h-[250px] flex items-center justify-center overflow-hidden">
                <canvas id="suiteDistributionPieChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl border border-gray-300 overflow-hidden p-0">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Client Transactions</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs bg-white">
                <thead>
                    <tr class="bg-slate-800 text-white uppercase font-mono border-b border-slate-200">
                        <th class="p-4">ID</th>
                        <th class="p-4">Customer Name</th>
                        <th class="p-4">Suite Assigned</th>
                        <th class="p-4">Food Choices</th>
                        <th class="p-4">Invoice Total</th>
                        <th class="p-4 text-center w-48">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($bookings)): ?>
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">No active choices found inside database.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $row): ?>
                            <tr class="hover:bg-slate-50 transition-all">
                                <td class="p-4 font-mono text-slate-400 font-bold">#<?= $row['id'] ?></td>
                                <td class="p-4 font-bold text-black"><?= htmlspecialchars($row['customer_name']) ?></td>
                                <td class="p-4"><span class="bg-white text-black font-bold px-3 py-1 rounded-lg"><?= htmlspecialchars($row['resort_name']) ?> (Rm <?= $row['room_number'] ?>)</span></td>
                                <td class="p-4 text-slate-600 max-w-[240px] truncate" title="<?= htmlspecialchars($row['food_items'] ?? '') ?>"><?= !empty($row['food_items']) ? htmlspecialchars($row['food_items']) : '<span class="text-gray-300 italic">None</span>' ?></td>
                                <td class="p-4 font-bold text-emerald-600">$<?= number_format($row['total_price'], 2) ?></td>
                                <td class="p-4">
                                    <div class="flex justify-center items-center gap-3">
                                        <a href="edit.php?id=<?= $row['id'] ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-lg shadow transition duration-300">Edit</a>
                                        <form method="POST" onsubmit="return confirm('Purge this record permanently?');">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                            <button type="submit" name="delete_booking" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded-lg shadow transition duration-300">Delete</button>
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
