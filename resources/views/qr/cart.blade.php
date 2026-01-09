<x-layouts.guest-qr>
    <x-slot name="title">Keranjang - {{ $outlet->name }}</x-slot>

    <div class="min-h-screen bg-gray-50 pb-32 dark:bg-gray-900" x-data="cartPage">
        <!-- Header -->
        <header class="sticky top-0 z-30 border-b border-gray-200 bg-white/80 backdrop-blur-md shadow-theme-xs dark:border-gray-800 dark:bg-gray-900/80">
            <div class="mx-auto flex max-w-lg items-center px-4 py-4">
                <a href="javascript:history.back()" class="mr-3 rounded-lg p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-gray-900 dark:text-white">Keranjang Belanja</h1>
            </div>
        </header>

        <main class="mx-auto max-w-lg px-4 py-6">
            <!-- Cart Items -->
            <div class="mb-6 space-y-4">
                @foreach($cart['items'] as $index => $item)
                    <div class="flex flex-col gap-4 rounded-xl bg-white p-4 shadow-theme-sm dark:bg-gray-800">
                        <div class="flex gap-4">
                            @if(isset($item['image']) && $item['image'])
                                <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="size-20 shrink-0 rounded-lg object-cover bg-gray-100 dark:bg-gray-700">
                            @else
                                <div class="flex size-20 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-700 dark:text-gray-500">
                                    <svg class="size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif

                            <div class="flex min-w-0 flex-1 flex-col justify-between">
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $item['name'] }}</h3>
                                    <p class="mt-0.5 text-sm font-medium text-gray-600 dark:text-gray-400">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    @if($item['notes'])
                                        <p class="mt-1 text-xs italic text-gray-500 dark:text-gray-500">"{{ $item['notes'] }}"</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between border-t border-gray-100 pt-4 dark:border-gray-700">
                            <!-- Quantity Adjuster -->
                            <div class="flex items-center gap-3">
                                <button 
                                    @click="updateQuantity({{ $index }}, {{ $item['quantity'] - 1 }})"
                                    :disabled="{{ $item['quantity'] <= 1 }}"
                                    class="flex size-8 items-center justify-center rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>
                                <span class="w-6 text-center text-sm font-semibold text-gray-900 dark:text-white">{{ $item['quantity'] }}</span>
                                <button 
                                    @click="updateQuantity({{ $index }}, {{ $item['quantity'] + 1 }})"
                                    class="flex size-8 items-center justify-center rounded-lg bg-brand-50 text-brand-600 hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="flex items-center gap-4">
                                <span class="font-bold text-gray-900 dark:text-white">
                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </span>
                                <button 
                                    @click="removeItem({{ $index }})"
                                    class="text-error-500 hover:text-error-700 p-1">
                                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="mb-6 rounded-xl bg-white p-5 shadow-theme-sm dark:bg-gray-800">
                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Ringkasan Pesanan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Subtotal ({{ count($cart['items']) }} Item)</span>
                        <span>Rp {{ number_format($cart['total'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-100 pt-3 text-base font-bold text-gray-900 dark:border-gray-700 dark:text-white">
                        <span>Total Pembayaran</span>
                        <span class="text-brand-600 dark:text-brand-400">Rp {{ number_format($cart['total'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer Info Form -->
            <form id="cartForm" action="{{ route('qr.submit') }}" method="POST" class="rounded-xl bg-white p-5 shadow-theme-sm dark:bg-gray-800">
                @csrf

                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Informasi Pemesan</h3>

                <div class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nama <span class="text-gray-400 text-xs font-normal">(Opsional)</span>
                        </label>
                        <input 
                            type="text" 
                            name="customer_name"
                            placeholder="Masukkan nama Anda"
                            class="w-full rounded-lg border-gray-200 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            No. HP <span class="text-gray-400 text-xs font-normal">(Opsional)</span>
                        </label>
                        <input 
                            type="tel" 
                            name="customer_phone"
                            placeholder="08xx xxxx xxxx"
                            class="w-full rounded-lg border-gray-200 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Catatan Pesanan <span class="text-gray-400 text-xs font-normal">(Opsional)</span>
                        </label>
                        <textarea 
                            name="notes"
                            rows="2"
                            placeholder="Contoh: Tolong diprioritaskan"
                            class="w-full rounded-lg border-gray-200 bg-transparent px-4 py-2.5 text-sm outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:text-white"></textarea>
                    </div>
                </div>
            </form>
        </main>

        <!-- Fixed Bottom Action -->
        <div class="fixed bottom-0 left-0 right-0 z-40 mx-auto max-w-lg border-t border-gray-100 bg-white p-4 shadow-lg dark:border-gray-800 dark:bg-gray-900">
            <button 
                type="submit"
                form="cartForm"
                class="flex w-full items-center justify-center rounded-xl bg-brand-600 py-3.5 text-base font-bold text-white shadow-theme-xs transition-transform active:scale-[0.98] hover:bg-brand-700">
                Pesan Sekarang
                <svg class="ml-2 size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cartPage', () => ({
                async updateQuantity(index, newQuantity) {
                    if (newQuantity < 1) return;

                    try {
                        const response = await fetch('{{ route('qr.cart.update') }}', {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                index: index,
                                quantity: newQuantity
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('✗ ' + data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    }
                },

                async removeItem(index) {
                    if (!confirm('Hapus item ini dari keranjang?')) return;

                    try {
                        // Fix for default route parameter requirement in Laravel
                        // We use a dummy ID '0' to satisfy the route generator, effectively creating '.../remove/0'
                        // Then we replace '0' with the actual index in JS
                        let url = '{{ route('qr.cart.remove', ['index' => '0']) }}';
                        url = url.replace('/0', '/' + index);

                        const response = await fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            if (data.cart_count === 0) {
                                window.location.href = '{{ url()->previous() }}';
                            } else {
                                window.location.reload();
                            }
                        } else {
                            alert('✗ ' + data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    }
                },
            }));
        });
    </script>
</x-layouts.guest-qr>
