<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pilih Paket Berlangganan | {{ config('app.name', 'MARUPOS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        // Theme handling
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
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8" x-data="{ yearly: false }">
        {{-- Header --}}
        <div class="max-w-7xl mx-auto mb-12">
            <div class="flex items-center justify-between">
                <a href="/" class="inline-flex items-center gap-2">
                    <img src="{{ asset('images/logo-premium-nobg.png') }}" alt="MARUPOS" class="h-10 w-auto dark:brightness-0 dark:invert" />
                </a>
                <a href="/" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        {{-- Page Title --}}
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Pilih Paket Berlangganan
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Untuk memulai menggunakan MARUPOS, silakan pilih paket berlangganan yang sesuai dengan kebutuhan bisnis Anda.
            </p>
        </div>

        {{-- Billing Toggle --}}
        <div class="flex justify-center mb-12">
            <div class="inline-flex items-center gap-4 p-1.5 bg-gray-100 dark:bg-gray-800 rounded-xl">
                <button @click="yearly = false" :class="!yearly ? 'bg-white dark:bg-gray-700 shadow-theme-sm text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'" class="px-5 py-2.5 rounded-lg font-medium transition-all">
                    Bulanan
                </button>
                <button @click="yearly = true" :class="yearly ? 'bg-white dark:bg-gray-700 shadow-theme-sm text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'" class="px-5 py-2.5 rounded-lg font-medium transition-all flex items-center gap-2">
                    Tahunan
                    <span class="px-2 py-0.5 rounded-full bg-success-100 dark:bg-success-500/20 text-success-600 dark:text-success-400 text-xs font-semibold">-20%</span>
                </button>
            </div>
            
            {{-- Hidden input for form if needed --}}
            <input type="hidden" name="billing_cycle" :value="yearly ? 'yearly' : 'monthly'" id="billing-cycle-input">
        </div>

        {{-- Pricing Cards --}}
        <div class="grid md:grid-cols-2 gap-6 lg:gap-8 max-w-5xl mx-auto">
            {{-- MARUPOS Premium Plan --}}
            <div class="relative bg-gray-900 dark:bg-gray-800 p-6 lg:p-8 rounded-2xl border-2 border-brand-500 shadow-theme-xl">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                    <span class="inline-block px-4 py-1.5 rounded-full bg-gradient-to-r from-brand-500 to-brand-600 text-white text-sm font-semibold shadow-lg">
                        All-in-One
                    </span>
                </div>
                <div class="mb-6 text-center">
                    <h3 class="text-xl font-semibold text-white mb-2">MARUPOS Premium</h3>
                    <p class="text-gray-400 text-sm">Solusi lengkap untuk bisnis modern</p>
                </div>
                <div class="mb-6 text-center">
                    <div class="flex items-baseline justify-center gap-1">
                        <span class="text-4xl font-bold text-white" x-text="yearly ? 'Rp 5.750K' : 'Rp 599K'">Rp 599K</span>
                        <span class="text-gray-400" x-text="yearly ? '/tahun' : '/bulan'">/bulan</span>
                    </div>
                    <p class="text-xs text-brand-400 mt-2 font-medium" x-show="yearly">Hemat 20% (Rp 1.4jt/tahun)</p>
                    <p class="text-xs text-gray-500 mt-2" x-show="!yearly">Lengkap dengan semua fitur</p>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">Unlimited Table & Outlet</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">POS & Menu Management Lengkap</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">QR Order & Kitchen Display</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">Laporan Keuangan & Export PDF</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">Manajemen Karyawan & Shift</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">Priority Support 24/7</span>
                    </li>
                </ul>
                <a :href="'{{ route('subscription.checkout', ['plan' => 'professional']) }}' + (yearly ? '?billing=yearly' : '?billing=monthly')" 
                   class="block w-full text-center py-3.5 px-6 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-brand-500/25">
                    Mulai Berlangganan Sekarang
                </a>
            </div>

            {{-- Custom / Enterprise Plan --}}
            <div class="relative bg-white dark:bg-gray-800 p-6 lg:p-8 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-theme-lg transition-all duration-300">
                <div class="mb-6 text-center">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Custom / Enterprise</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Untuk kebutuhan bisnis yang spesifik</p>
                </div>
                <div class="mb-6 text-center">
                    <div class="flex items-baseline justify-center gap-1">
                        <span class="text-4xl font-bold text-gray-900 dark:text-white">Hubungi Kami</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Konsultasi gratis sesuai kebutuhan</p>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">Custom Features & Integration</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">Dedicated Account Manager</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">On-site Training & Setup</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">White Label Option</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">Jaminan SLA 99.9%</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">Support Prioritas Khusus</span>
                    </li>
                </ul>
                <a href="https://wa.me/6281234567890?text=Halo%20tim%20MARUPOS,%20saya%20tertarik%20dengan%20paket%20Custom/Enterprise" target="_blank" 
                   class="block w-full text-center py-3.5 px-6 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:border-brand-500 hover:text-brand-500 dark:hover:border-brand-400 dark:hover:text-brand-400 transition-all flex items-center justify-center gap-2">
                   <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                   Hubungi Sales via WhatsApp
                </a>
            </div>
        </div>

        {{-- Money Back Guarantee --}}
        <div class="mt-12 text-center">
            <div class="inline-flex items-center gap-3 px-6 py-3 bg-success-50 dark:bg-success-500/10 rounded-full">
                <svg class="w-6 h-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span class="text-success-700 dark:text-success-400 font-medium">Garansi 30 hari uang kembali tanpa pertanyaan</span>
            </div>
        </div>

        {{-- Already have account --}}
        <p class="mt-8 text-center text-gray-600 dark:text-gray-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-brand-500 hover:text-brand-600 font-medium">Masuk</a>
        </p>
    </div>
</body>
</html>
