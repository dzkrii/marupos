<x-layouts.guest-qr>
    <x-slot name="title">Pesanan Berhasil - {{ $order->outlet->name }}</x-slot>

    <div class="min-h-screen bg-neutral-50">
        <div class="px-4 py-8 max-w-lg mx-auto">
            <!-- Success Icon -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-secondary-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-neutral-900 mb-2">Pesanan Berhasil!</h1>
                <p class="text-neutral-600">Pesanan Anda sedang diproses</p>
            </div>

            <!-- Order Number -->
            <div class="card text-center mb-6 bg-gradient-to-br from-primary-50 to-accent-50 border-2 border-primary-200">
                <p class="text-sm text-neutral-600 mb-1">Nomor Pesanan</p>
                <h2 class="text-3xl font-bold text-primary-600">{{ $order->order_number }}</h2>
            </div>

            <!-- Order Details -->
            <div class="card mb-4">
                <h3 class="font-semibold text-neutral-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Detail Pesanan
                </h3>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Meja</span>
                        <span class="font-medium text-neutral-900">{{ $order->table->name }}</span>
                    </div>
                    @if($order->customer_name)
                        <div class="flex justify-between">
                            <span class="text-neutral-600">Nama</span>
                            <span class="font-medium text-neutral-900">{{ $order->customer_name }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Waktu</span>
                        <span class="font-medium text-neutral-900">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Status</span>
                        <span class="badge-warning">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card mb-6">
                <h3 class="font-semibold text-neutral-900 mb-3">Item Pesanan</h3>
                <div class="space-y-2">
                    @foreach($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <div class="flex-1">
                                <p class="text-neutral-900">{{ $item->menu_item_name }}</p>
                                @if($item->notes)
                                    <p class="text-xs text-neutral-500 italic">{{ $item->notes }}</p>
                                @endif
                            </div>
                            <div class="text-right ml-4">
                                <p class="text-neutral-900">{{ $item->quantity }}x</p>
                                <p class="text-neutral-600">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-3 border-t border-neutral-200 flex justify-between font-bold">
                        <span>Total</span>
                        <span class="text-primary-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-accent-50 border border-accent-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-accent-800">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pesanan Anda akan segera diproses oleh dapur. Silakan cek status pesanan secara berkala.
                </p>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <a 
                    href="{{ route('qr.track', $order->order_number) }}"
                    class="block w-full btn-primary py-3 text-center">
                    Lacak Pesanan
                    <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </a>

                <a 
                    href="{{ route('qr.receipt', $order->order_number) }}"
                    target="_blank"
                    class="block w-full text-center px-4 py-3 bg-secondary-500 text-white font-medium rounded-lg hover:bg-secondary-600 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print Receipt
                </a>

                <a 
                    href="{{ route('qr.menu', [$order->outlet->slug, $order->table->qr_code]) }}"
                    class="block w-full text-center px-4 py-3 border-2 border-primary-500 text-primary-600 font-medium rounded-lg hover:bg-primary-50 transition-colors">
                    Tambah Pesanan Lagi
                </a>
            </div>
        </div>
    </div>
</x-layouts.guest-qr>
