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
            @include('layouts.navigation')

            @if(Auth::user() && Auth::user()->role == 'admin' && \Illuminate\Support\Facades\Route::is('product.*') || \Illuminate\Support\Facades\Route::is('category.*') || \Illuminate\Support\Facades\Route::is('color.*') || \Illuminate\Support\Facades\Route::is('package.*') || \Illuminate\Support\Facades\Route::is('material.*') || \Illuminate\Support\Facades\Route::is('characteristic.*') || \Illuminate\Support\Facades\Route::is('size.*') || \Illuminate\Support\Facades\Route::is('status.*') || \Illuminate\Support\Facades\Route::is('promotional.*') || \Illuminate\Support\Facades\Route::is('producer.*'))
                @include('layouts.custom-header')
            @endif

            @if(Auth::user() && Auth::user()->role == 'admin' && \Illuminate\Support\Facades\Route::is('promoCode.*') || \Illuminate\Support\Facades\Route::is('certificate.*'))
                @include('layouts.header-bonuses')
            @endif

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
