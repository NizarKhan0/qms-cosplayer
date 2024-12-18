<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cosplayer</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

    <!-- Credit Link at the top right -->
    <div class="absolute top-0 right-0 m-4">
        <a href="https://nizar-khan.com" target="_blank"
            class="px-4 py-2 text-sm text-black bg-green-500 rounded-md hover:bg-green-600">
            Developed by: Nizar Khan
        </a>
    </div>


    <div class="container px-4 py-8 mx-auto">
        <h1 class="mb-12 text-4xl font-bold text-center text-gray-800">Select a Cosplayer</h1>

        @if (session()->has('success'))
            <div id="success-message"
                class="relative px-4 py-3 mb-4 text-green-400 bg-green-100 border border-green-100 rounded"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($cosplayers as $cosplayer)
                <div
                    class="overflow-hidden transition-all transform rounded-lg shadow-lg bg-blue-50 hover:scale-105 hover:shadow-xl">
                    <div class="p-6">
                        <div class="flex flex-col items-center">
                            <div class="flex items-center justify-center w-32 h-32 mb-4 bg-gray-200 rounded-full">
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h2 class="mb-4 text-xl font-semibold text-gray-800">{{ $cosplayer->cosplayer_name }}</h2>
                            <a href="{{ route('fans', ['cosplayerId' => $cosplayer->id]) }}"
                                class="w-full px-4 py-2 text-center text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700">
                                Start Queue
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

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
