<x-layouts.guest-qr>
    <x-slot name="title">Lacak Pesanan - {{ $order->order_number }}</x-slot>

    <div class="min-h-screen bg-gray-50 pb-8 dark:bg-gray-900" x-data="orderTracking" x-init="startAutoRefresh">
        <!-- Header -->
        <header class="sticky top-0 z-30 border-b border-gray-200 bg-white/80 backdrop-blur-md shadow-theme-xs dark:border-gray-800 dark:bg-gray-900/80">
            <div class="mx-auto flex max-w-lg items-center justify-between px-4 py-4">
                <div>
                    <h1 class="text-lg font-bold text-gray-900 dark:text-white">Lacak Pesanan</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">#{{ $order->order_number }}</p>
                </div>
                <div class="rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                    {{ ucfirst($order->status) }}
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-lg px-4 py-6">
            <!-- Order Status Progress -->
            <div class="mb-6 rounded-xl bg-white p-5 shadow-theme-sm dark:bg-gray-800">
                <h3 class="mb-5 font-semibold text-gray-900 dark:text-white">Status Pesanan</h3>
                
                <div class="relative">
                    <!-- Progress Steps -->
                    <div class="space-y-6">
                        @php
                            $statuses = [
                                'pending' => ['label' => 'Pesanan Diterima', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                'confirmed' => ['label' => 'Dikonfirmasi', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                'preparing' => ['label' => 'Sedang Dimasak', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                                'ready' => ['label' => 'Siap Disajikan', 'icon' => 'M5 13l4 4L19 7'],
                                'served' => ['label' => 'Sudah Disajikan', 'icon' => 'M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5'],
                            ];

                            $currentIndex = array_search($order->status, array_keys($statuses));
                        @endphp

                        @foreach($statuses as $key => $status)
                            @php
                                $stepIndex = array_search($key, array_keys($statuses));
                                $isActive = $stepIndex <= $currentIndex;
                                $isCurrent = $key === $order->status;
                            @endphp

                            <div class="relative flex items-center z-10">
                                <!-- Connecting Line (Absolute) -->
                                @if(!$loop->last)
                                    <div class="absolute left-5 top-10 h-full w-[2px] -translate-x-1/2 bg-gray-100 dark:bg-gray-700">
                                        <div class="h-full w-full {{ $isActive && $stepIndex < $currentIndex ? 'bg-brand-500' : '' }} transition-all duration-500"></div>
                                    </div>
                                @endif

                                <!-- Icon Circle -->
                                <div class="flex size-10 shrink-0 items-center justify-center rounded-full border-2 transition-all duration-300 {{ $isActive ? 'border-brand-500 bg-brand-50 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400' : 'border-gray-200 bg-white text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-600' }}">
                                    @if($isActive && !$isCurrent && $key !== 'served')
                                        <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $status['icon'] }}"/>
                                        </svg>
                                    @endif
                                </div>

                                <!-- Label -->
                                <div class="ml-4 flex-1">
                                    <p class="font-medium {{ $isActive ? 'text-gray-900 dark:text-white' : 'text-gray-400 dark:text-gray-600' }}">
                                        {{ $status['label'] }}
                                    </p>
                                    @if($isCurrent)
                                        <p class="mt-1 flex items-center text-xs font-medium text-brand-600 dark:text-brand-400">
                                            <span class="mr-1.5 inline-block size-1.5 animate-pulse rounded-full bg-brand-500"></span>
                                            Status saat ini
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Refresh Button -->
                <div class="mt-6 border-t border-gray-100 pt-4 dark:border-gray-700">
                    <button 
                        @click="refreshStatus"
                        :disabled="isRefreshing"
                        class="flex w-full items-center justify-center text-sm font-medium text-brand-600 transition-colors hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                        <svg 
                            class="mr-2 size-4" 
                            :class="{ 'animate-spin': isRefreshing }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span x-text="isRefreshing ? 'Memperbarui...' : 'Perbarui Status'"></span>
                    </button>
                    <p class="mt-2 text-center text-xs text-gray-400 dark:text-gray-500">Pembaruan otomatis aktif</p>
                </div>
            </div>

            <!-- Order Details -->
            <div class="mb-4 overflow-hidden rounded-xl bg-white shadow-theme-sm dark:bg-gray-800">
                <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Detail Pesanan</h3>
                </div>
                <div class="space-y-3 px-5 py-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Meja</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $order->table->name }}
                            @if($order->table->area)
                                <span class="text-gray-500 dark:text-gray-500">- {{ $order->table->area->name }}</span>
                            @endif
                        </span>
                    </div>
                    @if($order->customer_name)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Nama</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $order->customer_name }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Waktu Pesan</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6 overflow-hidden rounded-xl bg-white shadow-theme-sm dark:bg-gray-800">
                <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Item Pesanan</h3>
                </div>
                <div class="space-y-4 px-5 py-4">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $item->menu_item_name }}</p>
                                @if($item->notes)
                                    <p class="mt-0.5 text-xs italic text-gray-500 dark:text-gray-500">"{{ $item->notes }}"</p>
                                @endif
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $item->quantity }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                </p>
                                
                                <!-- Item Status Badge -->
                                <div class="mt-2">
                                    @switch($item->status)
                                        @case('pending')
                                            <span class="inline-flex rounded-md bg-warning-50 px-2 py-1 text-xs font-medium text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">Menunggu</span>
                                            @break
                                        @case('preparing')
                                            <span class="inline-flex rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">Sedang Dimasak</span>
                                            @break
                                        @case('ready')
                                            <span class="inline-flex rounded-md bg-success-50 px-2 py-1 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">Siap</span>
                                            @break
                                        @case('served')
                                            <span class="inline-flex rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-400">Disajikan</span>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                            <div class="ml-4 text-right">
                                <p class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-between border-t border-gray-100 pt-4 text-base font-bold dark:border-gray-700">
                        <span class="text-gray-900 dark:text-white">Total</span>
                        <span class="text-brand-600 dark:text-brand-400">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Add More Orders -->
            <div class="text-center">
                <a 
                    href="{{ route('qr.menu', [$order->outlet->slug, $order->table->qr_code]) }}"
                    class="inline-flex items-center font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                    <svg class="mr-2 size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Pesanan Lagi
                </a>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('orderTracking', () => ({
                isRefreshing: false,
                autoRefreshInterval: null,

                startAutoRefresh() {
                    this.autoRefreshInterval = setInterval(() => {
                        this.refreshStatus(true);
                    }, 10000); // 10 seconds
                },

                async refreshStatus(isAuto = false) {
                    if (!isAuto) {
                        this.isRefreshing = true;
                    }

                    try {
                        const response = await fetch('{{ route('qr.status', $order->order_number) }}');
                        const data = await response.json();

                        if (data.success) {
                            // If status changed, reload page to update UI
                            if (data.status !== '{{ $order->status }}') {
                                window.location.reload();
                            }
                        }
                    } catch (error) {
                        console.error('Error refreshing status:', error);
                    } finally {
                        this.isRefreshing = false;
                    }
                }
            }));
        });
    </script>
</x-layouts.guest-qr>
