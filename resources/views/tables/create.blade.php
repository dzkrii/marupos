<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('tables.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Meja') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('tables.store') }}" method="POST">
                        @csrf

                        {{-- Area --}}
                        <div class="mb-6">
                            <label for="table_area_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Area Meja
                            </label>
                            <select name="table_area_id" id="table_area_id"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">Tanpa Area</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ old('table_area_id', request('area')) == $area->id ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('table_area_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Table Number --}}
                        <div class="mb-6">
                            <label for="number" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Meja <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="number" id="number" value="{{ old('number') }}"
                                   placeholder="Contoh: T01, A1, VIP-1"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                   required autofocus>
                            <p class="mt-1 text-sm text-gray-500">Nomor ini akan ditampilkan di QR code</p>
                            @error('number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Table Name (Optional) --}}
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Meja (Opsional)
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                   placeholder="Contoh: Meja Dekat Jendela, VIP Room 1"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Capacity --}}
                        <div class="mb-6">
                            <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                                Kapasitas <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-4">
                                <input type="number" name="capacity" id="capacity" value="{{ old('capacity', 4) }}"
                                       class="w-24 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                       min="1" max="50" required>
                                <span class="text-sm text-gray-500">orang</span>
                            </div>
                            @error('capacity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked
                                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-700">Aktif</span>
                            </label>
                        </div>

                        {{-- Info --}}
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg text-sm text-blue-800">
                            <div class="flex">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <p>QR code akan otomatis dibuat setelah meja ditambahkan.</p>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-4 pt-4 border-t">
                            <a href="{{ route('tables.index') }}"
                               class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
