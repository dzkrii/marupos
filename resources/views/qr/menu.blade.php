<x-layouts.guest-qr>
    <x-slot name="title">{{ $outlet->name }} - Menu</x-slot>

    <div class="min-h-screen bg-gray-50 pb-24 dark:bg-gray-900" x-data="qrMenu">
        <!-- Header -->
        <header class="sticky top-0 z-30 border-b border-gray-200 bg-white/80 backdrop-blur-md shadow-theme-xs dark:border-gray-800 dark:bg-gray-900/80">
            <div class="mx-auto max-w-lg px-4 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-lg font-bold text-gray-900 dark:text-white">{{ $outlet->name }}</h1>
                        <div class="mt-1 flex items-center gap-2">
                            <span class="inline-flex items-center text-sm font-medium text-brand-600 dark:text-brand-400">
                                <svg class="mr-1.5 size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Meja {{ $table->number }}
                            </span>
                            @if($table->area)
                                <span class="text-xs text-gray-400">•</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $table->area->name }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Search/Filter Trigger (Optional Future Feature) -->
                    {{-- <button class="rounded-full bg-gray-100 p-2 text-gray-600 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button> --}}
                </div>
            </div>

            <!-- Category Filter -->
            <div class="no-scrollbar overflow-x-auto px-4 pb-3">
                <div class="flex space-x-2">
                    <button 
                        @click="selectedCategory = null"
                        :class="selectedCategory === null ? 'bg-brand-500 text-white shadow-theme-xs' : 'bg-white text-gray-600 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'"
                        class="rounded-full px-4 py-1.5 text-sm font-medium whitespace-nowrap transition-all border border-transparent"
                        :class="selectedCategory !== null && 'border-gray-200 dark:border-gray-700'">
                        Semua
                    </button>
                    @foreach($categories as $category)
                        <button 
                            @click="selectedCategory = {{ $category->id }}"
                            :class="selectedCategory === {{ $category->id }} ? 'bg-brand-500 text-white shadow-theme-xs' : 'bg-white text-gray-600 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'"
                            class="rounded-full px-4 py-1.5 text-sm font-medium whitespace-nowrap transition-all border border-transparent"
                            :class="selectedCategory !== {{ $category->id }} && 'border-gray-200 dark:border-gray-700'">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </header>

        <!-- Menu Items Grid -->
        <main class="mx-auto max-w-lg px-4 py-6">
            <div class="space-y-4">
                @foreach($menuItems as $item)
                    <div 
                        x-show="selectedCategory === null || selectedCategory === {{ $item->menu_category_id }}"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        class="group flex overflow-hidden rounded-xl bg-white shadow-theme-sm dark:bg-gray-800">
                        
                        <div class="flex-1 p-4">
                            <div class="mb-1 flex items-start justify-between">
                                <h3 class="font-semibold text-gray-900 line-clamp-2 dark:text-white">{{ $item->name }}</h3>
                            </div>
                            
                            <p class="mb-3 text-xs text-brand-600 font-medium dark:text-brand-400">{{ $item->category->name }}</p>
                            
                            @if($item->description)
                                <p class="mb-4 text-sm text-gray-500 line-clamp-2 dark:text-gray-400">{{ $item->description }}</p>
                            @else
                                <div class="mb-4 h-5"></div> {{-- Spacer --}}
                            @endif

                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-gray-900 dark:text-white">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </span>

                                @if($item->is_available && $item->isInStock())
                                    <button 
                                        @click="openAddModal({{ $item->id }}, '{{ $item->name }}', {{ $item->price }})"
                                        class="flex items-center justify-center rounded-lg bg-brand-50 px-3 py-2 text-sm font-semibold text-brand-600 transition-colors hover:bg-brand-100 active:bg-brand-200 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20">
                                        <svg class="mr-1.5 size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Tambah
                                    </button>
                                @else
                                    <span class="rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                                        Habis
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Image on the right for mobile friendliness -->
                        <div class="w-32 bg-gray-100 shrink-0 relative">
                            @if($item->image)
                                <img 
                                    src="{{ Storage::url($item->image) }}" 
                                    alt="{{ $item->name }}"
                                    class="absolute inset-0 size-full object-cover">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-300 dark:bg-gray-700 dark:text-gray-500">
                                    <svg class="size-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($menuItems->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="mb-4 flex size-16 items-center justify-center rounded-full bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-600">
                        <svg class="size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Menu Belum Tersedia</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Silakan hubungi pelayan untuk bantuan.</p>
                </div>
            @endif
        </main>

        <!-- Floating Cart Button -->
        <div class="fixed bottom-0 left-0 right-0 z-40 mx-auto max-w-lg p-4">
            <button 
                @click="window.location.href = '{{ route('qr.cart.view') }}'"
                x-show="cartCount > 0"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-full"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="relative flex w-full items-center justify-between rounded-xl bg-gray-900 p-4 text-white shadow-theme-lg shadow-gray-900/20 active:scale-[0.98] transition-transform dark:bg-brand-600 dark:text-white dark:shadow-brand-500/20">
                <div class="flex items-center gap-3">
                    <span class="flex size-8 items-center justify-center rounded-full bg-white/20 text-sm font-bold" x-text="cartCount"></span>
                    <span class="font-semibold">Lihat Pesanan</span>
                </div>
                <div class="flex items-center">
                    <span class="mr-2 text-sm text-white/80">Total</span>
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </button>
        </div>

        <!-- Add to Cart Modal -->
        <div 
            x-show="showAddModal"
            class="relative z-50"
            role="dialog"
            aria-modal="true"
            style="display: none;">
            
            <div 
                x-show="showAddModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500/75 transition-opacity backdrop-blur-sm dark:bg-gray-900/80" 
                @click="closeAddModal"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-0 text-center sm:items-center sm:p-0">
                    <div 
                        x-show="showAddModal"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-t-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:rounded-2xl dark:bg-gray-800">
                        
                        <!-- Modal Handle for Mobile -->
                        <div class="flex justify-center pt-3 sm:hidden">
                            <div class="h-1.5 w-12 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                        </div>

                        <div class="px-4 pb-4 pt-4 sm:p-6 sm:pb-4">
                            <div class="mb-5 flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white" x-text="modalItem.name"></h3>
                                    <p class="mt-1 text-sm font-medium text-brand-600 dark:text-brand-400" x-text="formatPrice(modalItem.price) + ' / porsi'"></p>
                                </div>
                                <button @click="closeAddModal" class="rounded-full bg-gray-100 p-2 text-gray-500 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600">
                                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-4">
                                <!-- Quantity -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah Pesanan</label>
                                    <div class="flex items-center justify-between rounded-xl border border-gray-200 p-1 dark:border-gray-700">
                                        <button 
                                            @click="if(modalItem.quantity > 1) modalItem.quantity--"
                                            class="flex size-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <input 
                                            type="number" 
                                            x-model="modalItem.quantity"
                                            min="1"
                                            class="w-16 border-none bg-transparent text-center text-lg font-bold text-gray-900 focus:ring-0 dark:text-white">
                                        <button 
                                            @click="modalItem.quantity++"
                                            class="flex size-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600 hover:bg-brand-100 dark:bg-brand-500/20 dark:text-brand-400 dark:hover:bg-brand-500/30">
                                            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Khusus (Opsional)</label>
                                    <textarea 
                                        x-model="modalItem.notes"
                                        rows="3"
                                        placeholder="Contoh: Jangan terlalu pedas, kuah dipisah..."
                                        class="w-full rounded-xl border-gray-200 text-sm focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 dark:border-gray-700 dark:bg-gray-800/50">
                            <button 
                                type="button" 
                                @click="addToCart"
                                class="inline-flex w-full items-center justify-center rounded-xl bg-brand-600 px-3 py-3.5 text-sm font-semibold text-white shadow-theme-sm transition-all hover:bg-brand-700 active:scale-[0.98] sm:ml-3 sm:w-auto">
                                <span class="mr-2">Tambah ke Pesanan</span> • 
                                <span class="ml-2" x-text="formatPrice(modalItem.price * modalItem.quantity)"></span>
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
                    document.body.style.overflow = 'hidden'; // Prevent scrolling
                },

                closeAddModal() {
                    this.showAddModal = false;
                    document.body.style.overflow = ''; // Restore scrolling
                    // Reset after animation
                    setTimeout(() => {
                        this.modalItem = {
                            id: null,
                            name: '',
                            price: 0,
                            quantity: 1,
                            notes: ''
                        };
                    }, 300);
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
                            
                            // Replace alert with a better notification if possible, but for now specific styling in alert is hard
                            // We can use a custom toast in future, but standard alert is consistent with previous code
                            // Or better: Create a temporary toast using Alpine?
                            // For this iteration, let's keep it simple or user might get confused if we add too much custom JS logic without asking.
                            // But I will trigger a simple browser vibration if possible.
                            if(navigator.vibrate) navigator.vibrate(50);
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
