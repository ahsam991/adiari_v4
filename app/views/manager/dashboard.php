<?php
/**
 * Manager Dashboard
 */


$stats = $data['stats'];
?>

<div class="bg-gray-100 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex-shrink-0">
            <div class="p-6">
                <h2 class="text-2xl font-bold tracking-tight">Manager Panel</h2>
                <p class="text-xs text-gray-400 mt-1">ADI ARI Fresh</p>
            </div>
            <nav class="mt-6 px-4 space-y-2">
                <a href="/manager" class="flex items-center px-4 py-3 bg-gray-900 rounded-lg text-white">
                    <span class="material-symbols-outlined mr-3">dashboard</span>
                    Dashboard
                </a>
                <a href="/manager/products" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <span class="material-symbols-outlined mr-3">inventory_2</span>
                    Products
                </a>
                <a href="/manager/categories" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <span class="material-symbols-outlined mr-3">category</span>
                    Categories
                </a>
                <a href="/manager/orders" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <span class="material-symbols-outlined mr-3">shopping_bag</span>
                    Orders
                </a>
                <a href="/manager/inventory" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <span class="material-symbols-outlined mr-3">inventory</span>
                    Inventory
                </a>
                <a href="/logout" class="flex items-center px-4 py-3 text-red-400 hover:bg-red-900/30 hover:text-red-300 rounded-lg mt-8 transition">
                    <span class="material-symbols-outlined mr-3">logout</span>
                    Logout
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <header class="bg-white shadow-sm p-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Welcome, <?= htmlspecialchars(Session::get('user_name')) ?></span>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold">
                        <?= strtoupper(substr(Session::get('user_name'), 0, 1)) ?>
                    </div>
                </div>
            </header>

            <main class="p-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Products -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Products</h3>
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <span class="material-symbols-outlined text-blue-600">inventory_2</span>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-gray-900"><?= number_format($stats['total_products']) ?></div>
                        <p class="text-xs text-green-600 mt-2 flex items-center">
                            <span class="material-symbols-outlined text-sm mr-1">trending_up</span>
                            Active Catalog
                        </p>
                    </div>

                    <!-- Low Stock Alerts -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-500">Low Stock Items</h3>
                            <div class="p-2 bg-red-50 rounded-lg">
                                <span class="material-symbols-outlined text-red-600">warning</span>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-gray-900"><?= number_format($stats['low_stock']) ?></div>
                        <p class="text-xs text-red-600 mt-2 flex items-center">
                            <span class="material-symbols-outlined text-sm mr-1">priority_high</span>
                            Needs Attention
                        </p>
                    </div>

                    <!-- Pending Orders -->
                    <a href="/manager/orders?status=pending" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:border-green-200 transition block">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-500">Pending Orders</h3>
                            <div class="p-2 bg-yellow-50 rounded-lg">
                                <span class="material-symbols-outlined text-yellow-600">shopping_cart</span>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-gray-900"><?= number_format($stats['pending_orders']) ?></div>
                        <p class="text-xs text-yellow-600 mt-2 flex items-center">View orders</p>
                    </a>

                    <!-- Total Revenue (Placeholder) -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 opacity-50">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-500">Today's Revenue</h3>
                            <div class="p-2 bg-green-50 rounded-lg">
                                <span class="material-symbols-outlined text-green-600">payments</span>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-gray-900">¥0</div>
                        <p class="text-xs text-gray-500 mt-2">Coming soon</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="/manager/product/create" class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-green-50 rounded-lg border border-gray-200 hover:border-green-200 transition group">
                                <span class="material-symbols-outlined text-3xl text-gray-600 group-hover:text-green-600 mb-2">add_circle</span>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-green-700">Add Product</span>
                            </a>
                            <a href="/manager/products" class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-blue-50 rounded-lg border border-gray-200 hover:border-blue-200 transition group">
                                <span class="material-symbols-outlined text-3xl text-gray-600 group-hover:text-blue-600 mb-2">edit_note</span>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">Manage Stock</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4">System Status</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Database Connection</span>
                                <span class="text-green-600 font-medium flex items-center"><span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span> Active</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Server Time</span>
                                <span class="text-gray-900"><?= date('Y-m-d H:i:s') ?></span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">PHP Version</span>
                                <span class="text-gray-900"><?= phpversion() ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
