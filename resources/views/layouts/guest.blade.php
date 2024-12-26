<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('title', 'Cosplayer') }} - @yield('title')</title>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-slate-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full px-6 py-4 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
            <!-- Back Button (aligned to the right) -->
            <div class="flex justify-end mb-4">
                <a wire:navigate href="{{ route('mainCosplayers') }}"
                    class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-700">
                    Back
                </a>
            </div>

            <!-- Your main content -->
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>


</html>
