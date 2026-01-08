<x-layouts.guest-qr>
    <x-slot name="title">Lacak Pesanan - {{ $order->order_number }}</x-slot>

    <div class="min-h-screen bg-neutral-50 pb-8" x-data="orderTracking" x-init="startAutoRefresh">
        <!-- Header -->
        <div class="sticky top-0 z-30 bg-white border-b border-neutral-200 shadow-sm">
            <div class="px-4 py-4">
                <h1 class="text-xl font-bold text-neutral-900">Lacak Pesanan</h1>
                <p class="text-sm text-neutral-600">{{ $order->order_number }}</p>
            </div>
        </div>

        <div class="px-4 py-6 max-w-2xl mx-auto">
            <!-- Order Status Progress -->
            <div class="card mb-6">
                <h3 class="font-semibold text-neutral-900 mb-4">Status Pesanan</h3>
                
                <div class="relative">
                    <!-- Progress Steps -->
                    <div class="space-y-4">
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

                            <div class="flex items-center">
                                <!-- Icon Circle -->
                                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $isActive ? 'bg-secondary-500' : 'bg-neutral-200' }} transition-colors">
                                    <svg class="w-6 h-6 {{ $isActive ? 'text-white' : 'text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $status['icon'] }}"/>
                                    </svg>
                                </div>

                                <!-- Label -->
                                <div class="ml-4 flex-1">
                                    <p class="font-medium {{ $isActive ? 'text-neutral-900' : 'text-neutral-400' }}">
                                        {{ $status['label'] }}
                                    </p>
                                    @if($isCurrent)
                                        <p class="text-xs text-secondary-600 flex items-center mt-1">
                                            <span class="inline-block w-2 h-2 bg-secondary-500 rounded-full mr-2 animate-pulse"></span>
                                            Saat ini
                                        </p>
                                    @endif
                                </div>

                                <!-- Checkmark for completed -->
                                @if($isActive && !$isCurrent)
                                    <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>

                            <!-- Connecting Line -->
                            @if(!$loop->last)
                                <div class="ml-5 w-0.5 h-8 {{ $isActive && $stepIndex < $currentIndex ? 'bg-secondary-500' : 'bg-neutral-200' }}"></div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Refresh Button -->
                <div class="mt-4 pt-4 border-t border-neutral-200">
                    <button 
                        @click="refreshStatus"
                        :disabled="isRefreshing"
                        class="text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center">
                        <svg 
                            class="w-4 h-4 mr-2" 
                            :class="{ 'animate-spin': isRefreshing }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span x-text="isRefreshing ? 'Memperbarui...' : 'Perbarui Status'"></span>
                    </button>
                    <p class="text-xs text-neutral-500 mt-1">Diperbarui otomatis setiap 10 detik</p>
                </div>
            </div>

            <!-- Order Details -->
            <div class="card mb-4">
                <h3 class="font-semibold text-neutral-900 mb-3">Detail Pesanan</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Meja</span>
                        <span class="font-medium text-neutral-900">{{ $order->table->name }}
                            @if($order->table->area)
                                <span class="text-neutral-500">- {{ $order->table->area->name }}</span>
                            @endif
                        </span>
                    </div>
                    @if($order->customer_name)
                        <div class="flex justify-between">
                            <span class="text-neutral-600">Nama</span>
                            <span class="font-medium text-neutral-900">{{ $order->customer_name }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Waktu Pesan</span>
                        <span class="font-medium text-neutral-900">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card mb-6">
                <h3 class="font-semibold text-neutral-900 mb-3">Item Pesanan</h3>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-start pb-3 border-b border-neutral-100 last:border-b-0 last:pb-0">
                            <div class="flex-1">
                                <p class="font-medium text-neutral-900">{{ $item->menu_item_name }}</p>
                                @if($item->notes)
                                    <p class="text-xs text-neutral-500 italic mt-1">{{ $item->notes }}</p>
                                @endif
                                <p class="text-sm text-neutral-600 mt-1">
                                    {{ $item->quantity }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                </p>
                                
                                <!-- Item Status Badge -->
                                <div class="mt-2">
                                    @switch($item->status)
                                        @case('pending')
                                            <span class="badge-warning text-xs">Menunggu</span>
                                            @break
                                        @case('preparing')
                                            <span class="badge-occupied text-xs">Sedang Dimasak</span>
                                            @break
                                        @case('ready')
                                            <span class="badge-available text-xs">Siap</span>
                                            @break
                                        @case('served')
                                            <span class="badge-available text-xs">Disajikan</span>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                            <div class="text-right ml-4">
                                <p class="font-bold text-neutral-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-3 border-t-2 border-neutral-200 flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span class="text-primary-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Add More Orders -->
            <div class="text-center">
                <a 
                    href="{{ route('qr.menu', [$order->outlet->slug, $order->table->qr_code]) }}"
                    class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Pesanan Lagi
                </a>
            </div>
        </div>
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
