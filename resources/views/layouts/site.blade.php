<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Дешевше - інтернет магазин необхідних товарів для всієї родини</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(
            [
                'resources/css/style.css',
                'resources/js/script.js'
                ]
        )
    </head>
    <body>
        <div>
            <!-- Page Header -->
            @include('components.header')

            <!-- Page Content -->
            {{ $slot }}

            <!-- Page Footer -->
            @include('components.footer')
        </div>
    </body>
</html>
