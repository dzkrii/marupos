<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran Berhasil | {{ config('app.name', 'RestoZen') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            if ((savedTheme || systemTheme) === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="font-inter antialiased bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            {{-- Logo --}}
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <img src="{{ asset('images/logo-premium-nobg.png') }}" alt="RestoZen" class="h-12 w-auto mx-auto dark:brightness-0 dark:invert" />
                </a>
            </div>

            {{-- Success Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    {{-- Animated Checkmark --}}
                    <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-full bg-success-100 dark:bg-success-500/20 mb-6">
                        <svg class="w-10 h-10 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        Pembayaran Berhasil! 🎉
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400">
                        Terima kasih! Pembayaran Anda telah dikonfirmasi.
                    </p>
                </div>

                {{-- Order Details --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 mb-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Order ID</span>
                            <span class="font-mono text-gray-900 dark:text-white text-xs">{{ $subscription->order_id }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Paket</span>
                            <span class="text-gray-900 dark:text-white font-semibold">{{ $subscription->plan->name }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Periode</span>
                            <span class="text-gray-900 dark:text-white">{{ $subscription->billing_cycle === 'yearly' ? 'Tahunan' : 'Bulanan' }}</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-600 pt-3 mt-3">
                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-900 dark:text-white">Total Dibayar</span>
                                <span class="text-xl font-bold text-success-600 dark:text-success-400">{{ $subscription->formatted_amount }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Subscription Info --}}
                <div class="bg-brand-50 dark:bg-brand-500/10 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-brand-100 dark:bg-brand-500/20">
                            <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-brand-700 dark:text-brand-400">Langganan Aktif</p>
                            <p class="text-xs text-brand-600 dark:text-brand-500">
                                Berlaku hingga {{ $subscription->expires_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Continue Button --}}
                <a href="{{ route('register.subscription') }}" 
                    class="w-full bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-semibold py-4 px-6 rounded-xl transition-all shadow-lg shadow-brand-500/25 flex items-center justify-center gap-2 text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                    Lanjutkan Pendaftaran
                </a>

                <p class="text-center text-xs text-gray-500 dark:text-gray-400 mt-4">
                    Langkah terakhir: Buat password untuk akun Anda
                </p>
            </div>

            {{-- Support --}}
            <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                Butuh bantuan? <a href="mailto:support@restozen.id" class="text-brand-500 hover:text-brand-600">Hubungi kami</a>
            </div>
        </div>
    </div>
</body>
</html>
