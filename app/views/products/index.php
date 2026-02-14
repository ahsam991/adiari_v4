<?php
/**
 * Product Listing Page
 */
$products = $data['products'];
$categories = $data['categories'];
$currentCategory = $data['currentCategory'] ?? null;
$currentPage = $data['currentPage'];
$totalPages = $data['totalPages'];
$sort = $data['sort'];
$search = $data['search'] ?? '';
$totalProducts = $data['totalProducts'];

// Helper to build URL with query params
function buildUrl($params) {
    $currentParams = $_GET;
    $newParams = array_merge($currentParams, $params);
    return '?' . http_build_query($newParams);
}
?>

<div class="bg-background-light dark:bg-background-dark pb-8 sm:pb-12">
    <!-- Page Heading -->
    <div class="px-4 sm:px-5 pt-4 sm:pt-6 pb-2">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2 text-[#648765] dark:text-gray-400 text-xs sm:text-sm font-medium">
                <span class="material-symbols-outlined text-[16px] sm:text-[18px]">verified</span>
                <span>Halal Certified</span>
            </div>
            <h1 class="text-[#111712] dark:text-white tracking-tight text-2xl sm:text-3xl font-bold leading-tight">
                <?= $currentCategory ? htmlspecialchars($currentCategory['name']) : 'All Products' ?>
            </h1>
            <p class="text-[#648765] dark:text-gray-400 text-xs sm:text-sm font-normal leading-normal">
                <?= $search ? 'Search results for: ' . htmlspecialchars($search) : 'Locally sourced organic produce delivered daily.' ?>
            </p>
        </div>
    </div>

    <!-- Categories Scroll -->
    <div class="flex gap-2 overflow-x-auto px-4 sm:px-5 py-3 sm:py-4 no-scrollbar">
        <a href="<?= $this->url('/products') ?>" class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-bold <?= (!$currentCategory && !$search) ? 'bg-primary text-[#111712]' : 'bg-[#f0f4f1] dark:bg-white/10 text-[#111712] dark:text-white hover:bg-primary/20' ?>">
            All
        </a>
        <?php foreach ($categories as $category): ?>
            <a href="<?= $this->url('/products?category=' . $category['id']) ?>" class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-medium <?= ($currentCategory && $currentCategory['id'] == $category['id']) ? 'bg-primary text-[#111712]' : 'bg-[#f0f4f1] dark:bg-white/10 text-[#111712] dark:text-white hover:bg-primary/20' ?>">
                <?= htmlspecialchars($category['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Product Grid -->
    <?php if (empty($products)): ?>
        <div class="px-4 sm:px-5 py-8 sm:py-12 text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <span class="material-symbols-outlined text-3xl sm:text-4xl text-gray-400">inventory_2</span>
            </div>
            <h3 class="text-lg sm:text-xl font-medium text-gray-900 mb-2">No Products Found</h3>
            <p class="text-sm sm:text-base text-gray-500 mb-4 sm:mb-6">Try adjusting your search or filter to find what you're looking for.</p>
            <a href="<?= $this->url('/products') ?>" class="inline-block bg-primary text-white px-5 sm:px-6 py-2 rounded-lg hover:bg-green-700 transition text-sm sm:text-base">
                Clear Filters
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 px-4 sm:px-5 pb-5">
            <?php foreach ($products as $product): ?>
                <div class="group flex flex-col gap-3">
                    <div class="relative w-full aspect-[4/5] bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden">
                        <img src="<?= htmlspecialchars($product['primary_image'] ? (str_starts_with($product['primary_image'], 'http') || str_starts_with($product['primary_image'], '/') ? $product['primary_image'] : '/uploads/products/' . $product['primary_image']) : 'https://placehold.co/400x500?text=Product') ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                             onerror="this.onerror=null;this.src='https://placehold.co/400x500?text=No+Image';">
                        
                        <form action="<?= $this->url('/cart/add') ?>" method="POST" class="absolute bottom-3 right-3">
                             <?= Security::getCsrfField() ?>
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="size-10 flex items-center justify-center bg-white dark:bg-[#1a2c1b] rounded-full shadow-lg text-primary hover:bg-primary hover:text-[#111712] transition-colors">
                                <span class="material-symbols-outlined">add</span>
                            </button>
                        </form>

                        <?php if (!empty($product['is_on_sale'])): ?>
                            <div class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wide">Sale</div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex flex-col gap-0.5">
                        <div class="flex justify-between items-start">
                            <a href="<?= $this->url('/product/' . $product['id']) ?>" class="text-[#111712] dark:text-white text-base font-bold leading-tight hover:text-primary transition-colors line-clamp-1">
                                <?= htmlspecialchars($product['name']) ?>
                            </a>
                        </div>
                        <div class="flex items-center gap-2">
                            <p class="text-primary font-bold">¥<?= number_format($product['is_on_sale'] ? $product['sale_price'] : $product['price']) ?></p>
                            <?php if (!empty($product['weight'])): ?>
                                <p class="text-[#648765] dark:text-gray-500 text-xs font-normal">/ <?= htmlspecialchars($product['weight']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <!-- Floating Filter Button -->
    <div class="fixed bottom-24 left-1/2 -translate-x-1/2 z-40">
        <button onclick="document.getElementById('filterModal').classList.remove('hidden')" class="flex items-center justify-center rounded-full h-12 px-6 bg-[#111712] dark:bg-primary text-white dark:text-[#111712] text-sm font-bold shadow-xl gap-2 hover:scale-105 transition-transform">
            <span class="material-symbols-outlined text-[20px]">tune</span>
            <span>Filter</span>
        </button>
    </div>
</div>

<!-- Simple Filter Modal Placeholder -->
<div id="filterModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex justify-center items-end sm:items-center">
    <div class="bg-white dark:bg-[#1a2c1b] w-full max-w-md p-6 rounded-t-xl sm:rounded-xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold">Filters</h3>
            <button onclick="document.getElementById('filterModal').classList.add('hidden')" class="p-2 text-gray-500 hover:text-gray-700">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <!-- Sort Options -->
        <div class="space-y-4 mb-6">
            <h4 class="font-medium text-sm text-gray-500">Sort By</h4>
            <div class="flex flex-wrap gap-2">
                <a href="<?= buildUrl(['sort' => 'newest']) ?>" class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-white/10 text-sm">Newest</a>
                <a href="<?= buildUrl(['sort' => 'price_asc']) ?>" class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-white/10 text-sm">Price: Low to High</a>
                <a href="<?= buildUrl(['sort' => 'price_desc']) ?>" class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-white/10 text-sm">Price: High to Low</a>
            </div>
        </div>
        <button onclick="document.getElementById('filterModal').classList.add('hidden')" class="w-full bg-primary text-white py-3 rounded-lg font-bold">Apply Filters</button>
    </div>
</div>
