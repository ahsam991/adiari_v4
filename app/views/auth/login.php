<?php
/**
 * Login Page
 */

$old = Session::getFlash('old') ?? [];
$error = Session::getFlash('error');
$success = Session::getFlash('success');
?>

<div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gradient-to-br from-green-50 to-green-100">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Welcome Back</h1>
            <p class="text-gray-600">Sign in to your ADI ARI Fresh account</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            
            <!-- Error/Success Messages -->
            <?php if ($error): ?>
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                    <p class="text-red-700 font-medium"><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                    <p class="text-green-700 font-medium"><?= htmlspecialchars($success) ?></p>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="/login" method="POST" class="space-y-6">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?= Security::generateCsrfToken() ?>">

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                        required
                        autofocus
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                        required
                    >
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            value="1"
                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="/forgot-password" class="text-primary hover:text-green-600 font-medium transition">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-primary hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg transition transform hover:scale-105 shadow-lg"
                >
                    Sign In
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6 text-center">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Don't have an account?</span>
                    </div>
                </div>
            </div>

            <!-- Register Link -->
            <div class="mt-4 text-center">
                <a href="/register" class="text-primary hover:text-green-600 font-medium transition">
                    Create a new account
                </a>
            </div>
        </div>

        <!-- Demo Credentials (Remove in production) -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <p class="text-sm font-semibold text-yellow-800 mb-2">Demo Accounts:</p>
            <div class="text-xs text-yellow-700 space-y-1">
                <p>• Admin: admin@adiarifresh.com / admin123</p>
                <p>• Manager: manager@adiarifresh.com / manager123</p>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="mt-6 text-center">
            <a href="/" class="text-gray-600 hover:text-gray-900 transition inline-flex items-center">
                <span class="material-symbols-outlined text-sm mr-1">arrow_back</span>
                Back to Home
            </a>
        </div>
    </div>
</div>
