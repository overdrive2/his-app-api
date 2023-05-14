<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/f7ba90fa0d.js" crossorigin="anonymous"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="dark:bg-zinc-800 [&>*]:leading-[1.6]">
  <!-- Sidenav -->
  <x-top-navbar />

  <!-- Sidenav -->
  <x-sidenav-main />

  <!-- Content -->
  <div
    class="min-h-screen w-full bg-gray-50 !pl-0 text-center sm:!pl-60"
    id="content">
    <div class="py-12 text-center">
      {{ $slot }}
    </div>
  </div>
  <!-- Content -->
  @livewireScripts
</body>

</html>
