<?php
/**
 * Home Page View - Mobile Optimized with Professional E-commerce Design
 */
?>

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-green-600 via-green-500 to-emerald-600 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <div class="container mx-auto px-3 sm:px-6 py-8 sm:py-16 md:py-20 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-full mb-4 text-xs sm:text-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="font-medium">100% Halal Certified & Organic</span>
                </div>
                
                <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-3 sm:mb-6">
                    Fresh Vegetables & <span class="text-yellow-300">Halal Food</span> Delivered
                </h1>
                
                <p class="text-sm sm:text-lg md:text-xl mb-4 sm:mb-8 text-green-50">
                    Your trusted source for premium organic vegetables, halal certified meats, and fresh groceries in Tokyo.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start mb-6 sm:mb-12">
                    <a href="<?= $this->url('/products') ?>" class="inline-flex items-center justify-center gap-2 bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                        <span>Shop Now</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="<?= $this->url('/about') ?>" class="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white/20 transition-all">
                        <span>Learn More</span>
                    </a>
                </div>
                
                <!-- Trust Indicators -->
                <div class="grid grid-cols-3 gap-4 max-w-md mx-auto lg:mx-0">
                    <div class="text-center lg:text-left">
                        <div class="text-2xl sm:text-3xl font-bold">5000+</div>
                        <div class="text-xs sm:text-sm text-green-100">Happy Customers</div>
                    </div>
                    <div class="text-center lg:text-left">
                        <div class="text-2xl sm:text-3xl font-bold">100%</div>
                        <div class="text-xs sm:text-sm text-green-100">Halal Certified</div>
                    </div>
                    <div class="text-center lg:text-left">
                        <div class="text-2xl sm:text-3xl font-bold">24/7</div>
                        <div class="text-xs sm:text-sm text-green-100">Support</div>
                    </div>
                </div>
            </div>
            
            <!-- Hero Image Animation -->
            <div class="hidden lg:flex items-center justify-center relative">
                <div class="relative w-[500px] h-[500px] flex items-center justify-center">
                    <!-- Animated Background Circles -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/10 to-white/5 rounded-full blur-[100px] animate-pulse"></div>
                    <div class="absolute inset-16 border-2 border-white/20 rounded-full animate-[spin_40s_linear_infinite]"></div>
                    <div class="absolute inset-32 border border-white/30 rounded-full animate-[spin_30s_linear_infinite_reverse]"></div>

                    <!-- Floating Tomato (Top Left) -->
                    <div class="absolute top-8 left-16 animate-[bounce_6s_ease-in-out_infinite]" style="animation-delay: 0s;">
                        <svg width="90" height="90" viewBox="0 0 100 100" class="drop-shadow-2xl">
                            <defs>
                                <radialGradient id="tomatoGrad" cx="40%" cy="40%">
                                    <stop offset="0%" style="stop-color:#ff6b6b;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#c92a2a;stop-opacity:1" />
                                </radialGradient>
                            </defs>
                            <!-- Tomato body -->
                            <circle cx="50" cy="55" r="35" fill="url(#tomatoGrad)"/>
                            <ellipse cx="50" cy="55" rx="30" ry="35" fill="url(#tomatoGrad)"/>
                            <!-- Stem -->
                            <path d="M 50 20 Q 45 25 50 30 Q 55 25 50 20" fill="#51cf66"/>
                            <ellipse cx="50" cy="25" rx="8" ry="4" fill="#37b24d"/>
                            <!-- Highlight -->
                            <ellipse cx="40" cy="45" rx="12" ry="15" fill="white" opacity="0.3"/>
                        </svg>
                    </div>

                    <!-- Floating Carrot (Top Right) -->
                    <div class="absolute top-20 right-12 animate-[bounce_5s_ease-in-out_infinite]" style="animation-delay: 1s;">
                        <svg width="80" height="100" viewBox="0 0 80 120" class="drop-shadow-2xl rotate-12">
                            <defs>
                                <linearGradient id="carrotGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#ff922b;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#fd7e14;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <!-- Carrot body -->
                            <path d="M 40 40 Q 55 50 55 70 Q 54 90 50 110 Q 45 115 40 110 Q 36 90 35 70 Q 35 50 40 40" fill="url(#carrotGrad)"/>
                            <!-- Green leaves -->
                            <path d="M 35 35 Q 30 20 28 10 L 32 12 Q 35 25 38 35" fill="#51cf66"/>
                            <path d="M 40 35 Q 40 18 42 8 L 44 10 Q 42 22 42 35" fill="#40c057"/>
                            <path d="M 45 35 Q 48 20 52 12 L 50 14 Q 47 25 46 35" fill="#37b24d"/>
                            <!-- Texture lines -->
                            <line x1="38" y1="50" x2="42" y2="52" stroke="#e8590c" stroke-width="1" opacity="0.4"/>
                            <line x1="38" y1="65" x2="42" y2="67" stroke="#e8590c" stroke-width="1" opacity="0.4"/>
                            <line x1="38" y1="80" x2="42" y2="82" stroke="#e8590c" stroke-width="1" opacity="0.4"/>
                        </svg>
                    </div>

                    <!-- Floating Apple (Bottom Left) -->
                    <div class="absolute bottom-20 left-12 animate-[bounce_5.5s_ease-in-out_infinite]" style="animation-delay: 2s;">
                        <svg width="85" height="90" viewBox="0 0 100 100" class="drop-shadow-2xl">
                            <defs>
                                <radialGradient id="appleGrad" cx="35%" cy="35%">
                                    <stop offset="0%" style="stop-color:#ff6b6b;stop-opacity:1" />
                                    <stop offset="50%" style="stop-color:#fa5252;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#e03131;stop-opacity:1" />
                                </radialGradient>
                            </defs>
                            <!-- Apple body -->
                            <path d="M 50 30 Q 35 28 25 40 Q 20 50 25 65 Q 30 78 45 82 Q 55 82 70 78 Q 78 65 75 50 Q 70 35 60 30 Q 55 28 50 30" fill="url(#appleGrad)"/>
                            <!-- Stem -->
                            <rect x="48" y="20" width="4" height="12" fill="#8b4513" rx="2"/>
                            <!-- Leaf -->
                            <ellipse cx="55" cy="25" rx="8" ry="5" fill="#51cf66" transform="rotate(-20 55 25)"/>
                            <!-- Highlight -->
                            <ellipse cx="38" cy="42" rx="15" ry="20" fill="white" opacity="0.25"/>
                        </svg>
                    </div>

                    <!-- Floating Cheese (Bottom Right) -->
                    <div class="absolute bottom-12 right-16 animate-[bounce_4.5s_ease-in-out_infinite]" style="animation-delay: 0.5s;">
                        <svg width="90" height="70" viewBox="0 0 100 80" class="drop-shadow-2xl">
                            <defs>
                                <linearGradient id="cheeseGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#ffe066;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#ffd43b;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <!-- Cheese wedge -->
                            <path d="M 20 60 L 85 60 L 85 30 Q 82 25 75 25 L 20 60" fill="url(#cheeseGrad)" stroke="#fab005" stroke-width="2"/>
                            <!-- Holes -->
                            <ellipse cx="45" cy="50" rx="7" ry="5" fill="#fcc419" opacity="0.6"/>
                            <ellipse cx="65" cy="45" rx="6" ry="4" fill="#fcc419" opacity="0.6"/>
                            <ellipse cx="55" cy="55" rx="5" ry="3" fill="#fcc419" opacity="0.6"/>
                            <ellipse cx="72" cy="52" rx="5" ry="3" fill="#fcc419" opacity="0.6"/>
                            <!-- Highlight -->
                            <path d="M 75 30 L 82 35 L 82 55 L 78 57" fill="white" opacity="0.2"/>
                        </svg>
                    </div>

                    <!-- Central Shopping Basket with gradient -->
                    <div class="relative z-30 bg-gradient-to-br from-white via-white to-green-50 backdrop-blur-sm p-12 rounded-[3rem] shadow-2xl transform hover:scale-110 transition-all duration-500 border-4 border-white/80 hover:border-primary/30">
                        <svg width="120" height="120" viewBox="0 0 100 100" class="drop-shadow-xl">
                            <defs>
                                <linearGradient id="basketGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#51cf66;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#37b24d;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <!-- Basket body -->
                            <path d="M 20 40 L 30 80 Q 35 85 50 85 Q 65 85 70 80 L 80 40 Z" fill="url(#basketGrad)"/>
                            <!-- Basket weave -->
                            <line x1="25" y1="50" x2="75" y2="50" stroke="#2f9e44" stroke-width="1.5" opacity="0.5"/>
                            <line x1="28" y1="60" x2="72" y2="60" stroke="#2f9e44" stroke-width="1.5" opacity="0.5"/>
                            <line x1="30" y1="70" x2="70" y2="70" stroke="#2f9e44" stroke-width="1.5" opacity="0.5"/>
                            <!-- Handle -->
                            <path d="M 30 40 Q 50 15 70 40" fill="none" stroke="url(#basketGrad)" stroke-width="4" stroke-linecap="round"/>
                            <!-- Items in basket -->
                            <circle cx="45" cy="35" r="6" fill="#ff6b6b"/>
                            <circle cx="55" cy="32" r="5" fill="#ffd43b"/>
                            <ellipse cx="50" cy="38" rx="4" ry="3" fill="#51cf66"/>
                        </svg>
                        <div class="absolute -bottom-3 -right-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-yellow-900 text-sm font-black px-4 py-2 rounded-full shadow-lg animate-pulse">
                            FRESH
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action with Newsletter -->
<div class="py-16 sm:py-20 bg-gradient-to-br from-green-600 to-emerald-600 text-white">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6">Ready to Get Started?</h2>
            <p class="text-xl mb-8 text-green-50">Join thousands of happy customers shopping for fresh, healthy groceries</p>
            
            <?php if (!Session::get('logged_in')): ?>
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
                    <a href="/register" class="bg-white text-green-600 px-8 py-4 rounded-xl font-bold hover:bg-green-50 transition-all transform hover:scale-105 shadow-2xl">
                        Create Free Account
                    </a>
                    <a href="/login" class="bg-green-700/50 backdrop-blur-sm border-2 border-white text-white px-8 py-4 rounded-xl font-bold hover:bg-green-700 transition-all">
                        Sign In
                    </a>
                </div>
            <?php else: ?>
                <a href="/products" class="inline-block bg-white text-green-600 px-8 py-4 rounded-xl font-bold hover:bg-green-50 transition-all transform hover:scale-105 shadow-2xl mb-12">
                    Browse Products
                </a>
            <?php endif; ?>
            
            <!-- Newsletter Signup -->
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
                <h3 class="text-2xl font-bold mb-4">Subscribe to Our Newsletter</h3>
                <p class="text-green-100 mb-6">Get weekly deals and exclusive offers delivered to your inbox</p>
                <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    <input type="email" placeholder="Enter your email" class="flex-1 px-6 py-3 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-white" required>
                    <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-8 py-3 rounded-xl font-bold transition-all">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Business Info -->
<div class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Contact Info Card -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">store</span>
                        Visit Our Store
                    </h3>
                    <div class="space-y-4 text-gray-600">
                        <p class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary mt-1">location_on</span>
                            <span class="leading-relaxed">114-0031 Higashi Tabata 2-3-1<br>Otsu building 101, Tokyo, Japan</span>
                        </p>
                        <p class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">phone</span>
                            <span>080-3408-8044</span>
                        </p>
                        <p class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">schedule</span>
                            <span>Open Daily: 8:00 AM - 10:00 PM</span>
                        </p>
                        <p class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">email</span>
                            <span>info@adiarifresh.com</span>
                        </p>
                    </div>
                </div>

                <!-- Quick Links Card -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">link</span>
                        Quick Links
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="/products" class="flex items-center gap-2 text-gray-700 hover:text-primary transition-colors p-3 rounded-lg hover:bg-green-50">
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            <span class="font-medium">Shop All Products</span>
                        </a>
                        <a href="/about" class="flex items-center gap-2 text-gray-700 hover:text-primary transition-colors p-3 rounded-lg hover:bg-green-50">
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            <span class="font-medium">About Us</span>
                        </a>
                        <a href="/contact" class="flex items-center gap-2 text-gray-700 hover:text-primary transition-colors p-3 rounded-lg hover:bg-green-50">
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            <span class="font-medium">Contact Us</span>
                        </a>
                        <?php if (!Session::get('logged_in')): ?>
                            <a href="/register" class="flex items-center gap-2 text-gray-700 hover:text-primary transition-colors p-3 rounded-lg hover:bg-green-50">
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                <span class="font-medium">Create Account</span>
                            </a>
                        <?php else: ?>
                            <a href="/account" class="flex items-center gap-2 text-gray-700 hover:text-primary transition-colors p-3 rounded-lg hover:bg-green-50">
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                <span class="font-medium">My Account</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Demo Notice (Remove in production) -->
<div class="bg-yellow-50 border-t border-b border-yellow-200 py-4">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-center gap-2 flex-wrap">
            <span class="material-symbols-outlined text-yellow-600">info</span>
            <p class="text-sm text-yellow-800">
                <strong>Demo Mode:</strong> This is a development version. 
                <?php if (!Session::get('logged_in')): ?>
                    Try logging in with: <code class="bg-yellow-100 px-2 py-1 rounded">admin@adiarifresh.com</code> / <code class="bg-yellow-100 px-2 py-1 rounded">admin123</code>
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>
