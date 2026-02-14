<?php
/**
 * Homepage
 */
?>

<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-green-600 to-green-500 text-white py-12 sm:py-16 md:py-20">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="max-w-3xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 sm:mb-6">Fresh Vegetables & Halal Food Delivered</h1>
            <p class="text-base sm:text-lg md:text-xl mb-6 sm:mb-8 text-green-50">
                Your trusted source for organic vegetables, halal certified meats, and fresh groceries in Tokyo.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <a href="/products" class="bg-white text-green-600 px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold hover:bg-green-50 transition transform hover:scale-105 shadow-lg text-center">
                    Shop Now
                </a>
                <?php if (!Session::get('logged_in')): ?>
                    <a href="/register" class="border-2 border-white text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition text-center">
                        Sign Up Free
                    </a>
                <?php else: ?>
                    <a href="/account" class="border-2 border-white text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition text-center">
                        My Account
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-12 sm:py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 text-center transform hover:scale-105 transition">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <span class="material-symbols-outlined text-2xl sm:text-3xl text-primary">eco</span>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">100% Organic</h3>
                <p class="text-sm sm:text-base text-gray-600">Fresh organic vegetables sourced from local farms daily</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 text-center transform hover:scale-105 transition">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <span class="material-symbols-outlined text-2xl sm:text-3xl text-primary">verified</span>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">Halal Certified</h3>
                <p class="text-sm sm:text-base text-gray-600">All meat products are 100% halal certified and premium quality</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 text-center transform hover:scale-105 transition">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <span class="material-symbols-outlined text-2xl sm:text-3xl text-primary">local_shipping</span>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">Fast Delivery</h3>
                <p class="text-sm sm:text-base text-gray-600">Same-day delivery available across Tokyo and surrounding areas</p>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="py-12 sm:py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 text-center">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">Ready to Get Started?</h2>
        <p class="text-base sm:text-lg md:text-xl text-gray-600 mb-6 sm:mb-8">Join thousands of happy customers shopping for fresh, healthy groceries</p>
        
        <?php if (!Session::get('logged_in')): ?>
            <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                <a href="/register" class="bg-primary hover:bg-green-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold transition transform hover:scale-105 shadow-lg">
                    Create Account
                </a>
                <a href="/login" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold transition">
                    Sign In
                </a>
            </div>
        <?php else: ?>
            <a href="/products" class="inline-block bg-primary hover:bg-green-600 text-white px-8 py-4 rounded-lg font-semibold transition transform hover:scale-105 shadow-lg">
                Browse Products
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Business Info -->
<div class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Contact Info -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Visit Our Store</h3>
                    <div class="space-y-3 text-gray-600">
                        <p class="flex items-start">
                            <span class="material-symbols-outlined mr-2 text-primary">location_on</span>
                            <span>114-0031 Higashi Tabata 2-3-1<br>Otsu building 101, Tokyo</span>
                        </p>
                        <p class="flex items-center">
                            <span class="material-symbols-outlined mr-2 text-primary">phone</span>
                            <span>080-3408-8044</span>
                        </p>
                        <p class="flex items-center">
                            <span class="material-symbols-outlined mr-2 text-primary">schedule</span>
                            <span>Open Daily: 8:00 AM - 10:00 PM</span>
                        </p>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Quick Links</h3>
                    <div class="space-y-2">
                        <a href="/products" class="block text-primary hover:text-green-600 transition">
                            → Shop All Products
                        </a>
                        <a href="/about" class="block text-primary hover:text-green-600 transition">
                            → About Us
                        </a>
                        <a href="/contact" class="block text-primary hover:text-green-600 transition">
                            → Contact Us
                        </a>
                        <?php if (!Session::get('logged_in')): ?>
                            <a href="/register" class="block text-primary hover:text-green-600 transition">
                                → Create Account
                            </a>
                        <?php else: ?>
                            <a href="/account" class="block text-primary hover:text-green-600 transition">
                                → My Account
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
        <div class="flex items-center justify-center">
            <span class="material-symbols-outlined text-yellow-600 mr-2">info</span>
            <p class="text-sm text-yellow-800">
                <strong>Demo Mode:</strong> This is a development version. 
                <?php if (!Session::get('logged_in')): ?>
                    Try logging in with: <code class="bg-yellow-100 px-2 py-1 rounded">admin@adiarifresh.com</code> / <code class="bg-yellow-100 px-2 py-1 rounded">admin123</code>
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>
