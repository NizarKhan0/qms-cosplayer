<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosQueue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-gradient-to-b from-slate-50 to-slate-100">
    <!-- Hero Section -->
    <section class="relative flex items-center justify-center min-h-screen overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 opacity-90"></div>
        <div class="relative z-10 max-w-4xl px-4 mx-auto text-center">
            <h1 class="mb-6 text-5xl font-bold leading-tight text-white md:text-7xl">
                Transform Your Fan Experience with CosQueue
            </h1>
            <p class="mb-8 text-xl md:text-2xl text-white/90">
                The ultimate queue management system for cosplayers who value their fans' time
            </p>
            <a wire:navigate href="{{ route('mainCosplayers') }}"
                class="relative inline-flex items-center px-8 py-4 text-lg font-semibold text-blue-600 transition-all duration-300 bg-white rounded-full group hover:shadow-xl hover:scale-105">
                Get Started
                <span class="ml-2 transition-transform transform group-hover:translate-x-1">→</span>
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="px-6 py-16">
        <h2 class="mb-10 text-4xl font-bold text-center">How It Works</h2>
        <div class="grid max-w-6xl gap-8 mx-auto sm:grid-cols-2 lg:grid-cols-3">
            <!-- Step 1 -->
            <div
                class="p-6 text-center transition-all duration-300 bg-white rounded-lg shadow-lg hover:shadow-xl hover:scale-105">
                <i class="mb-4 text-4xl text-gradient-to-r from-blue-600 to-purple-600 fas fa-user-plus"></i>
                <h3 class="mb-2 text-xl font-semibold">Create Your Profile</h3>
                <p>Register as a cosplayer and set up your personal profile to showcase your name and persona.</p>
            </div>

            <!-- Step 2 -->
            <div
                class="p-6 text-center transition-all duration-300 bg-white rounded-lg shadow-lg hover:shadow-xl hover:scale-105">
                <i class="mb-4 text-4xl text-gradient-to-r from-blue-600 to-purple-600 fas fa-list-alt"></i>
                <h3 class="mb-2 text-xl font-semibold">Set Up Your Queue</h3>
                <p>Allow fans to join your queue online, view their position, and prepare for their turn seamlessly.</p>
            </div>

            <!-- Step 3 -->
            <div
                class="p-6 text-center transition-all duration-300 bg-white rounded-lg shadow-lg hover:shadow-xl hover:scale-105">
                <i class="mb-4 text-4xl text-gradient-to-r from-blue-600 to-purple-600 fas fa-users"></i>
                <h3 class="mb-2 text-xl font-semibold">Engage With Fans</h3>
                <p>Track your fan interactions, keep the queue moving smoothly, and create memorable experiences.</p>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="px-6 py-16 bg-gray-100">
        <h2 class="mb-10 text-3xl font-bold text-center">Why Use CosQueue?</h2>
        <div class="grid max-w-6xl gap-8 mx-auto md:grid-cols-2 lg:grid-cols-4">
            <div class="p-6 text-center bg-white rounded-lg shadow-lg">
                <i class="mb-4 text-4xl text-gradient-to-r from-blue-600 to-purple-600 fas fa-clock"></i>
                <h3 class="mb-2 text-xl font-semibold">Time Efficiency</h3>
                <p>Spend less time organizing and more time connecting with your fans.</p>
            </div>

            <div class="p-6 text-center bg-white rounded-lg shadow-lg">
                <i class="mb-4 text-4xl text-gradient-to-r from-blue-600 to-purple-600 fas fa-calendar-alt"></i>
                <h3 class="mb-2 text-xl font-semibold">Better Organization</h3>
                <p>Maintain an organized flow and ensure every fan has their moment.</p>
            </div>

            <div class="p-6 text-center bg-white rounded-lg shadow-lg">
                <i class="mb-4 text-4xl text-gradient-to-r from-blue-600 to-purple-600 fas fa-handshake"></i>
                <h3 class="mb-2 text-xl font-semibold">Personalized Interaction</h3>
                <p>Let fans feel valued with a system tailored to their needs.</p>
            </div>

            <div class="p-6 text-center bg-white rounded-lg shadow-lg">
                <i class="mb-4 text-4xl text-gradient-to-r from-blue-600 to-purple-600 fas fa-sync-alt"></i>
                <h3 class="mb-2 text-xl font-semibold">Real-Time Updates</h3>
                <p>Stay informed of your queue status anytime, anywhere.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="px-4 py-20 bg-gradient-to-r from-blue-600 to-purple-600">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="mb-6 text-4xl font-bold text-white">Ready to Transform Your Fan Experience?</h2>
            <p class="mb-8 text-xl text-white/90">Join thousands of cosplayers who've already elevated their fan
                interactions</p>
            <a wire:navigate href="{{ route('mainCosplayers') }}"
                class="inline-block px-8 py-4 text-lg font-semibold text-blue-600 transition-all duration-300 bg-white rounded-full hover:shadow-xl hover:scale-105">
                Get Started for Free
            </a>
        </div>
    </section>
</body>

</html>
