<?php
/**
 * Contact Us Page
 */
?>

<div class="bg-gray-50 dark:bg-black pb-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-[#20df29] to-green-600 text-white py-16">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Contact Us</h1>
            <p class="text-lg md:text-xl opacity-90">We'd love to hear from you</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-[1280px] mx-auto px-4 sm:px-10 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Contact Information -->
            <div class="bg-white dark:bg-[#111712] rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-8">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-4xl text-[#20df29]">contact_support</span>
                    <h2 class="text-3xl font-bold text-[#111712] dark:text-white">Get In Touch</h2>
                </div>
                <div class="space-y-6">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-2xl text-[#20df29] mt-1">home</span>
                        <div>
                            <h3 class="font-bold mb-1 text-[#111712] dark:text-white">Address</h3>
                            <p class="text-gray-600 dark:text-gray-300">114-0031 Higashi Tabata 2-3-1<br>Otsu building 101<br>Tokyo, Japan</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-2xl text-[#20df29] mt-1">call</span>
                        <div>
                            <h3 class="font-bold mb-1 text-[#111712] dark:text-white">Phone</h3>
                            <p class="text-gray-600 dark:text-gray-300">080-3408-8044</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-2xl text-[#20df29] mt-1">mail</span>
                        <div>
                            <h3 class="font-bold mb-1 text-[#111712] dark:text-white">Email</h3>
                            <p class="text-gray-600 dark:text-gray-300">info@adiarifresh.com</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-2xl text-[#20df29] mt-1">schedule</span>
                        <div>
                            <h3 class="font-bold mb-1 text-[#111712] dark:text-white">Business Hours</h3>
                            <p class="text-gray-600 dark:text-gray-300">Monday - Sunday: 9:00 AM - 9:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map -->
            <div class="bg-white dark:bg-[#111712] rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-8">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-4xl text-[#20df29]">location_on</span>
                    <h2 class="text-3xl font-bold text-[#111712] dark:text-white">Our Location</h2>
                </div>
                <div class="rounded-lg overflow-hidden shadow-md h-[350px]">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3040.2375887429785!2d139.75845017540416!3d35.74042412672079!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188d001af1c979%3A0xe044a1aded276bfb!2zQURJIEFSSSDnlLDnq68!5e1!3m2!1sen!2sbd!4v1770797299608!5m2!1sen!2sbd"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-8 text-center bg-gradient-to-r from-[#20df29] to-green-600 text-white rounded-xl p-8">
            <h2 class="text-2xl font-bold mb-4">Ready to Shop?</h2>
            <p class="mb-6">Explore our wide range of fresh vegetables and halal products</p>
            <a href="/products" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-[#20df29] font-bold rounded-lg hover:bg-gray-100 transition-colors shadow-lg">
                <span class="material-symbols-outlined">shopping_cart</span>
                Start Shopping
            </a>
        </div>
    </div>
</div>
