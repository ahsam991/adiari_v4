<?php
/**
 * Manager Product List
 */
$products = $data['products'];
$currentPage = $data['currentPage'];
$totalPages = $data['totalPages'];
$search = $data['search'];
?>

<div class="bg-gray-100 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar (Reused) -->
        <aside class="w-64 bg-gray-800 text-white flex-shrink-0">
            <div class="p-6">
                <h2 class="text-2xl font-bold tracking-tight">Manager Panel</h2>
                <p class="text-xs text-gray-400 mt-1">ADI ARI Fresh</p>
            </div>
            <nav class="mt-6 px-4 space-y-2">
                <a href="/manager" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <span class="material-symbols-outlined mr-3">dashboard</span>
                    Dashboard
                </a>
                <a href="/manager/products" class="flex items-center px-4 py-3 bg-gray-900 text-white rounded-lg">
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
                <a href="/logout" class="flex items-center px-4 py-3 text-red-400 hover:bg-red-900/30 hover:text-red-300 rounded-lg mt-8 transition">
                    <span class="material-symbols-outlined mr-3">logout</span>
                    Logout
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto flex flex-col">
            <header class="bg-white shadow-sm p-6 flex justify-between items-center z-10">
                <h1 class="text-2xl font-bold text-gray-900">Product Management</h1>
                <a href="/manager/product/create" class="flex items-center bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition shadow-lg transform hover:scale-105">
                    <span class="material-symbols-outlined mr-2">add_circle</span>
                    New Product
                </a>
            </header>

            <main class="flex-1 p-8">
                <?php if (Session::hasFlash('success')): ?>
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg flex items-center shadow-sm">
                        <span class="material-symbols-outlined text-green-500 mr-2">check_circle</span>
                        <p class="text-green-700 font-medium"><?= Session::getFlash('success') ?></p>
                    </div>
                <?php endif; ?>

                <?php if (Session::hasFlash('error')): ?>
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-center shadow-sm">
                        <span class="material-symbols-outlined text-red-500 mr-2">error</span>
                        <p class="text-red-700 font-medium"><?= Session::getFlash('error') ?></p>
                    </div>
                <?php endif; ?>

                <!-- Toolbar -->
                <div class="bg-white rounded-t-xl shadow-sm p-4 border-b border-gray-100 flex justify-between items-center">
                    <form action="/manager/products" method="GET" class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <span class="material-symbols-outlined">search</span>
                        </span>
                        <input 
                            type="text" 
                            name="q" 
                            value="<?= htmlspecialchars($search) ?>" 
                            placeholder="Search products..." 
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 w-64 text-sm"
                        >
                    </form>
                    <div class="text-sm text-gray-500">
                        Showing page <?= $currentPage ?> of <?= $totalPages ?>
                    </div>
                </div>

                <!-- Product Table -->
                <div class="bg-white rounded-b-xl shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        No products found.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($products as $product): ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden">
                                                    <?php if ($product['primary_image']): ?>
                                                        <img src="<?= htmlspecialchars($product['primary_image']) ?>" alt="" class="h-10 w-10 object-cover">
                                                    <?php else: ?>
                                                        <span class="material-symbols-outlined text-gray-400">image</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($product['name']) ?></div>
                                                    <div class="text-xs text-gray-500">SKU: <?= htmlspecialchars($product['sku']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                <?= htmlspecialchars($product['category_name']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ¥<?= number_format($product['price']) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php if ($product['stock_quantity'] <= 5): ?>
                                                <span class="text-red-600 font-bold"><?= $product['stock_quantity'] ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-900"><?= $product['stock_quantity'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php if ($product['status'] === 'active'): ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                            <?php else: ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"><?= ucfirst($product['status']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="/manager/product/<?= $product['id'] ?>/edit" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Edit">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </a>
                                            <form action="/manager/product/<?= $product['id'] ?>/delete" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                <?= Security::getCsrfField() ?>
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                    <span class="material-symbols-outlined text-lg">delete</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="mt-6 flex justify-center">
                        <nav class="flex items-center space-x-2">
                             <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?page=<?= $i ?>&q=<?= urlencode($search) ?>" class="px-4 py-2 border rounded-md text-sm font-medium <?= $i == $currentPage ? 'bg-green-600 text-white border-green-600' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                        </nav>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
</div>
