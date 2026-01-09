<x-layouts.guest-qr>
    <x-slot name="title">Pesanan Berhasil - {{ $order->outlet->name }}</x-slot>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="mx-auto max-w-lg px-4 py-12">
            <!-- Success Icon -->
            <div class="mb-8 text-center">
                <div class="mb-6 inline-flex size-24 items-center justify-center rounded-full bg-success-50 text-success-600 shadow-theme-sm dark:bg-success-500/10 dark:text-success-400">
                    <svg class="size-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Pesanan Berhasil!</h1>
                <p class="text-gray-600 dark:text-gray-400">Pesanan Anda telah diterima dan sedang diproses.</p>
            </div>

            <!-- Order Number -->
            <div class="mb-6 rounded-2xl border border-brand-100 bg-gradient-to-br from-white to-brand-50 p-6 text-center shadow-theme-xs dark:border-brand-500/20 dark:from-gray-800 dark:to-gray-800">
                <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Pesanan</p>
                <h2 class="text-4xl font-extrabold tracking-tight text-brand-600 dark:text-brand-400">{{ $order->order_number }}</h2>
            </div>

            <!-- Order Details -->
            <div class="mb-4 overflow-hidden rounded-xl bg-white shadow-theme-sm dark:bg-gray-800">
                <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-700">
                    <h3 class="flex items-center font-semibold text-gray-900 dark:text-white">
                        <svg class="mr-2.5 size-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Detail Pesanan
                    </h3>
                </div>

                <div class="space-y-3 px-5 py-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Meja</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $order->table->name }}</span>
                    </div>
                    @if($order->customer_name)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Nama</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $order->customer_name }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Waktu</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Status</span>
                        <span class="inline-flex items-center rounded-full bg-warning-50 px-2.5 py-0.5 text-xs font-medium text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6 overflow-hidden rounded-xl bg-white shadow-theme-sm dark:bg-gray-800">
                <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Item Pesanan</h3>
                </div>
                <div class="space-y-3 px-5 py-4">
                    @foreach($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $item->menu_item_name }}</p>
                                @if($item->notes)
                                    <p class="mt-0.5 text-xs italic text-gray-500 dark:text-gray-500">"{{ $item->notes }}"</p>
                                @endif
                            </div>
                            <div class="ml-4 text-right">
                                <p class="text-gray-900 dark:text-white">{{ $item->quantity }}x</p>
                                <p class="text-gray-500 dark:text-gray-400">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4 flex justify-between border-t border-gray-100 pt-4 text-base font-bold dark:border-gray-700">
                        <span class="text-gray-900 dark:text-white">Total</span>
                        <span class="text-brand-600 dark:text-brand-400">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="mb-8 flex gap-3 rounded-xl bg-blue-50 p-4 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                <svg class="size-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm">
                    Pesanan Anda akan segera diproses oleh dapur. Silakan cek status pesanan secara berkala.
                </p>
            </div>

            <!-- Actions -->
            <div class="grid gap-3">
                <a 
                    href="{{ route('qr.track', $order->order_number) }}"
                    class="flex w-full items-center justify-center rounded-xl bg-brand-600 px-4 py-3.5 text-sm font-bold text-white shadow-theme-xs transition-all hover:bg-brand-700 active:scale-[0.98]">
                    Lacak Pesanan
                    <svg class="ml-2 size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </a>

                <div class="grid grid-cols-2 gap-3">
                    <a 
                        href="{{ route('qr.receipt', $order->order_number) }}"
                        target="_blank"
                        class="flex w-full items-center justify-center rounded-xl bg-white border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition-all hover:bg-gray-50 active:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-700">
                        <svg class="mr-2 size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Struk
                    </a>

                    <a 
                        href="{{ route('qr.menu', [$order->outlet->slug, $order->table->qr_code]) }}"
                        class="flex w-full items-center justify-center rounded-xl bg-white border border-gray-200 px-4 py-3 text-sm font-semibold text-brand-600 shadow-sm transition-all hover:bg-brand-50 active:bg-brand-100 dark:bg-gray-800 dark:border-gray-700 dark:text-brand-400 dark:hover:bg-gray-700">
                        Pesan Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest-qr>
