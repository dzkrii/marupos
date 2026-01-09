<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lengkapi Pendaftaran | {{ config('app.name', 'MARUPOS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                    this.theme = savedTheme || systemTheme;
                    this.updateTheme();
                },
                theme: 'light',
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    if (this.theme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            });
        });
        // Prevent flash
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            if ((savedTheme || systemTheme) === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="font-inter antialiased bg-gray-50 dark:bg-gray-900">
    <div class="relative z-1 bg-white p-6 sm:p-0 dark:bg-gray-900">
        <div class="relative flex min-h-screen w-full flex-col justify-center sm:p-0 lg:flex-row dark:bg-gray-900">
            
            <!-- Form Section -->
            <div class="flex w-full flex-1 flex-col lg:w-1/2">
                <div class="mx-auto w-full max-w-md pt-10 px-4">
                    <a href="/" class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <svg class="stroke-current mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Kembali ke beranda
                    </a>
                </div>
                
                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center px-4 py-8">
                    <div>
                        {{-- Success Message --}}
                        @if(session('success'))
                            <div class="mb-6 p-4 rounded-xl bg-success-50 dark:bg-success-500/10 border border-success-200 dark:border-success-500/20">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-sm font-medium text-success-700 dark:text-success-400">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="mb-5 sm:mb-8">
                            <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-gray-800 dark:text-white/90">
                                Lengkapi Pendaftaran
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Pembayaran Anda telah berhasil! Lengkapi data berikut untuk mengaktifkan akun.
                            </p>
                        </div>

                        {{-- Subscription Info --}}
                        <div class="mb-6 p-4 rounded-xl bg-brand-50 dark:bg-brand-500/10 border border-brand-200 dark:border-brand-500/20">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-brand-100 dark:bg-brand-500/20">
                                    <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-brand-700 dark:text-brand-400">Paket {{ ucfirst($subscriptionData['plan']) }}</p>
                                    <p class="text-xs text-brand-600 dark:text-brand-500">
                                        Aktif hingga {{ $subscriptionData['expires_at']->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('register.subscription.store') }}">
                            @csrf
                            <div class="space-y-5">
                                <!-- Name (Pre-filled, Readonly) -->
                                <div>
                                    <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Nama Lengkap
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ $subscriptionData['name'] }}" readonly
                                        class="shadow-theme-xs h-11 w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400" />
                                </div>
                                
                                <!-- Email (Pre-filled, Readonly) -->
                                <div>
                                    <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Email
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ $subscriptionData['email'] }}" readonly
                                        class="shadow-theme-xs h-11 w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400" />
                                </div>
                                
                                <!-- Restaurant Name (Pre-filled, Readonly) -->
                                <div>
                                    <label for="restaurant_name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Nama Restoran
                                    </label>
                                    <input type="text" id="restaurant_name" name="restaurant_name" value="{{ $subscriptionData['restaurant_name'] }}" readonly
                                        class="shadow-theme-xs h-11 w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400" />
                                </div>
                                
                                <!-- Password -->
                                <div>
                                    <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Password<span class="text-error-500">*</span>
                                    </label>
                                    <div x-data="{ showPassword: false }" class="relative">
                                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required autocomplete="new-password"
                                            placeholder="Minimal 8 karakter"
                                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                        <span @click="showPassword = !showPassword" class="absolute top-1/2 right-4 z-30 -translate-y-1/2 cursor-pointer text-gray-500 dark:text-gray-400">
                                            <svg x-show="!showPassword" class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0002 13.8619C7.23361 13.8619 4.86803 12.1372 3.92328 9.70241C4.86804 7.26761 7.23361 5.54297 10.0002 5.54297C12.7667 5.54297 15.1323 7.26762 16.0771 9.70243C15.1323 12.1372 12.7667 13.8619 10.0002 13.8619ZM10.0002 4.04297C6.48191 4.04297 3.49489 6.30917 2.4155 9.4593C2.3615 9.61687 2.3615 9.78794 2.41549 9.94552C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C13.5184 15.3619 16.5055 13.0957 17.5849 9.94555C17.6389 9.78797 17.6389 9.6169 17.5849 9.45932C16.5055 6.30919 13.5184 4.04297 10.0002 4.04297ZM9.99151 7.84413C8.96527 7.84413 8.13333 8.67606 8.13333 9.70231C8.13333 10.7286 8.96527 11.5605 9.99151 11.5605H10.0064C11.0326 11.5605 11.8646 10.7286 11.8646 9.70231C11.8646 8.67606 11.0326 7.84413 10.0064 7.84413H9.99151Z" fill="currentColor" />
                                            </svg>
                                            <svg x-show="showPassword" class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.63803 3.57709C4.34513 3.2842 3.87026 3.2842 3.57737 3.57709C3.28447 3.86999 3.28447 4.34486 3.57737 4.63775L4.85323 5.91362C3.74609 6.84199 2.89363 8.06395 2.4155 9.45936C2.3615 9.61694 2.3615 9.78801 2.41549 9.94558C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C11.255 15.3619 12.4422 15.0737 13.4994 14.5598L15.3625 16.4229C15.6554 16.7158 16.1302 16.7158 16.4231 16.4229C16.716 16.13 16.716 15.6551 16.4231 15.3622L4.63803 3.57709ZM12.3608 13.4212L10.4475 11.5079C10.3061 11.5423 10.1584 11.5606 10.0064 11.5606H9.99151C8.96527 11.5606 8.13333 10.7286 8.13333 9.70237C8.13333 9.5461 8.15262 9.39434 8.18895 9.24933L5.91885 6.97923C5.03505 7.69015 4.34057 8.62704 3.92328 9.70247C4.86803 12.1373 7.23361 13.8619 10.0002 13.8619C10.8326 13.8619 11.6287 13.7058 12.3608 13.4212ZM16.0771 9.70249C15.7843 10.4569 15.3552 11.1432 14.8199 11.7311L15.8813 12.7925C16.6329 11.9813 17.2187 11.0143 17.5849 9.94561C17.6389 9.78803 17.6389 9.61696 17.5849 9.45938C16.5055 6.30925 13.5184 4.04303 10.0002 4.04303C9.13525 4.04303 8.30244 4.17999 7.52218 4.43338L8.75139 5.66259C9.1556 5.58413 9.57311 5.54303 10.0002 5.54303C12.7667 5.54303 15.1323 7.26768 16.0771 9.70249Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                    </div>
                                    @error('password')
                                        <p class="mt-1.5 text-sm text-error-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Konfirmasi Password<span class="text-error-500">*</span>
                                    </label>
                                    <div x-data="{ showPassword: false }" class="relative">
                                        <input :type="showPassword ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                                            placeholder="Ulangi password"
                                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                        <span @click="showPassword = !showPassword" class="absolute top-1/2 right-4 z-30 -translate-y-1/2 cursor-pointer text-gray-500 dark:text-gray-400">
                                            <svg x-show="!showPassword" class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0002 13.8619C7.23361 13.8619 4.86803 12.1372 3.92328 9.70241C4.86804 7.26761 7.23361 5.54297 10.0002 5.54297C12.7667 5.54297 15.1323 7.26762 16.0771 9.70243C15.1323 12.1372 12.7667 13.8619 10.0002 13.8619ZM10.0002 4.04297C6.48191 4.04297 3.49489 6.30917 2.4155 9.4593C2.3615 9.61687 2.3615 9.78794 2.41549 9.94552C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C13.5184 15.3619 16.5055 13.0957 17.5849 9.94555C17.6389 9.78797 17.6389 9.6169 17.5849 9.45932C16.5055 6.30919 13.5184 4.04297 10.0002 4.04297ZM9.99151 7.84413C8.96527 7.84413 8.13333 8.67606 8.13333 9.70231C8.13333 10.7286 8.96527 11.5605 9.99151 11.5605H10.0064C11.0326 11.5605 11.8646 10.7286 11.8646 9.70231C11.8646 8.67606 11.0326 7.84413 10.0064 7.84413H9.99151Z" fill="currentColor" />
                                            </svg>
                                            <svg x-show="showPassword" class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.63803 3.57709C4.34513 3.2842 3.87026 3.2842 3.57737 3.57709C3.28447 3.86999 3.28447 4.34486 3.57737 4.63775L4.85323 5.91362C3.74609 6.84199 2.89363 8.06395 2.4155 9.45936C2.3615 9.61694 2.3615 9.78801 2.41549 9.94558C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C11.255 15.3619 12.4422 15.0737 13.4994 14.5598L15.3625 16.4229C15.6554 16.7158 16.1302 16.7158 16.4231 16.4229C16.716 16.13 16.716 15.6551 16.4231 15.3622L4.63803 3.57709ZM12.3608 13.4212L10.4475 11.5079C10.3061 11.5423 10.1584 11.5606 10.0064 11.5606H9.99151C8.96527 11.5606 8.13333 10.7286 8.13333 9.70237C8.13333 9.5461 8.15262 9.39434 8.18895 9.24933L5.91885 6.97923C5.03505 7.69015 4.34057 8.62704 3.92328 9.70247C4.86803 12.1373 7.23361 13.8619 10.0002 13.8619C10.8326 13.8619 11.6287 13.7058 12.3608 13.4212ZM16.0771 9.70249C15.7843 10.4569 15.3552 11.1432 14.8199 11.7311L15.8813 12.7925C16.6329 11.9813 17.2187 11.0143 17.5849 9.94561C17.6389 9.78803 17.6389 9.61696 17.5849 9.45938C16.5055 6.30925 13.5184 4.04303 10.0002 4.04303C9.13525 4.04303 8.30244 4.17999 7.52218 4.43338L8.75139 5.66259C9.1556 5.58413 9.57311 5.54303 10.0002 5.54303C12.7667 5.54303 15.1323 7.26768 16.0771 9.70249Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Terms -->
                                <div x-data="{ agreed: false }">
                                    <label for="terms" class="flex items-start cursor-pointer text-sm font-normal text-gray-700 dark:text-gray-400">
                                        <div class="relative mt-0.5">
                                            <input type="checkbox" id="terms" name="terms" class="sr-only" @change="agreed = !agreed" required />
                                            <div :class="agreed ? 'border-brand-500 bg-brand-500' : 'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]">
                                                <span :class="agreed ? '' : 'opacity-0'">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                        <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="white" stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <span>Saya setuju dengan <a href="#" class="text-brand-500 hover:text-brand-600">Syarat & Ketentuan</a> dan <a href="#" class="text-brand-500 hover:text-brand-600">Kebijakan Privasi</a></span>
                                    </label>
                                </div>
                                
                                <!-- Submit Button -->
                                <div>
                                    <button type="submit" class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-medium text-white transition">
                                        Aktifkan Akun Saya
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side - Branding -->
            <div class="bg-brand-950 relative hidden h-full min-h-screen w-full items-center lg:flex lg:w-1/2 dark:bg-white/5">
                <div class="z-1 flex w-full items-center justify-center">
                    <!-- Grid Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#grid)" />
                        </svg>
                    </div>
                    
                    <div class="flex max-w-sm flex-col items-center px-8">
                        <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-white/10 backdrop-blur">
                            <svg class="w-12 h-12 text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="mb-4 text-2xl font-semibold text-white text-center">Pembayaran Berhasil!</h2>
                        <p class="text-center text-gray-400 dark:text-white/60">
                            Terima kasih telah berlangganan MARUPOS. Tinggal satu langkah lagi untuk mengaktifkan akun Anda!
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Theme Toggle -->
            <div class="fixed right-6 bottom-6 z-50">
                <button class="bg-brand-500 hover:bg-brand-600 inline-flex size-14 items-center justify-center rounded-full text-white transition-colors shadow-lg"
                    @click.prevent="$store.theme.toggle()">
                    <svg class="hidden fill-current dark:block" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99998 1.5415C10.4142 1.5415 10.75 1.87729 10.75 2.2915V3.5415C10.75 3.95572 10.4142 4.2915 9.99998 4.2915C9.58577 4.2915 9.24998 3.95572 9.24998 3.5415V2.2915C9.24998 1.87729 9.58577 1.5415 9.99998 1.5415ZM10.0009 6.79327C8.22978 6.79327 6.79402 8.22904 6.79402 10.0001C6.79402 11.7712 8.22978 13.207 10.0009 13.207C11.772 13.207 13.2078 11.7712 13.2078 10.0001C13.2078 8.22904 11.772 6.79327 10.0009 6.79327ZM5.29402 10.0001C5.29402 7.40061 7.40135 5.29327 10.0009 5.29327C12.6004 5.29327 14.7078 7.40061 14.7078 10.0001C14.7078 12.5997 12.6004 14.707 10.0009 14.707C7.40135 14.707 5.29402 12.5997 5.29402 10.0001Z" fill="currentColor" />
                    </svg>
                    <svg class="fill-current dark:hidden" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M17.4547 11.97L18.1799 12.1611C18.265 11.8383 18.1265 11.4982 17.8401 11.3266C17.5538 11.1551 17.1885 11.1934 16.944 11.4207L17.4547 11.97ZM8.0306 2.5459L8.57989 3.05657C8.80718 2.81209 8.84554 2.44682 8.67398 2.16046C8.50243 1.8741 8.16227 1.73559 7.83948 1.82066L8.0306 2.5459ZM12.9154 13.0035C9.64678 13.0035 6.99707 10.3538 6.99707 7.08524H5.49707C5.49707 11.1823 8.81835 14.5035 12.9154 14.5035V13.0035ZM16.944 11.4207C15.8869 12.4035 14.4721 13.0035 12.9154 13.0035V14.5035C14.8657 14.5035 16.6418 13.7499 17.9654 12.5193L16.944 11.4207ZM16.7295 11.7789C15.9437 14.7607 13.2277 16.9586 10.0003 16.9586V18.4586C13.9257 18.4586 17.2249 15.7853 18.1799 12.1611L16.7295 11.7789ZM10.0003 16.9586C6.15734 16.9586 3.04199 13.8433 3.04199 10.0003H1.54199C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586V16.9586ZM3.04199 10.0003C3.04199 6.77289 5.23988 4.05695 8.22173 3.27114L7.83948 1.82066C4.21532 2.77574 1.54199 6.07486 1.54199 10.0003H3.04199ZM6.99707 7.08524C6.99707 5.52854 7.5971 4.11366 8.57989 3.05657L7.48132 2.03522C6.25073 3.35885 5.49707 5.13487 5.49707 7.08524H6.99707Z" fill="currentColor" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</body>
</html>
