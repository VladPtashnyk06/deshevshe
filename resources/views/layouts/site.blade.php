<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Дешевше - інтернет магазин необхідних товарів для всієї родини</title>

    <!-- Meta Description -->
    <meta name="description" content="Дешевше - ваш надійний інтернет-магазин, що пропонує широкий асортимент товарів для всієї родини за доступними цінами. Відкрийте для себе якісні товари з швидкою доставкою.">

    <!-- Meta Keywords -->
    <meta name="keywords" content="інтернет магазин, товари для родини, доступні ціни, швидка доставка, якісні товари">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Дешевше - інтернет магазин необхідних товарів для всієї родини">
    <meta property="og:description" content="Дешевше - ваш надійний інтернет-магазин, що пропонує широкий асортимент товарів для всієї родини за доступними цінами. Відкрийте для себе якісні товари з швидкою доставкою.">
    <meta property="og:image" content="{{ asset('../public/img/logo.svg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Дешевше - інтернет магазин необхідних товарів для всієї родини">
    <meta name="twitter:description" content="Дешевше - ваш надійний інтернет-магазин, що пропонує широкий асортимент товарів для всієї родини за доступними цінами. Відкрийте для себе якісні товари з швидкою доставкою.">
    <meta name="twitter:image" content="{{ asset('../public/img/logo.svg') }}">

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
