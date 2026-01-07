<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('menu-items.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Menu') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('menu-items.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Name --}}
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Menu <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                       required autofocus>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div>
                                <label for="menu_category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select name="menu_category_id" id="menu_category_id" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('menu_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->icon }} {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('menu_category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- SKU --}}
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                                    SKU (Kode)
                                </label>
                                <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                       placeholder="MNU-001">
                                @error('sku')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Harga Jual <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}"
                                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                           min="0" step="100" required>
                                </div>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Cost Price --}}
                            <div>
                                <label for="cost_price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Harga Modal (HPP)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="cost_price" id="cost_price" value="{{ old('cost_price') }}"
                                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                           min="0" step="100">
                                </div>
                                @error('cost_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi
                                </label>
                                <textarea name="description" id="description" rows="3"
                                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                          placeholder="Deskripsi singkat menu...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Image --}}
                            <div class="md:col-span-2">
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                    Gambar Menu
                                </label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="image"
                                           class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div id="image-preview" class="hidden w-full h-full">
                                            <img src="" alt="Preview" class="w-full h-full object-cover rounded-lg">
                                        </div>
                                        <div id="image-placeholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span></p>
                                            <p class="text-xs text-gray-500">PNG, JPG, WEBP (Max. 2MB)</p>
                                        </div>
                                        <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(this)">
                                    </label>
                                </div>
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Stock Management --}}
                            <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg">
                                <h3 class="font-medium text-gray-900 mb-4">Manajemen Stok</h3>

                                <div class="mb-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="track_stock" id="track_stock" value="1"
                                               {{ old('track_stock') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500"
                                               onchange="toggleStockInput()">
                                        <span class="ml-2 text-sm text-gray-700">Lacak stok menu ini</span>
                                    </label>
                                </div>

                                <div id="stock-input" class="{{ old('track_stock') ? '' : 'hidden' }}">
                                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jumlah Stok
                                    </label>
                                    <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}"
                                           class="w-32 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                           min="0">
                                    @error('stock')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="md:col-span-2 flex flex-wrap gap-6">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_available" value="1" checked
                                           class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                                    <span class="ml-2 text-sm text-gray-700">Tersedia untuk dipesan</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" checked
                                           class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                                </label>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t">
                            <a href="{{ route('menu-items.index') }}"
                               class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('image-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function toggleStockInput() {
            const checkbox = document.getElementById('track_stock');
            const stockInput = document.getElementById('stock-input');

            if (checkbox.checked) {
                stockInput.classList.remove('hidden');
            } else {
                stockInput.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
