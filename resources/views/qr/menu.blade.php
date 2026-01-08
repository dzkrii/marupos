<x-layouts.guest-qr>
    <x-slot name="title">{{ $outlet->name }} - Menu</x-slot>

    <div class="min-h-screen pb-24" x-data="qrMenu">
        <!-- Header -->
        <div class="sticky top-0 z-30 bg-white border-b border-neutral-200 shadow-sm">
            <div class="px-4 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-bold text-neutral-900">{{ $outlet->name }}</h1>
                        <p class="text-sm text-neutral-600">
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Meja {{ $table->name }}
                            </span>
                            @if($table->area)
                                <span class="ml-2 text-neutral-400">{{ $table->area->name }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="px-4 pb-3 overflow-x-auto">
                <div class="flex space-x-2">
                    <button 
                        @click="selectedCategory = null"
                        :class="selectedCategory === null ? 'bg-primary-500 text-white' : 'bg-neutral-100 text-neutral-700 hover:bg-neutral-200'"
                        class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-colors">
                        Semua
                    </button>
                    @foreach($categories as $category)
                        <button 
                            @click="selectedCategory = {{ $category->id }}"
                            :class="selectedCategory === {{ $category->id }} ? 'bg-primary-500 text-white' : 'bg-neutral-100 text-neutral-700 hover:bg-neutral-200'"
                            class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-colors">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Menu Items Grid -->
        <div class="px-4 py-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($menuItems as $item)
                    <div 
                        x-show="selectedCategory === null || selectedCategory === {{ $item->menu_category_id }}"
                        x-transition
                        class="card overflow-hidden hover:shadow-md transition-shadow">
                        
                        @if($item->image)
                            <img 
                                src="{{ Storage::url($item->image) }}" 
                                alt="{{ $item->name }}"
                                class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gradient-to-br from-neutral-100 to-neutral-200 flex items-center justify-center">
                                <svg class="w-16 h-16 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        <div class="p-4">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-neutral-900">{{ $item->name }}</h3>
                                    <p class="text-xs text-neutral-500 mt-1">{{ $item->category->name }}</p>
                                </div>
                                @if(!$item->is_available || !$item->isInStock())
                                    <span class="badge-warning text-xs">Habis</span>
                                @endif
                            </div>

                            @if($item->description)
                                <p class="text-sm text-neutral-600 mb-3 line-clamp-2">{{ $item->description }}</p>
                            @endif

                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-primary-600">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </span>

                                @if($item->is_available && $item->isInStock())
                                    <button 
                                        @click="openAddModal({{ $item->id }}, '{{ $item->name }}', {{ $item->price }})"
                                        class="btn-primary text-sm py-2 px-3">
                                        <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Tambah
                                    </button>
                                @else
                                    <button disabled class="px-3 py-2 bg-neutral-200 text-neutral-500 rounded-lg text-sm cursor-not-allowed">
                                        Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($menuItems->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6M9 21H3"/>
                    </svg>
                    <p class="text-neutral-500">Belum ada menu tersedia</p>
                </div>
            @endif
        </div>

        <!-- Floating Cart Button -->
        <div class="fixed bottom-0 left-0 right-0 z-40 p-4 bg-gradient-to-t from-white via-white to-transparent">
            <button 
                @click="window.location.href = '{{ route('qr.cart.view') }}'"
                x-show="cartCount > 0"
                x-transition
                class="w-full btn-primary py-4 text-lg font-semibold shadow-lg relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 bg-white text-primary-600 rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm" x-text="cartCount"></span>
                Lihat Keranjang
                <svg class="w-6 h-6 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </button>
        </div>

        <!-- Add to Cart Modal -->
        <div 
            x-show="showAddModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;">
            
            <div class="flex items-end sm:items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="closeAddModal"></div>

                <div 
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    
                    <div>
                        <h3 class="text-lg font-semibold text-neutral-900 mb-4" x-text="modalItem.name"></h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Jumlah</label>
                            <div class="flex items-center space-x-3">
                                <button 
                                    @click="if(modalItem.quantity > 1) modalItem.quantity--"
                                    class="w-10 h-10 rounded-lg bg-neutral-100 hover:bg-neutral-200 flex items-center justify-center text-neutral-700 font-semibold">
                                    -
                                </button>
                                <input 
                                    type="number" 
                                    x-model="modalItem.quantity"
                                    min="1"
                                    class="w-20 text-center border border-neutral-300 rounded-lg py-2 font-semibold">
                                <button 
                                    @click="modalItem.quantity++"
                                    class="w-10 h-10 rounded-lg bg-neutral-100 hover:bg-neutral-200 flex items-center justify-center text-neutral-700 font-semibold">
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Catatan (Opsional)</label>
                            <textarea 
                                x-model="modalItem.notes"
                                rows="3"
                                placeholder="Contoh: Tidak pedas, tanpa bawang"
                                class="w-full border border-neutral-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                        </div>

                        <div class="flex items-center justify-between mb-4 p-3 bg-neutral-50 rounded-lg">
                            <span class="text-neutral-700">Subtotal</span>
                            <span class="text-xl font-bold text-primary-600" x-text="formatPrice(modalItem.price * modalItem.quantity)"></span>
                        </div>

                        <div class="flex space-x-3">
                            <button 
                                @click="closeAddModal"
                                class="flex-1 px-4 py-3 border border-neutral-300 rounded-lg text-neutral-700 font-medium hover:bg-neutral-50 transition-colors">
                                Batal
                            </button>
                            <button 
                                @click="addToCart"
                                class="flex-1 btn-primary py-3">
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('qrMenu', () => ({
                selectedCategory: null,
                cartCount: {{ Session::has('qr_cart') ? count(Session::get('qr_cart')['items']) : 0 }},
                showAddModal: false,
                modalItem: {
                    id: null,
                    name: '',
                    price: 0,
                    quantity: 1,
                    notes: ''
                },

                openAddModal(id, name, price) {
                    this.modalItem = {
                        id: id,
                        name: name,
                        price: price,
                        quantity: 1,
                        notes: ''
                    };
                    this.showAddModal = true;
                },

                closeAddModal() {
                    this.showAddModal = false;
                    this.modalItem = {
                        id: null,
                        name: '',
                        price: 0,
                        quantity: 1,
                        notes: ''
                    };
                },

                async addToCart() {
                    try {
                        const response = await fetch('{{ route('qr.cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                menu_item_id: this.modalItem.id,
                                quantity: this.modalItem.quantity,
                                notes: this.modalItem.notes
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.cartCount = data.cart_count;
                            this.closeAddModal();
                            
                            // Show success toast (simple alert for now)
                            alert('✓ Item berhasil ditambahkan ke keranjang!');
                        } else {
                            alert('✗ ' + data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    }
                },

                formatPrice(price) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                }
            }));
        });
    </script>
</x-layouts.guest-qr>
