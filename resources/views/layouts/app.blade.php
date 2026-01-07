<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: true, sidebarMobileOpen: false }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Restozen') }}</title>

        <!-- Fonts - Inter -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex">
            <!-- Sidebar Overlay for Mobile -->
            <div x-show="sidebarMobileOpen"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden"
                 @click="sidebarMobileOpen = false"></div>

            <!-- Sidebar -->
            @include('layouts.partials.sidebar')

            <!-- Main Content -->
            <div class="flex-1 flex flex-col min-w-0" :class="{ 'lg:ml-64': sidebarOpen, 'lg:ml-20': !sidebarOpen }">
                <!-- Top Navigation -->
                @include('layouts.partials.topbar')

                <!-- Page Content -->
                <main class="flex-1 p-4 lg:p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
