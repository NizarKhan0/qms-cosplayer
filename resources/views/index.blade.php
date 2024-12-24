<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cosplayer Queue System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen font-sans antialiased bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200">
        <div class="container px-6 py-4 mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-gray-800">CosQueue</a>
                </div>
                <div class="flex items-center space-x-2">
                    <a wire:navigate href="{{ route('register') }}"
                        class="px-6 py-2 text-sm font-medium text-white transition-colors duration-200 bg-teal-600 rounded-md hover:bg-teal-700">
                        Register
                    </a>
                    <a wire:navigate href="{{ route('login') }}"
                        class="px-6 py-2 text-sm font-medium text-teal-600 transition-colors duration-200 border border-teal-600 rounded-md hover:bg-teal-50">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container flex-grow px-4 py-8 mx-auto">
        <h1 class="mb-2 text-2xl font-bold text-center text-gray-800">Cosplayer Queue System</h1>
        <p class="mb-12 text-center text-gray-600">Select a cosplayer to join their queue</p>

        @if (session()->has('success'))
            <div id="success-message"
                class="relative px-4 py-3 mb-4 border rounded-md text-emerald-700 bg-emerald-50 border-emerald-200"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($cosplayers as $cosplayer)
                <div
                    class="group relative flex flex-col h-[160px] overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
                    {{-- Background Gradient Overlay --}}
                    <div class="absolute inset-0 opacity-50 bg-gradient-to-b from-purple-50 via-white to-teal-50"></div>

                    {{-- Content Container --}}
                    <div class="relative flex flex-col items-center justify-between h-full p-4">
                        {{-- Header Section --}}
                        <div class="space-y-3 text-center">
                            <h2 class="text-lg font-bold text-gray-800 transition-colors group-hover:text-teal-600">
                                {{ $cosplayer->cosplayer_name }}
                            </h2>

                            {{-- Queue Counter --}}
                            <div
                                class="inline-flex items-center px-3 py-1.5 bg-gray-50 rounded-md border border-gray-100">
                                <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-600">
                                    Queue: {{ $cosplayer->fan_queues_count ?? 0 }}
                                </span>
                            </div>
                        </div>

                        {{-- Action Button --}}
                        @php
                            $fanQueues = App\Models\FanQueue::whereHas('fan', function ($query) use ($cosplayer) {
                                $query->whereIn('fan_queues.status', ['Pending', 'Queue Now']);
                                $query->where('fan_queues.cosplayer_id', $cosplayer->id);
                            })->exists();
                        @endphp

                        {{-- <a
                            href="{{ route('fans', ['cosplayerSlug' => $cosplayer->slug]) }}"
                            class="w-full px-4 py-2 text-sm font-semibold text-white rounded-md text-center transition-all duration-200
                                {{ $fanQueues
                                    ? 'bg-teal-600 hover:bg-teal-700'
                                    : 'bg-purple-600 hover:bg-purple-700'
                                }}"
                        >
                            {{ $fanQueues ? 'See Your Queue' : 'Join Queue' }}
                        </a> --}}

                        <a wire:navigate href="{{ route('fans', ['cosplayerSlug' => $cosplayer->slug]) }}"
                            class="w-full px-4 py-2 text-sm font-semibold text-white rounded-md text-center transition-all duration-200
        {{ $fanQueues ? 'bg-teal-600 hover:bg-teal-700' : 'bg-teal-400 hover:bg-teal-500' }}">
                            {{ $fanQueues ? 'See Your Queue' : 'Join Queue' }}
                        </a>

                    </div>
                </div>
            @endforeach
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="container px-6 py-4 mx-auto">
            <div class="flex flex-col items-center justify-between md:flex-row">
                <div class="text-sm text-gray-600">
                    © 2024 CosQueue.
                </div>
                <div class="text-sm text-gray-600">
                    Created by <a href="https://nizar-khan.com" target="_blank"
                        class="font-medium text-teal-600 hover:text-teal-700">@NizarKhan</a>
                </div>
            </div>
        </div>
    </footer>

    @if (session()->has('success'))
        <script>
            window.onload = function() {
                const successMessage = document.getElementById('success-message');
                if (successMessage) {
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 5000);
                }
            };
        </script>
    @endif
</body>

</html>
