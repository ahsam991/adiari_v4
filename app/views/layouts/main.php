<!DOCTYPE html>
<html lang="<?= Language::current() ?>" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'ADI ARI Fresh'; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= $this->url('/images/favicon.svg') ?>">
    <link rel="shortcut icon" type="image/svg+xml" href="<?= $this->url('/images/favicon.svg') ?>">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&family=Noto+Sans+JP:wght@300;400;500;700&family=Noto+Sans+Devanagari:wght@300;400;500;700&family=Noto+Sans+Bengali:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN (In production, compile and serve locally) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#20df29",
                        "primary-hover": "#1bc423",
                        "background-light": "#f6f8f6",
                        "background-dark": "#112112",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1a2e1b",
                        "text-main-light": "#111712",
                        "text-main-dark": "#e0e6e0",
                        "text-sub-light": "#648765",
                        "text-sub-dark": "#8fa890",
                        "border-light": "#f0f4f1",
                        "border-dark": "#2a422c",
                    },
                    fontFamily: {
                        "display": ["Work Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    
    <style>
        body {
            font-family: 'Work Sans', 'Noto Sans JP', 'Noto Sans Devanagari', 'Noto Sans Bengali', sans-serif;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-text-main-light dark:text-text-main-dark">
    <div class="min-h-screen flex flex-col">
    
    <!-- Top Utility Bar -->
    <div class="bg-surface-light dark:bg-surface-dark border-b border-border-light dark:border-border-dark relative z-[60]">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-10">
            <div class="flex items-center justify-between h-10 py-1">
                <!-- Left Side: Trust Badges / Info -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-1.5 text-xs font-medium text-text-main-light dark:text-text-main-dark">
                        <span class="material-symbols-outlined text-[18px] text-primary">verified_user</span>
                        <span><?= Language::get('halal_certified') ?></span>
                    </div>
                    <div class="h-4 w-px bg-border-light dark:border-border-dark hidden sm:block"></div>
                    <div class="hidden sm:flex items-center gap-1.5 text-xs font-medium text-text-sub-light dark:text-text-sub-dark">
                        <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                        <span><?= Language::get('free_shipping') ?></span>
                    </div>
                </div>
                <!-- Right Side: Utility Links -->
                <div class="flex items-center gap-6">
                    <a class="text-xs font-medium text-text-sub-light hover:text-primary dark:text-text-sub-dark dark:hover:text-primary transition-colors" href="<?= $this->url('/contact') ?>"><?= Language::get('help_center') ?></a>
                    
                    <!-- Language Switcher -->
                    <div class="relative group z-50">
                        <button id="lang-switcher-btn" class="flex items-center gap-2 cursor-pointer focus:outline-none py-1">
                            <span class="material-symbols-outlined text-[18px] text-text-sub-light dark:text-text-sub-dark group-hover:text-primary transition-colors">language</span>
                            <span class="text-xs font-medium text-text-main-light dark:text-text-main-dark group-hover:text-primary transition-colors"><?= Language::label() ?></span>
                            <span class="material-symbols-outlined text-[16px] text-text-sub-light group-hover:text-primary transition-transform group-hover:rotate-180 duration-300">expand_more</span>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="lang-dropdown" class="absolute right-0 top-full mt-0 w-48 bg-white dark:bg-surface-dark rounded-xl shadow-2xl py-3 border border-border-light dark:border-border-dark opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-2 group-hover:translate-y-0 transition-all duration-300 z-[100]">
                            <div class="px-4 py-2 mb-2 border-b border-border-light dark:border-border-dark">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-text-sub-light dark:text-text-sub-dark">Select Language</span>
                            </div>
                            <?php foreach(Language::available() as $code => $label): ?>
                                <a href="<?= $this->url('/language/' . $code) ?>" class="flex items-center justify-between px-4 py-2.5 text-xs hover:bg-primary/5 dark:hover:bg-primary/10 transition-colors <?= Language::current() == $code ? 'text-primary font-bold bg-primary/5' : 'text-text-main-light dark:text-text-main-dark' ?>">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-[16px] <?= Language::current() == $code ? 'text-primary' : 'text-text-sub-light' ?>">Translate</span>
                                        <span><?= $label ?></span>
                                    </div>
                                    <?php if(Language::current() == $code): ?>
                                        <span class="material-symbols-outlined text-[16px] text-primary">check_circle</span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <button class="flex items-center gap-1.5 pl-2 border-l border-border-light dark:border-border-dark text-xs font-bold text-text-main-light dark:text-text-main-dark hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-primary">location_on</span>
                        <span>Tokyo, Japan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Header Bar -->
    <header class="bg-surface-light dark:bg-surface-dark sticky top-0 z-50 shadow-sm border-b border-border-light dark:border-border-dark">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-10 py-4">
            <div class="flex items-center justify-between gap-8">
                <!-- Logo -->
                <a class="flex items-center shrink-0 group" href="<?= $this->url('/') ?>">
                    <img src="<?= $this->url('/images/logo.svg') ?>" alt="ADI ARI - Fresh Vegetables and Halal Food" class="h-10 w-auto sm:h-12 md:h-14 object-contain transition-transform duration-300 group-hover:scale-105" onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 200 60%22%3E%3Ctext x=%2210%22 y=%2240%22 font-family=%22Arial%22 font-size=%2224%22 font-weight=%22bold%22 fill=%22%2322c55e%22%3EADI ARI%3C/text%3E%3C/svg%3E';">
                </a>

                
                <!-- Search Bar (Desktop Only) -->
                <div class="hidden lg:flex flex-1 max-w-2xl relative">
                    <form action="<?= $this->url('/products') ?>" method="GET" class="flex w-full items-center rounded-xl bg-background-light dark:bg-background-dark border border-transparent focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20 transition-all overflow-hidden">
                        <!-- Category Dropdown Trigger -->
                        <button type="button" class="flex items-center gap-2 px-4 py-3 bg-gray-100 dark:bg-[#253626] border-r border-gray-200 dark:border-[#2f4530] text-sm font-semibold text-text-main-light dark:text-text-main-dark hover:bg-gray-200 dark:hover:bg-[#2a3e2b] transition-colors whitespace-nowrap">
                            <span><?= Language::get('all_categories') ?></span>
                            <span class="material-symbols-outlined text-[18px]">expand_more</span>
                        </button>
                        <!-- Input -->
                        <input name="search" class="w-full bg-transparent border-none py-3 px-4 text-sm text-text-main-light dark:text-text-main-dark placeholder:text-text-sub-light dark:placeholder:text-text-sub-dark focus:ring-0" placeholder="<?= Language::get('search_placeholder') ?>" type="text">
                        <!-- Search Button -->
                        <button type="submit" class="p-3 text-text-sub-light hover:text-primary dark:text-text-sub-dark dark:hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[24px]">search</span>
                        </button>
                    </form>
                </div>

                <!-- User Actions -->
                <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                    <!-- Account -->
                    <a href="<?= $this->url(Session::isLoggedIn() ? '/account' : '/login') ?>" class="hidden lg:flex flex-col items-center gap-1 group">
                        <div class="relative p-2 rounded-full hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                            <span class="material-symbols-outlined text-[26px] text-text-main-light dark:text-text-main-dark group-hover:text-primary">person</span>
                        </div>
                        <span class="text-[11px] font-medium text-text-sub-light dark:text-text-sub-dark group-hover:text-primary"><?= Language::get('account') ?></span>
                    </a>
                    
                    <!-- Wishlist -->
                    <a href="<?= $this->url('/wishlist') ?>" class="flex flex-col items-center gap-1 group relative">
                        <div class="relative p-2 rounded-full hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                            <span class="material-symbols-outlined text-[26px] text-text-main-light dark:text-text-main-dark group-hover:text-primary">favorite</span>
                             <!-- <span class="absolute top-1 right-1 size-2 bg-red-500 rounded-full border-2 border-white dark:border-surface-dark"></span> -->
                        </div>
                        <span class="hidden lg:block text-[11px] font-medium text-text-sub-light dark:text-text-sub-dark group-hover:text-primary"><?= Language::get('wishlist') ?></span>
                    </a>
                    
                    <!-- Cart -->
                    <a href="<?= $this->url('/cart') ?>" class="flex items-center gap-3 group bg-background-light dark:bg-background-dark hover:bg-primary/10 pl-2 pr-4 py-1.5 rounded-full border border-transparent hover:border-primary/20 transition-all">
                        <div class="relative">
                            <span class="material-symbols-outlined text-[26px] text-text-main-light dark:text-text-main-dark group-hover:text-primary">shopping_cart</span>
                            <?php
                            $cartCount = 0;
                            $cartSubtotal = 0;
                            if (Session::isLoggedIn()) {
                                try {
                                    require_once __DIR__ . '/../../models/Cart.php';
                                    $cartModel = new Cart();
                                    $cartCount = $cartModel->getCartCount(Session::get('user_id'));
                                    $cartSubtotal = $cartModel->getCartTotals(Session::get('user_id'))['subtotal'];
                                } catch (Throwable $e) {
                                    $cartCount = 0;
                                    $cartSubtotal = 0;
                                }
                            }
                            ?>
                            <span class="absolute -top-1.5 -right-1.5 flex items-center justify-center min-w-[18px] h-[18px] px-1 bg-primary text-white text-[10px] font-bold rounded-full border-2 border-white dark:border-surface-dark"><?= $cartCount ?></span>
                        </div>
                        <div class="hidden sm:flex flex-col items-start">
                            <span class="text-[10px] font-medium text-text-sub-light dark:text-text-sub-dark uppercase"><?= Language::get('my_cart') ?></span>
                            <span class="text-sm font-bold text-text-main-light dark:text-text-main-dark group-hover:text-primary">$<?= number_format($cartSubtotal, 2) ?></span>
                        </div>
                    </a>

                    <!-- Mobile Menu Toggle -->
                    <button onclick="toggleMobileMenu()" aria-label="Open mobile menu" class="md:hidden p-2 text-text-main-light dark:text-text-main-dark hover:bg-background-light dark:hover:bg-background-dark rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-[28px]">menu</span>
                    </button>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Mobile Menu Drawer -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 z-[70] hidden md:hidden" onclick="toggleMobileMenu()"></div>
    <div id="mobile-menu-drawer" class="fixed top-0 right-0 h-full w-[280px] bg-white dark:bg-surface-dark shadow-2xl z-[80] transform translate-x-full transition-transform duration-300 md:hidden overflow-y-auto">
        <div class="flex items-center justify-between p-4 border-b border-border-light dark:border-border-dark">
            <a href="<?= $this->url('/') ?>" onclick="toggleMobileMenu()">
                <img src="<?= $this->url('/images/logo.svg') ?>" alt="ADI ARI" class="h-10 w-auto object-contain">
            </a>
            <button onclick="toggleMobileMenu()" class="p-2 hover:bg-background-light dark:hover:bg-background-dark rounded-lg">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>
        
        <!-- Mobile Search -->
        <div class="p-4 border-b border-border-light dark:border-border-dark">
            <form action="<?= $this->url('/products') ?>" method="GET" class="flex items-center rounded-lg bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700">
                <input name="search" class="flex-1 bg-transparent border-none py-2.5 px-3 text-sm text-text-main-light dark:text-text-main-dark placeholder:text-text-sub-light" placeholder="<?= Language::get('search_placeholder') ?>" type="text">
                <button type="submit" class="p-2.5 text-primary">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </button>
            </form>
        </div>

        <!-- Mobile Categories -->
        <div class="p-4">
            <p class="text-xs font-bold text-text-sub-light dark:text-text-sub-dark uppercase tracking-wider mb-3"><?= Language::get('categories') ?></p>
            <nav class="space-y-1">
                <a href="<?= $this->url('/products?category=vegetables') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                    <span class="material-symbols-outlined text-[20px] text-primary">nutrition</span>
                    <span class="text-sm font-medium"><?= Language::get('vegetables') ?></span>
                </a>
                <a href="<?= $this->url('/products?category=fruits') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                    <span class="material-symbols-outlined text-[20px] text-primary">ios</span>
                    <span class="text-sm font-medium"><?= Language::get('fruits') ?></span>
                </a>
                <a href="<?= $this->url('/products?category=meat') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                    <span class="material-symbols-outlined text-[20px] text-primary">kebab_dining</span>
                    <span class="text-sm font-medium"><?= Language::get('halal_meat') ?></span>
                </a>
                <a href="<?= $this->url('/products?category=dairy') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                    <span class="material-symbols-outlined text-[20px] text-primary">egg_alt</span>
                    <span class="text-sm font-medium"><?= Language::get('dairy_eggs') ?></span>
                </a>
                <a href="<?= $this->url('/products?category=bakery') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                    <span class="material-symbols-outlined text-[20px] text-primary">bakery_dining</span>
                    <span class="text-sm font-medium"><?= Language::get('bakery') ?></span>
                </a>
                <a href="<?= $this->url('/deals') ?>" class="flex items-center gap-3 p-3 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400">
                    <span class="material-symbols-outlined text-[20px] animate-pulse">local_offer</span>
                    <span class="text-sm font-bold"><?= Language::get('weekly_deals') ?></span>
                </a>
            </nav>
        </div>

        <!-- Mobile Account Links -->
        <div class="p-4 border-t border-border-light dark:border-border-dark">
            <p class="text-xs font-bold text-text-sub-light dark:text-text-sub-dark uppercase tracking-wider mb-3"><?= Language::get('account') ?></p>
            <nav class="space-y-1">
                <?php if (Session::isLoggedIn()): ?>
                    <a href="<?= $this->url('/account') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                        <span class="material-symbols-outlined text-[20px] text-primary">person</span>
                        <span class="text-sm font-medium"><?= Language::get('my_account') ?></span>
                    </a>
                    <a href="<?= $this->url('/account/orders') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                        <span class="material-symbols-outlined text-[20px] text-primary">receipt_long</span>
                        <span class="text-sm font-medium"><?= Language::get('orders') ?></span>
                    </a>
                    <a href="<?= $this->url('/wishlist') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                        <span class="material-symbols-outlined text-[20px] text-primary">favorite</span>
                        <span class="text-sm font-medium"><?= Language::get('wishlist') ?></span>
                    </a>
                    <a href="<?= $this->url('/logout') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                        <span class="text-sm font-medium"><?= Language::get('logout') ?></span>
                    </a>
                <?php else: ?>
                    <a href="<?= $this->url('/login') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-background-light dark:hover:bg-background-dark transition-colors">
                        <span class="material-symbols-outlined text-[20px] text-primary">login</span>
                        <span class="text-sm font-medium"><?= Language::get('login') ?></span>
                    </a>
                    <a href="<?= $this->url('/register') ?>" class="flex items-center gap-3 p-3 rounded-lg bg-primary/10 text-primary">
                        <span class="material-symbols-outlined text-[20px]">person_add</span>
                        <span class="text-sm font-bold"><?= Language::get('register') ?></span>
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </div>

    <!-- Navigation Bar (Mega Menu) -->
    <?php 
    // Get current category from URL
    $currentCategory = isset($_GET['category']) ? $_GET['category'] : '';
    $currentPath = $_SERVER['REQUEST_URI'] ?? '';
    $isDealsPage = strpos($currentPath, '/deals') !== false;
    
    // Helper function to get active classes
    function getCategoryClasses($category, $currentCategory) {
        $isActive = ($category === $currentCategory);
        $activeClasses = 'border-primary text-primary font-bold';
        $inactiveClasses = 'border-transparent hover:border-text-sub-light dark:hover:border-text-sub-dark text-text-sub-light dark:text-text-sub-dark hover:text-text-main-light dark:hover:text-text-main-dark font-medium transition-all';
        return $isActive ? $activeClasses : $inactiveClasses;
    }
    
    function getIconClasses($category, $currentCategory) {
        return ($category === $currentCategory) ? 'filled' : '';
    }
    ?>
    <nav id="mobile-menu" class="bg-white dark:bg-[#162917] border-b border-border-light dark:border-border-dark hidden md:block shadow-sm">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-10">
            <ul class="flex items-center gap-8">
                <li class="group">
                    <a class="flex items-center gap-2 py-4 border-b-[3px] <?= getCategoryClasses('vegetables', $currentCategory) ?> text-sm tracking-wide" href="<?= $this->url('/products?category=vegetables') ?>">
                        <span class="material-symbols-outlined text-[20px] <?= getIconClasses('vegetables', $currentCategory) ?>">nutrition</span>
                        <span><?= Language::get('vegetables') ?></span>
                    </a>
                </li>
                <li class="group">
                    <a class="flex items-center gap-2 py-4 border-b-[3px] <?= getCategoryClasses('fruits', $currentCategory) ?> text-sm tracking-wide" href="<?= $this->url('/products?category=fruits') ?>">
                        <span class="material-symbols-outlined text-[20px] <?= getIconClasses('fruits', $currentCategory) ?>">ios</span>
                        <span><?= Language::get('fruits') ?></span>
                    </a>
                </li>
                <li class="group relative">
                    <a class="flex items-center gap-2 py-4 border-b-[3px] <?= getCategoryClasses('meat', $currentCategory) ?> text-sm tracking-wide" href="<?= $this->url('/products?category=meat') ?>">
                        <span class="material-symbols-outlined text-[20px] <?= getIconClasses('meat', $currentCategory) ?>">kebab_dining</span>
                        <span><?= Language::get('halal_meat') ?></span>
                        <span class="material-symbols-outlined text-[16px] ml-1">expand_more</span>
                    </a>
                    <!-- Mega Menu Dropdown -->
                    <div class="absolute left-0 top-full w-[600px] bg-white dark:bg-surface-dark shadow-xl rounded-b-xl border border-border-light dark:border-border-dark opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-40 transform translate-y-2 group-hover:translate-y-0">
                        <div class="flex p-6 gap-8">
                            <div class="flex-1 space-y-4">
                                <h3 class="font-bold text-text-main-light dark:text-text-main-dark border-b border-border-light dark:border-border-dark pb-2">Beef</h3>
                                <ul class="space-y-2 text-sm text-text-sub-light dark:text-text-sub-dark">
                                    <li><a class="hover:text-primary" href="#">Steaks</a></li>
                                    <li><a class="hover:text-primary" href="#">Ground Beef</a></li>
                                    <li><a class="hover:text-primary" href="#">Roasts</a></li>
                                </ul>
                            </div>
                            <div class="flex-1 space-y-4">
                                <h3 class="font-bold text-text-main-light dark:text-text-main-dark border-b border-border-light dark:border-border-dark pb-2">Chicken</h3>
                                <ul class="space-y-2 text-sm text-text-sub-light dark:text-text-sub-dark">
                                    <li><a class="hover:text-primary" href="#">Whole Chicken</a></li>
                                    <li><a class="hover:text-primary" href="#">Breast</a></li>
                                    <li><a class="hover:text-primary" href="#">Wings</a></li>
                                </ul>
                            </div>
                            <div class="flex-1 space-y-4">
                                <h3 class="font-bold text-text-main-light dark:text-text-main-dark border-b border-border-light dark:border-border-dark pb-2">Lamb</h3>
                                <ul class="space-y-2 text-sm text-text-sub-light dark:text-text-sub-dark">
                                    <li><a class="hover:text-primary" href="#">Chops</a></li>
                                    <li><a class="hover:text-primary" href="#">Leg of Lamb</a></li>
                                    <li><a class="hover:text-primary" href="#">Stew Meat</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="group">
                    <a class="flex items-center gap-2 py-4 border-b-[3px] <?= getCategoryClasses('dairy', $currentCategory) ?> text-sm tracking-wide" href="<?= $this->url('/products?category=dairy') ?>">
                        <span class="material-symbols-outlined text-[20px] <?= getIconClasses('dairy', $currentCategory) ?>">egg_alt</span>
                        <span><?= Language::get('dairy_eggs') ?></span>
                    </a>
                </li>
                <li class="group">
                    <a class="flex items-center gap-2 py-4 border-b-[3px] <?= getCategoryClasses('bakery', $currentCategory) ?> text-sm tracking-wide" href="<?= $this->url('/products?category=bakery') ?>">
                        <span class="material-symbols-outlined text-[20px] <?= getIconClasses('bakery', $currentCategory) ?>">bakery_dining</span>
                        <span><?= Language::get('bakery') ?></span>
                    </a>
                </li>
                <div class="flex-1"></div>
                <li class="group">
                    <a class="flex items-center gap-2 py-2 px-4 rounded-lg <?= $isDealsPage ? 'bg-red-100 dark:bg-red-900/30' : 'bg-red-50 dark:bg-red-900/20' ?> text-red-600 dark:text-red-400 font-bold text-sm tracking-wide hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors" href="<?= $this->url('/deals') ?>">
                        <span class="material-symbols-outlined text-[20px] animate-pulse">local_offer</span>
                        <span><?= Language::get('weekly_deals') ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        <?php echo $content; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-surface-light dark:bg-surface-dark border-t border-border-light dark:border-border-dark mt-auto">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-10 py-8 sm:py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <!-- Company Info -->
                <div class="space-y-4">
                    <img src="<?= $this->url('/images/logo.svg') ?>" alt="ADI ARI Fresh" class="h-12 w-auto object-contain mb-2">
                    <p class="text-sm text-text-sub-light dark:text-text-sub-dark">114-0031 Higashi Tabata 2-3-1 Otsu building 101</p>
                    <p class="text-sm text-text-sub-light dark:text-text-sub-dark">Phone: 080-3408-8044</p>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h3 class="font-bold text-lg"><?= Language::get('quick_links') ?></h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?php echo $this->url('/about'); ?>" class="text-text-sub-light dark:text-text-sub-dark hover:text-primary"><?= Language::get('about') ?></a></li>
                        <li><a href="<?php echo $this->url('/contact'); ?>" class="text-text-sub-light dark:text-text-sub-dark hover:text-primary"><?= Language::get('contact') ?></a></li>
                        <li><a href="<?php echo $this->url('/products'); ?>" class="text-text-sub-light dark:text-text-sub-dark hover:text-primary"><?= Language::get('shop') ?></a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div class="space-y-4">
                    <h3 class="font-bold text-lg"><?= Language::get('customer_service') ?></h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-text-sub-light dark:text-text-sub-dark hover:text-primary"><?= Language::get('faq') ?></a></li>
                        <li><a href="#" class="text-text-sub-light dark:text-text-sub-dark hover:text-primary"><?= Language::get('shipping_info') ?></a></li>
                        <li><a href="#" class="text-text-sub-light dark:text-text-sub-dark hover:text-primary"><?= Language::get('returns') ?></a></li>
                    </ul>
                </div>

                <!-- Location Map -->
                <div class="space-y-4">
                    <h3 class="font-bold text-lg">Our Location</h3>
                    <div class="rounded-lg overflow-hidden shadow-md">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3040.2375887429785!2d139.75845017540416!3d35.74042412672079!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188d001af1c979%3A0xe044a1aded276bfb!2zQURJIEFSSSDnlLDnq68!5e1!3m2!1sen!2sbd!4v1770797299608!5m2!1sen!2sbd" 
                                width="100%" 
                                height="200" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

            <div class="border-t border-border-light dark:border-border-dark mt-8 pt-6 text-center">
                <p class="text-sm text-text-sub-light dark:text-text-sub-dark">&copy; 2026 ADI ARI FRESH. <?= Language::get('copyright') ?></p>
            </div>
        </div>
    </footer>
    </div>

    <!-- Custom Scripts -->
    <script>
    function toggleMobileMenu() {
        const drawer = document.getElementById('mobile-menu-drawer');
        const overlay = document.getElementById('mobile-menu-overlay');
        
        if (drawer && overlay) {
            drawer.classList.toggle('translate-x-full');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }
    }
    </script>
    <script src="<?= $this->url('/js/main.js') ?>"></script>
</body>
</html>
