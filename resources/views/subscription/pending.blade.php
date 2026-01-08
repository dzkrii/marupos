<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran Pending | {{ config('app.name', 'RestoZen') }}</title>
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

            {{-- Pending Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center rounded-full bg-warning-100 dark:bg-warning-500/20 mb-4">
                        <svg class="w-8 h-8 text-warning-600 dark:text-warning-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                        Menunggu Pembayaran
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400">
                        Pembayaran Anda sedang dalam proses verifikasi. Silakan selesaikan pembayaran sesuai instruksi yang diberikan.
                    </p>
                </div>

                {{-- Order Details --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 mb-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Order ID</span>
                            <span class="font-mono text-gray-900 dark:text-white">{{ $subscription->order_id }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Paket</span>
                            <span class="text-gray-900 dark:text-white">{{ $plan->name }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Total Pembayaran</span>
                            <span class="font-semibold text-brand-600 dark:text-brand-400">{{ $subscription->formatted_amount }}</span>
                        </div>
                        @if($subscription->payment_type)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Metode Pembayaran</span>
                                <span class="text-gray-900 dark:text-white capitalize">{{ str_replace('_', ' ', $subscription->payment_type) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Status Checker --}}
                <div id="status-checker" class="text-center text-sm text-gray-500 dark:text-gray-400 mb-6">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-brand-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memeriksa status pembayaran...
                    </div>
                </div>

                {{-- Instructions --}}
                <div class="bg-blue-50 dark:bg-blue-500/10 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-700 dark:text-blue-400">Petunjuk:</p>
                            <ul class="text-xs text-blue-600 dark:text-blue-300 mt-1 space-y-1">
                                <li>• Selesaikan pembayaran dalam waktu 24 jam</li>
                                <li>• Halaman ini akan otomatis diperbarui setelah pembayaran terverifikasi</li>
                                <li>• Cek email Anda untuk instruksi pembayaran lebih lanjut</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="space-y-3">
                    <a href="{{ route('subscription.payment', $subscription) }}" 
                        class="w-full bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-semibold py-3.5 px-6 rounded-xl transition-all shadow-lg shadow-brand-500/25 flex items-center justify-center gap-2">
                        Lihat Instruksi Pembayaran
                    </a>
                    <a href="{{ route('subscription.plans') }}" 
                        class="w-full border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold py-3.5 px-6 rounded-xl hover:border-gray-300 dark:hover:border-gray-600 transition-all flex items-center justify-center gap-2">
                        Kembali ke Pilihan Paket
                    </a>
                </div>
            </div>

            {{-- Support --}}
            <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                Butuh bantuan? <a href="mailto:support@restozen.id" class="text-brand-500 hover:text-brand-600">Hubungi kami</a>
            </div>
        </div>
    </div>

    <script>
        // Auto-check payment status every 10 seconds
        function checkPaymentStatus() {
            fetch('{{ route('subscription.check-status', $subscription) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.is_paid && data.redirect_url) {
                        window.location.href = data.redirect_url;
                    }
                })
                .catch(error => console.error('Error checking status:', error));
        }

        // Check every 10 seconds
        setInterval(checkPaymentStatus, 10000);
        
        // Initial check after 5 seconds
        setTimeout(checkPaymentStatus, 5000);
    </script>
</body>
</html>
