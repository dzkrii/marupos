<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Menu') }}
            </h2>
            <a href="{{ route('menu-items.create') }}"
               class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Menu
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-secondary-50 p-4 text-sm text-secondary-800 border border-secondary-200" role="alert">
                    <span class="font-medium">Berhasil!</span> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-lg bg-primary-50 p-4 text-sm text-primary-800 border border-primary-200" role="alert">
                    <span class="font-medium">Error!</span> {{ session('error') }}
                </div>
            @endif

            {{-- Filters --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form action="{{ route('menu-items.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                   placeholder="Nama menu..."
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                        <div class="w-48">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="category" id="category"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->icon }} {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                                Filter
                            </button>
                            @if (request('search') || request('category'))
                                <a href="{{ route('menu-items.index') }}"
                                   class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($menuItems->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada menu</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan menu pertama Anda.</p>
                            <div class="mt-6">
                                <a href="{{ route('menu-items.create') }}"
                                   class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500">
                                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Menu
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($menuItems as $item)
                                <div class="bg-white border rounded-xl overflow-hidden hover:shadow-lg transition-shadow duration-200">
                                    {{-- Image --}}
                                    <div class="aspect-video bg-gray-100 relative">
                                        @if ($item->image)
                                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <span class="text-4xl">{{ $item->category->icon ?? '🍽️' }}</span>
                                            </div>
                                        @endif

                                        {{-- Availability Badge --}}
                                        @if (!$item->is_available)
                                            <div class="absolute top-2 right-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Habis
                                                </span>
                                            </div>
                                        @endif

                                        @if (!$item->is_active)
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                                <span class="text-white font-medium">Nonaktif</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Content --}}
                                    <div class="p-4">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $item->name }}</h3>
                                                <p class="text-sm text-gray-500">{{ $item->category->name }}</p>
                                            </div>
                                        </div>

                                        <p class="text-lg font-bold text-primary-600 mb-3">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </p>

                                        {{-- Actions --}}
                                        <div class="flex items-center gap-2 pt-3 border-t">
                                            <form action="{{ route('menu-items.toggle-availability', $item) }}" method="POST"
                                                  class="flex-1">
                                                @csrf
                                                <button type="submit"
                                                        class="w-full text-center text-sm py-1.5 rounded-lg {{ $item->is_available ? 'bg-secondary-50 text-secondary-700 hover:bg-secondary-100' : 'bg-warning-50 text-warning-700 hover:bg-warning-100' }}">
                                                    {{ $item->is_available ? '✓ Tersedia' : '✗ Tidak Tersedia' }}
                                                </button>
                                            </form>
                                            <a href="{{ route('menu-items.edit', $item) }}"
                                               class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 border rounded-lg hover:bg-gray-50">
                                                Edit
                                            </a>
                                            <form action="{{ route('menu-items.destroy', $item) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-3 py-1.5 text-sm text-red-600 hover:text-red-900 border rounded-lg hover:bg-red-50">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $menuItems->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
