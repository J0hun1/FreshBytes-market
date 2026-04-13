<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart - {{ config('app.name', 'FreshBytes Market') }}</title>
    <link rel="icon" type="image/png" href="/images/logos-12-12.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen antialiased">
    @include('layouts.navbar')

    <main class="pt-20">
        <section class="py-8 bg-white dark:bg-gray-900">
            <div class="max-w-screen-xl px-4 mx-auto">
                
            </div>
        </section>
    </main>
</body>
</html>
