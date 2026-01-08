<x-layouts.guest-qr>
    <x-slot name="title">Keranjang - {{ $outlet->name }}</x-slot>

    <div class="min-h-screen bg-neutral-50 pb-32" x-data="cartPage">
        <!-- Header -->
        <div class="sticky top-0 z-30 bg-white border-b border-neutral-200 shadow-sm">
            <div class="px-4 py-4 flex items-center">
                <a href="javascript:history.back()" class="mr-3 text-neutral-600 hover:text-neutral-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-neutral-900">Keranjang Belanja</h1>
            </div>
        </div>

        <div class="px-4 py-6 max-w-2xl mx-auto">
            <!-- Cart Items -->
            <div class="space-y-3 mb-6">
                @foreach($cart['items'] as $index => $item)
                    <div class="card">
                        <div class="flex gap-3">
                            @if(isset($item['image']) && $item['image'])
                                <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                            @else
                                <div class="w-20 h-20 bg-neutral-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-neutral-900">{{ $item['name'] }}</h3>
                                <p class="text-sm text-neutral-600 mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                
                                @if($item['notes'])
                                    <p class="text-xs text-neutral-500 mt-1 italic">{{ $item['notes'] }}</p>
                                @endif

                                <div class="flex items-center justify-between mt-3">
                                    <!-- Quantity Adjuster -->
                                    <div class="flex items-center space-x-2">
                                        <button 
                                            @click="updateQuantity({{ $index }}, {{ $item['quantity'] - 1 }})"
                                            :disabled="{{ $item['quantity'] <= 1 }}"
                                            class="w-8 h-8 rounded-lg bg-neutral-100 hover:bg-neutral-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center text-neutral-700 font-semibold">
                                            -
                                        </button>
                                        <span class="w-8 text-center font-semibold text-neutral-900">{{ $item['quantity'] }}</span>
                                        <button 
                                            @click="updateQuantity({{ $index }}, {{ $item['quantity'] + 1 }})"
                                            class="w-8 h-8 rounded-lg bg-neutral-100 hover:bg-neutral-200 flex items-center justify-center text-neutral-700 font-semibold">
                                            +
                                        </button>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <span class="font-bold text-primary-600">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </span>
                                        <button 
                                            @click="removeItem({{ $index }})"
                                            class="text-primary-500 hover:text-primary-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="card mb-6">
                <h3 class="font-semibold text-neutral-900 mb-3">Ringkasan Pesanan</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-neutral-700">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($cart['total'], 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-2 border-t border-neutral-200 flex justify-between font-bold text-lg text-neutral-900">
                        <span>Total</span>
                        <span class="text-primary-600">Rp {{ number_format($cart['total'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer Info Form -->
            <form action="{{ route('qr.submit') }}" method="POST" class="card">
                @csrf

                <h3 class="font-semibold text-neutral-900 mb-4">Informasi Pemesan</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">
                            Nama <span class="text-neutral-400">(Opsional)</span>
                        </label>
                        <input 
                            type="text" 
                            name="customer_name"
                            placeholder="Masukkan nama Anda"
                            class="w-full border border-neutral-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">
                            No. HP <span class="text-neutral-400">(Opsional)</span>
                        </label>
                        <input 
                            type="tel" 
                            name="customer_phone"
                            placeholder="08xx xxxx xxxx"
                            class="w-full border border-neutral-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">
                            Catatan Pesanan <span class="text-neutral-400">(Opsional)</span>
                        </label>
                        <textarea 
                            name="notes"
                            rows="3"
                            placeholder="Contoh: Tolong diprioritaskan"
                            class="w-full border border-neutral-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                    </div>
                </div>
            </form>
        </div>

        <!-- Fixed Bottom Action -->
        <div class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-neutral-200 p-4 shadow-lg">
            <div class="max-w-2xl mx-auto">
                <button 
                    type="submit"
                    form="cartForm"
                    @click="submitOrder"
                    class="w-full btn-primary py-4 text-lg font-semibold">
                    Pesan Sekarang
                    <svg class="w-6 h-6 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
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
                        const response = await fetch(`{{ route('qr.cart.remove', '') }}/${index}`, {
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

                submitOrder() {
                    document.querySelector('form').submit();
                }
            }));
        });
    </script>
</x-layouts.guest-qr>
