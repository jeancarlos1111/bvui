<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50/50 min-h-screen">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-[30%] -right-[10%] w-[70%] h-[70%] rounded-full bg-gradient-to-br from-blue-100/50 to-[#1e6199]/10 blur-3xl"></div>
                <div class="absolute -bottom-[20%] -left-[10%] w-[60%] h-[60%] rounded-full bg-gradient-to-tr from-blue-50/60 to-blue-200/20 blur-3xl"></div>
            </div>

            <div class="z-10 mb-8">
                <a href="/" wire:navigate class="flex items-center gap-3 group transition-transform hover:scale-105 duration-300">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center group-hover:shadow-md transition-all">
                        <x-application-logo class="w-10 h-10 fill-current text-[#1e6199]" />
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-xl shadow-gray-200/50 border border-gray-100 sm:rounded-3xl z-10 relative">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-sm text-gray-500 z-10">
                &copy; {{ date('Y') }} Biblioteca Virtual Universitaria Inteligente. Todos los derechos reservados.
            </div>
        </div>
    </body>
</html>
