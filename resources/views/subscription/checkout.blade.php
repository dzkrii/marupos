<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - {{ $plan->name }} | {{ config('app.name', 'MARUPOS') }}</title>
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
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="max-w-7xl mx-auto mb-8">
            <div class="flex items-center justify-between">
                <a href="/" class="inline-flex items-center gap-2">
                    <img src="{{ asset('images/marupos-logo.png') }}" alt="MARUPOS" class="h-10 w-auto dark:hidden">
                    <img src="{{ asset('images/marupos-logo-white.png') }}" alt="MARUPOS" class="h-10 w-auto hidden dark:block">
                </a>
                <a href="{{ route('subscription.plans') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Pilihan Paket
                </a>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="grid lg:grid-cols-5 gap-8">
                {{-- Checkout Form --}}
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 lg:p-8">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            Informasi Pendaftaran
                        </h1>
                        <p class="text-gray-500 dark:text-gray-400 mb-8">
                            Lengkapi data berikut untuk melanjutkan pembayaran
                        </p>

                        <form action="{{ route('subscription.process-checkout') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <input type="hidden" name="billing_cycle" value="{{ $billingCycle }}">

                            {{-- Full Name --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Nama Lengkap <span class="text-error-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    placeholder="Masukkan nama lengkap Anda"
                                    class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('name')
                                    <p class="mt-1.5 text-sm text-error-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Email <span class="text-error-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    placeholder="nama@email.com"
                                    class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('email')
                                    <p class="mt-1.5 text-sm text-error-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    No. Telepon
                                </label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                    placeholder="08xxxxxxxxxx"
                                    class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('phone')
                                    <p class="mt-1.5 text-sm text-error-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Restaurant Name --}}
                            <div>
                                <label for="restaurant_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Nama Restoran <span class="text-error-500">*</span>
                                </label>
                                <input type="text" id="restaurant_name" name="restaurant_name" value="{{ old('restaurant_name') }}" required
                                    placeholder="Nama restoran/cafe Anda"
                                    class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('restaurant_name')
                                    <p class="mt-1.5 text-sm text-error-500">{{ $message }}</p>
                                @enderror
                            </div>

                            @error('payment')
                                <div class="p-4 rounded-lg bg-error-50 dark:bg-error-500/10 border border-error-200 dark:border-error-500/20">
                                    <p class="text-sm text-error-600 dark:text-error-400">{{ $message }}</p>
                                </div>
                            @enderror

                            {{-- Submit Button --}}
                            <button type="submit" 
                                class="w-full bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-semibold py-3.5 px-6 rounded-xl transition-all shadow-lg shadow-brand-500/25 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Lanjutkan ke Pembayaran
                            </button>

                            {{-- Security Badge --}}
                            <div class="flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Pembayaran aman dengan Midtrans
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 lg:p-8 sticky top-8">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
                            Ringkasan Pesanan
                        </h2>

                        {{-- Plan Info --}}
                        <div class="flex items-start gap-4 pb-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-brand-100 dark:bg-brand-500/20 text-brand-600 dark:text-brand-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Paket {{ $plan->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Berlangganan {{ $billingCycle === 'yearly' ? 'Tahunan' : 'Bulanan' }}
                                </p>
                            </div>
                        </div>

                        {{-- Plan Features Summary --}}
                        <div class="py-6 border-b border-gray-200 dark:border-gray-700">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Termasuk:</h4>
                            <ul class="space-y-2">
                                @foreach(array_slice($plan->features, 0, 4) as $feature)
                                    <li class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 text-success-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                                @if(count($plan->features) > 4)
                                    <li class="text-sm text-gray-500 dark:text-gray-400 pl-6">
                                        +{{ count($plan->features) - 4 }} fitur lainnya
                                    </li>
                                @endif
                            </ul>
                        </div>

                        {{-- Price Breakdown --}}
                        <div class="py-6 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="text-gray-900 dark:text-white">Rp {{ number_format($amount, 0, ',', '.') }}</span>
                            </div>
                            @if($billingCycle === 'yearly')
                                <div class="flex justify-between text-sm">
                                    <span class="text-success-600 dark:text-success-400">Diskon Tahunan</span>
                                    <span class="text-success-600 dark:text-success-400">-{{ $plan->yearly_savings_percent }}%</span>
                                </div>
                            @endif
                        </div>

                        {{-- Total --}}
                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Total</span>
                                <div class="text-right">
                                    <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                        Rp {{ number_format($amount, 0, ',', '.') }}
                                    </span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        per {{ $billingCycle === 'yearly' ? 'tahun' : 'bulan' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Guarantee --}}
                        <div class="mt-6 p-4 rounded-xl bg-success-50 dark:bg-success-500/10 border border-success-100 dark:border-success-500/20">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-success-600 dark:text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-success-700 dark:text-success-400">Garansi 30 Hari</p>
                                    <p class="text-xs text-success-600 dark:text-success-500 mt-0.5">Uang kembali 100% jika tidak puas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
