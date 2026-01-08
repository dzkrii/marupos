<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="kitchenDisplay" x-init="init">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Restozen') }} - Kitchen</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Hidden audio element -->
    <audio id="notificationSound" preload="auto">
        <source src="{{ asset('sounds/notification.mp3') }}" type="audio/mpeg">
    </audio>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex items-center justify-between z-10">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Sistem Tampilan Dapur</h1>
                <span class="bg-primary-100 text-primary-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                    {{ $orders->count() }} Pesanan Aktif
                </span>

                <!-- New Order Notification Badge -->
                <span 
                    x-show="newOrdersCount > 0"
                    x-transition
                    class="bg-accent-500 text-white text-sm font-bold px-3 py-1 rounded-full animate-bounce">
                    +<span x-text="newOrdersCount"></span> Baru!
                </span>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- Sound Toggle -->
                <button 
                    @click="toggleSound"
                    :class="soundEnabled ? 'bg-secondary-100 text-secondary-700' : 'bg-gray-100 text-gray-500'"
                    class="px-3 py-2 rounded-lg font-medium flex items-center gap-2 hover:opacity-80 transition-all">
                    <svg x-show="soundEnabled" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.586A2 2 0 014 14V10a2 2 0 011-1.732l7-3.5a1 1 0 011.5.866v13.732a1 1 0 01-1.5.866l-7-3.5z"/>
                    </svg>
                    <svg x-show="!soundEnabled" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15.586A2 2 0 014 14V10a2 2 0 011-1.732l7-3.5a1 1 0 011.5.866v13.732a1 1 0 01-1.5.866l-7-3.5zM17 12h6"/>
                    </svg>
                    <span x-text="soundEnabled ? 'Suara: ON' : 'Suara: OFF'"></span>
                </button>

                <div id="clock" class="text-xl font-mono text-gray-600 font-bold"></div>
                
                <button onclick="window.location.reload()" class="btn-secondary flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Segarkan
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove();">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                    <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <p class="text-xl font-medium">Tidak ada pesanan aktif</p>
                    <p class="text-sm">Menunggu pesanan baru masuk!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($orders as $order)
                        @include('kitchen.partials.order-card', ['order' => $order])
                    @endforeach
                </div>
            @endif
        </main>
    </div>

    <script>
        // Alpine.js Component for Kitchen Display
        document.addEventListener('alpine:init', () => {
            Alpine.data('kitchenDisplay', () => ({
                soundEnabled: localStorage.getItem('kitchen_sound') !== 'false',
                lastOrderId: {{ $orders->max('id') ?? 0 }},
                newOrdersCount: 0,
                checkInterval: null,
                hasInteracted: false,

                init() {
                    // Start polling for new orders
                    this.checkInterval = setInterval(() => {
                        this.checkNewOrders();
                    }, 5000); // Check every 5 seconds

                    // Mark as interacted after first click anywhere
                    document.body.addEventListener('click', () => {
                        this.hasInteracted = true;
                    }, { once: true });
                },

                async checkNewOrders() {
                    try {
                        const response = await fetch(`{{ route('kitchen.check-new') }}?last_order_id=${this.lastOrderId}`);
                        const data = await response.json();

                        if (data.has_new_orders) {
                            this.newOrdersCount = data.new_orders_count;
                            this.lastOrderId = data.latest_order_id;

                            // Play notification sound
                            if (this.soundEnabled && this.hasInteracted) {
                                this.playNotificationSound();
                            }

                            // Show browser notification
                            this.showBrowserNotification(data.new_orders);

                            // Auto reload after 2 seconds to show new orders
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        }
                    } catch (error) {
                        console.error('Error checking new orders:', error);
                    }
                },

                playNotificationSound() {
                    const audio = document.getElementById('notificationSound');
                    if (audio) {
                        audio.play().catch(err => {
                            console.log('Could not play sound:', err);
                        });
                    }
                },

                showBrowserNotification(orders) {
                    if ("Notification" in window && Notification.permission === "granted") {
                        const order = orders[0];
                        new Notification("Pesanan Baru Masuk!", {
                            body: `Order #${order.order_number} dari ${order.table}\n${order.items_count} item`,
                            icon: '/favicon.ico',
                            badge: '/favicon.ico'
                        });
                    }
                },

                toggleSound() {
                    this.soundEnabled = !this.soundEnabled;
                    localStorage.setItem('kitchen_sound', this.soundEnabled ? 'true' : 'false');

                    // Test sound when enabling
                    if (this.soundEnabled) {
                        this.hasInteracted = true;
                        this.playNotificationSound();
                    }
                },

                destroy() {
                    if (this.checkInterval) {
                        clearInterval(this.checkInterval);
                    }
                }
            }));
        });

        // Update Clock
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const clockEl = document.getElementById('clock');
            if (clockEl) clockEl.textContent = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Request notification permission on load
        if ("Notification" in window && Notification.permission === "default") {
            Notification.requestPermission();
        }
    </script>
</body>
</html>
