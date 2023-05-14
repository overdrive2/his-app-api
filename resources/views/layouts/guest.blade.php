<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="transition-colors duration-500 dark:bg-neutral-800">
    <div id="theme-toggle-dark-icon"></div>
    <div id="theme-toggle-light-icon"></div>
    <div id="theme-toggle"></div>
    <div class="mt-10" id="page-content" style="style="padding-left: 240px; margin-right: 0px; transition: all 0s ease 0s;"">
        <main>
            <div class="flex flex-row justify-center">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>
