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
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
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
        <div class="flex justify-center mb-12" x-data="{ yearly: false }">
            <div class="inline-flex items-center gap-4 p-1.5 bg-gray-100 dark:bg-gray-800 rounded-xl">
                <button @click="yearly = false" :class="!yearly ? 'bg-white dark:bg-gray-700 shadow-theme-sm text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'" class="px-5 py-2.5 rounded-lg font-medium transition-all">
                    Bulanan
                </button>
                <button @click="yearly = true" :class="yearly ? 'bg-white dark:bg-gray-700 shadow-theme-sm text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'" class="px-5 py-2.5 rounded-lg font-medium transition-all flex items-center gap-2">
                    Tahunan
                    <span class="px-2 py-0.5 rounded-full bg-success-100 dark:bg-success-500/20 text-success-600 dark:text-success-400 text-xs font-semibold">-20%</span>
                </button>
            </div>
            
            {{-- Hidden input for form --}}
            <input type="hidden" name="billing_cycle" :value="yearly ? 'yearly' : 'monthly'" id="billing-cycle-input">
        </div>

        {{-- Pricing Cards --}}
        <div class="max-w-5xl mx-auto" x-data="{ yearly: false }">
            {{-- Re-add toggle logic for pricing display --}}
            <div class="flex justify-center mb-8">
                <div class="inline-flex items-center gap-4 p-1.5 bg-gray-100 dark:bg-gray-800 rounded-xl">
                    <button @click="yearly = false" :class="!yearly ? 'bg-white dark:bg-gray-700 shadow-theme-sm text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'" class="px-5 py-2.5 rounded-lg font-medium transition-all">
                        Bulanan
                    </button>
                    <button @click="yearly = true" :class="yearly ? 'bg-white dark:bg-gray-700 shadow-theme-sm text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'" class="px-5 py-2.5 rounded-lg font-medium transition-all flex items-center gap-2">
                        Tahunan
                        <span class="px-2 py-0.5 rounded-full bg-success-100 dark:bg-success-500/20 text-success-600 dark:text-success-400 text-xs font-semibold">Hemat 20%</span>
                    </button>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
                @foreach($plans as $plan)
                    @if($plan->slug === 'enterprise')
                        {{-- Enterprise Plan --}}
                        <div class="bg-white dark:bg-gray-800 p-6 lg:p-8 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $plan->name }}</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $plan->description }}</p>
                            </div>
                            <div class="mb-6">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-4xl font-bold text-gray-900 dark:text-white">Custom</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Hubungi kami untuk penawaran</p>
                            </div>
                            <ul class="space-y-3 mb-8">
                                @foreach($plan->features as $feature)
                                    <li class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-600 dark:text-gray-400 text-sm">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <a href="mailto:sales@marupos.id?subject=Enterprise Plan Inquiry" 
                               class="block w-full text-center py-3.5 px-6 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:border-brand-500 hover:text-brand-500 dark:hover:border-brand-400 dark:hover:text-brand-400 transition-all">
                                Hubungi Sales
                            </a>
                        </div>
                    @else
                        {{-- Regular Plans --}}
                        <div class="{{ $plan->is_popular ? 'relative bg-gray-900 dark:bg-gray-800 border-2 border-brand-500 shadow-xl' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:shadow-lg' }} p-6 lg:p-8 rounded-2xl transition-all duration-300">
                            
                            @if($plan->is_popular)
                                <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                                    <span class="inline-block px-4 py-1.5 rounded-full bg-gradient-to-r from-brand-500 to-brand-600 text-white text-sm font-semibold shadow-lg">
                                        Paling Populer
                                    </span>
                                </div>
                            @endif
                            
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold {{ $plan->is_popular ? 'text-white' : 'text-gray-900 dark:text-white' }} mb-2">{{ $plan->name }}</h3>
                                <p class="{{ $plan->is_popular ? 'text-gray-400' : 'text-gray-500 dark:text-gray-400' }} text-sm">{{ $plan->description }}</p>
                            </div>
                            <div class="mb-6">
                                <div class="flex items-baseline gap-1">
                                    <span x-show="!yearly" class="text-4xl font-bold {{ $plan->is_popular ? 'text-white' : 'text-gray-900 dark:text-white' }}">
                                        {{ $plan->formatted_monthly_price }}
                                    </span>
                                    <span x-show="yearly" class="text-4xl font-bold {{ $plan->is_popular ? 'text-white' : 'text-gray-900 dark:text-white' }}">
                                        {{ $plan->formatted_yearly_price }}
                                    </span>
                                    <span class="{{ $plan->is_popular ? 'text-gray-400' : 'text-gray-500 dark:text-gray-400' }}">
                                        <span x-show="!yearly">/bulan</span>
                                        <span x-show="yearly">/tahun</span>
                                    </span>
                                </div>
                                <p x-show="!yearly" class="text-xs {{ $plan->is_popular ? 'text-gray-500' : 'text-gray-400' }} mt-1">
                                    Atau {{ $plan->formatted_yearly_price }}/tahun (hemat {{ $plan->yearly_savings_percent }}%)
                                </p>
                                <p x-show="yearly" class="text-xs {{ $plan->is_popular ? 'text-gray-500' : 'text-gray-400' }} mt-1">
                                    Setara {{ 'Rp ' . number_format($plan->price_yearly / 12, 0, ',', '.') }}/bulan
                                </p>
                            </div>
                            <ul class="space-y-3 mb-8">
                                @foreach($plan->features as $feature)
                                    <li class="flex items-start gap-3">
                                        <svg class="w-5 h-5 {{ $plan->is_popular ? 'text-success-400' : 'text-success-500' }} mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="{{ $plan->is_popular ? 'text-gray-300' : 'text-gray-600 dark:text-gray-400' }} text-sm">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <a :href="'{{ route('subscription.checkout', $plan) }}?billing=' + (yearly ? 'yearly' : 'monthly')"
                               class="{{ $plan->is_popular 
                                   ? 'bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white shadow-lg shadow-brand-500/25' 
                                   : 'border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:border-brand-500 hover:text-brand-500 dark:hover:border-brand-400 dark:hover:text-brand-400' 
                               }} block w-full text-center py-3.5 px-6 font-semibold rounded-xl transition-all">
                                Pilih Paket
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Money Back Guarantee --}}
            <div class="mt-12 text-center">
                <div class="inline-flex items-center gap-3 px-6 py-3 bg-success-50 dark:bg-success-500/10 rounded-full">
                    <svg class="w-6 h-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span class="text-success-700 dark:text-success-400 font-medium">Garansi 30 hari uang kembali tanpa pertanyaan</span>
                </div>
            </div>

            {{-- Already have account --}}
            <p class="mt-8 text-center text-gray-600 dark:text-gray-400">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-brand-500 hover:text-brand-600 font-medium">Masuk</a>
            </p>
        </div>
    </div>
</body>
</html>
