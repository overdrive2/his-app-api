<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />
        <script src="{{ asset('./fontawesome-free-6.4.0-web/fontawesome.min.js') }}"></script>
        <!-- Scripts -->
        <script>

            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="bg-gray-50 dark:bg-gray-800">
        <x-nav-menu :user="Auth::user()" />
        <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
            <x-aside />
            <div class="fixed inset-0 z-10 bg-gray-900/50 dark:bg-gray-900/90 hidden" id="sidebarBackdrop"></div>
            <div id="main-centent" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif
                <!-- Page Content -->
                <main>
                    <div class="px-4 pt-6">
                        {{ $slot }}
                    </div>
                </main>

                <!-- Page Footer -->
                @if(isset($footer))
                    {{ $footer }}
                @endif
            </div>
        </div>
        @stack('modals')

        @livewireScripts
    </body>
</html>
