<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-Rekam Medis') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-white to-blue-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl rounded-2xl overflow-hidden">
                <!-- Logo and Title -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <x-application-logo class="h-16 w-16 text-blue-600" />
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">E-Rekam Medis</h2>
                    <p class="mt-2 text-sm text-gray-600">Sistem Informasi Rekam Medis Elektronik</p>
            </div>

                {{ $slot }}
            </div>

            <!-- Footer Link -->
            <div class="mt-6 text-center">
                <a href="{{ route('welcome') }}" class="text-sm text-gray-600 hover:text-blue-600">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </body>
</html>
