
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            {{-- <livewire:layout.navigation /> --}}

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- untuk role_id = 3 sahaja sebab unutk display cospalyer --}}

            <!-- Page Content -->
            <main>
                <div class="bg-black text-gray-100 text-[15px]">
                    <div class="font-[sans-serif] bg-gray-100">
                        <div class="p-4 mx-auto lg:max-w-7xl sm:max-w-full">
                            <h2 class="mb-12 text-4xl font-extrabold text-center text-gray-800">Cosplayer Queue List</h2>

                            @foreach ($cosplayers as $cos)


                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 max-xl:gap-4">
                                <div class="relative p-5 transition-all bg-white cursor-pointer rounded-2xl hover:-translate-y-2">
                                    <div
                                        class="absolute flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full cursor-pointer top-4 right-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" class="inline-block fill-gray-800"
                                            viewBox="0 0 64 64">
                                            <path
                                                d="M45.5 4A18.53 18.53 0 0 0 32 9.86 18.5 18.5 0 0 0 0 22.5C0 40.92 29.71 59 31 59.71a2 2 0 0 0 2.06 0C34.29 59 64 40.92 64 22.5A18.52 18.52 0 0 0 45.5 4ZM32 55.64C26.83 52.34 4 36.92 4 22.5a14.5 14.5 0 0 1 26.36-8.33 2 2 0 0 0 3.27 0A14.5 14.5 0 0 1 60 22.5c0 14.41-22.83 29.83-28 33.14Z"
                                                data-original="#000000"></path>
                                        </svg>
                                    </div>

                                    <div class="w-5/6 h-[210px] overflow-hidden mx-auto aspect-w-16 aspect-h-8 md:mb-2 mb-4">
                                        <img src="https://readymadeui.com/images/product9.webp" alt="Product 1"
                                            class="object-contain w-full h-full" />
                                    </div>

                                    <div>
                                        <h3 class="text-lg font-extrabold text-center text-gray-800">{{ $cos->cosplayer_name }}</h3>
                                        {{-- <p class="mt-2 text-sm text-gray-600">Ni hao wo shi sze chi.</p> --}}
                                        <div class="flex items-center justify-between pt-2">
                                            {{-- <a href="{{ route('fans', ['cosplayerId' => $cos->id]) }}" class="block w-full px-4 py-2 text-center text-white bg-gray-800 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700') }}">
                                                Queue Now
                                            </a> --}}
                                            <a href="{{ route('fans', ['cosplayerId' => $cos->id]) }}" class="block w-full px-4 py-2 text-center text-white bg-gray-800 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700') }}">
                                                Queue Now
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <script>
                    var toggleOpen = document.getElementById('toggleOpen');
                    var toggleClose = document.getElementById('toggleClose');
                    var collapseMenu = document.getElementById('collapseMenu');

                    function handleClick() {
                        if (collapseMenu.style.display === 'block') {
                            collapseMenu.style.display = 'none';
                        } else {
                            collapseMenu.style.display = 'block';
                        }
                    }

                    toggleOpen.addEventListener('click', handleClick);
                    toggleClose.addEventListener('click', handleClick);
                </script>
            </main>


        </div>
    </body>
</html>
