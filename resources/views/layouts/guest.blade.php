<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'MARUPOS') }}</title>

        <!-- Fonts - Inter -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side - Hero Section -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-600 via-primary-500 to-accent-500 p-12 flex-col justify-between relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#grid)" />
                    </svg>
                </div>

                <!-- Logo & Branding -->
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-white">MARUPOS</span>
                    </div>
                    <h1 class="text-4xl font-bold text-white leading-tight">
                        Kelola Bisnis<br>
                        <span class="text-white/80">Lebih Mudah & Efisien</span>
                    </h1>
                    <p class="text-white/70 mt-4 text-lg max-w-md">
                        Sistem POS modern untuk berbagai jenis usaha dengan fitur lengkap: manajemen outlet, pesanan, dan laporan real-time.
                    </p>
                </div>

                <!-- Features -->
                <div class="relative z-10 space-y-4">
                    <div class="flex items-center gap-3 text-white/80">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span>Multi-outlet dalam satu dashboard</span>
                    </div>
                    <div class="flex items-center gap-3 text-white/80">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span>QR code ordering untuk customer</span>
                    </div>
                    <div class="flex items-center gap-3 text-white/80">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span>Kitchen Display System real-time</span>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -top-10 -left-10 w-48 h-48 bg-accent-500/30 rounded-full blur-3xl"></div>
            </div>

            <!-- Right Side - Auth Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 bg-gray-50">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8 text-center">
                    <div class="inline-flex items-center gap-2 mb-2">
                        <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900">MARUPOS</span>
                    </div>
                </div>

                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} MARUPOS. All rights reserved.</p>
                </div>
            </div>
        </div>
    </body>
</html>
