<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'FreshBytes') }}</title>

        <link rel="icon" type="image/png" href="/images/logos-12-12.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen">

        @include('layouts.navbar')


        <main class="pt-20 flex flex-col items-center justify-center min-h-screen">
             @include('layouts.hero-section')
            @if (Route::has('login'))
                <div class="h-14.5 hidden lg:block"></div>
            @endif
            @include('layouts.category-cards')
             @include('layouts.product-cards')
        </main>

    </body>
</html>
