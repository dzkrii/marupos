<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('tables.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Meja') }} - {{ $table->number }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('tables.update', $table) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Area --}}
                        <div class="mb-6">
                            <label for="table_area_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Area Meja
                            </label>
                            <select name="table_area_id" id="table_area_id"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">Tanpa Area</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ old('table_area_id', $table->table_area_id) == $area->id ? 'selected' : '' }}>
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
                            <input type="text" name="number" id="number" value="{{ old('number', $table->number) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                   required autofocus>
                            @error('number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Table Name (Optional) --}}
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Meja (Opsional)
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $table->name) }}"
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
                                <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $table->capacity) }}"
                                       class="w-24 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                       min="1" max="50" required>
                                <span class="text-sm text-gray-500">orang</span>
                            </div>
                            @error('capacity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Current QR Code --}}
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 mb-2">QR Code URL</label>
                            <p class="text-sm text-gray-600 break-all">{{ $table->qr_code }}</p>
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('tables.download-qr', $table) }}"
                                   class="inline-flex items-center px-3 py-1.5 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download QR
                                </a>
                                <form action="{{ route('tables.regenerate-qr', $table) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Regenerate
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1"
                                       {{ old('is_active', $table->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-700">Aktif</span>
                            </label>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-between pt-4 border-t">
                            <form action="{{ route('tables.destroy', $table) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus meja ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-900">
                                    Hapus Meja
                                </button>
                            </form>

                            <div class="flex items-center gap-4">
                                <a href="{{ route('tables.index') }}"
                                   class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                                    Batal
                                </a>
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
