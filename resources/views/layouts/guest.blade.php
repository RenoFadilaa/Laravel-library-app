<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="nature">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-base-200 relative overflow-hidden">
            <!-- Decorative nature background elements -->
            <div class="absolute top-0 left-0 w-72 h-72 bg-primary/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary/5 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>
            <div class="absolute top-1/3 right-1/4 w-48 h-48 bg-accent/5 rounded-full blur-2xl"></div>

            <div class="relative z-10 mb-6">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-14 h-14 rounded-2xl bg-primary text-primary-content flex items-center justify-center shadow-lg shadow-primary/25 group-hover:scale-105 transition duration-300">
                        <i class="fa-solid fa-leaf text-2xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-base-content">Library App</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-8 bg-base-100 shadow-xl overflow-hidden rounded-3xl border border-base-300 relative z-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
