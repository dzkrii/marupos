<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Area Meja') }}
            </h2>
            <a href="{{ route('table-areas.create') }}"
               class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Area
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($areas->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada area</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan area meja seperti Indoor, Outdoor, dll.</p>
                            <div class="mt-6">
                                <a href="{{ route('table-areas.create') }}"
                                   class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500">
                                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Area
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($areas as $area)
                                <div class="bg-white border rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <h3 class="font-semibold text-lg text-gray-900">{{ $area->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $area->tables_count }} meja</p>
                                        </div>
                                        @if ($area->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-2 pt-4 border-t">
                                        <a href="{{ route('table-areas.edit', $area) }}"
                                           class="flex-1 text-center px-3 py-2 text-sm text-gray-600 hover:text-gray-900 border rounded-lg hover:bg-gray-50">
                                            Edit
                                        </a>
                                        <form action="{{ route('table-areas.destroy', $area) }}" method="POST" class="flex-1"
                                              onsubmit="return confirm('Yakin ingin menghapus area ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full px-3 py-2 text-sm text-red-600 hover:text-red-900 border rounded-lg hover:bg-red-50">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
