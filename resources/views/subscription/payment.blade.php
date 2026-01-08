<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran - {{ $plan->name }} | {{ config('app.name', 'RestoZen') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Midtrans Snap.js --}}
    <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
    
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

            {{-- Payment Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center rounded-full bg-brand-100 dark:bg-brand-500/20 mb-4">
                        <svg class="w-8 h-8 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                        Selesaikan Pembayaran
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400">
                        Klik tombol di bawah untuk melanjutkan pembayaran via Midtrans
                    </p>
                </div>

                {{-- Order Summary --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Paket</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $plan->name }}</span>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Periode</span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ $subscription->billing_cycle === 'yearly' ? 'Tahunan' : 'Bulanan' }}
                        </span>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-3 mt-3">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-gray-900 dark:text-white">Total</span>
                            <span class="text-xl font-bold text-brand-600 dark:text-brand-400">
                                {{ $subscription->formatted_amount }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Pay Button --}}
                <button id="pay-button" 
                    class="w-full bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-semibold py-4 px-6 rounded-xl transition-all shadow-lg shadow-brand-500/25 flex items-center justify-center gap-2 text-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Bayar Sekarang
                </button>

                {{-- Cancel Link --}}
                <div class="mt-6 text-center">
                    <a href="{{ route('subscription.plans') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        Batalkan dan kembali ke pilihan paket
                    </a>
                </div>

                {{-- Payment Methods Info --}}
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center mb-4">
                        Metode pembayaran tersedia:
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <div class="text-xs text-gray-400 dark:text-gray-500 text-center">
                            Bank Transfer • Credit Card • E-Wallet • QRIS
                        </div>
                    </div>
                </div>
            </div>

            {{-- Security Badge --}}
            <div class="mt-6 flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Transaksi dilindungi enkripsi SSL
            </div>
        </div>
    </div>

    <script>
        const handleSuccessUrl = '{{ config("app.url") }}/subscription/handle-success';
        const successUrl = '{{ config("app.url") }}/subscription/success/{{ $subscription->id }}';
        const pendingUrl = '{{ config("app.url") }}/subscription/pending/{{ $subscription->id }}';
        const orderId = '{{ $subscription->order_id }}';
        const csrfToken = '{{ csrf_token() }}';

        document.getElementById('pay-button').addEventListener('click', function() {
            // Show loading state
            this.disabled = true;
            this.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            `;

            // Trigger Midtrans Snap popup
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    console.log('Payment Success:', result);
                    
                    // Show processing message
                    document.getElementById('pay-button').innerHTML = `
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mengkonfirmasi pembayaran...
                    `;
                    
                    // Update status via AJAX first, then redirect
                    fetch(handleSuccessUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            order_id: result.order_id || orderId,
                            transaction_status: result.transaction_status || 'capture',
                            transaction_id: result.transaction_id || null,
                            payment_type: result.payment_type || 'credit_card',
                            status_message: result.status_message || 'success'
                        })
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Server response:', data);
                        // Redirect to success page
                        window.location.href = data.redirect_url || successUrl;
                    })
                    .catch(error => {
                        console.error('Error updating status:', error);
                        // Fallback: redirect to success page anyway (optimistic)
                        window.location.href = successUrl;
                    });
                },
                onPending: function(result) {
                    console.log('Payment Pending:', result);
                    
                    // For demo/sandbox: treat pending credit card as success
                    if (result.payment_type === 'credit_card') {
                        // Try to mark as paid
                        fetch(handleSuccessUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                order_id: result.order_id || orderId,
                                transaction_status: 'capture',
                                payment_type: 'credit_card'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            window.location.href = data.redirect_url || successUrl;
                        })
                        .catch(() => {
                            window.location.href = pendingUrl;
                        });
                    } else {
                        window.location.href = pendingUrl;
                    }
                },
                onError: function(result) {
                    console.log('Payment Error:', result);
                    alert('Pembayaran gagal. Silakan coba lagi.');
                    location.reload();
                },
                onClose: function() {
                    // Reset button
                    document.getElementById('pay-button').disabled = false;
                    document.getElementById('pay-button').innerHTML = `
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Bayar Sekarang
                    `;
                }
            });
        });
    </script>
</body>
</html>


