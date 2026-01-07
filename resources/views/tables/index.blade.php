<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Meja') }}
            </h2>
            <a href="{{ route('tables.create') }}"
               class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Meja
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

            {{-- Statistics --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-gray-400">
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-600">Total Meja</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-secondary-500">
                    <div class="text-2xl font-bold text-secondary-600">{{ $stats['available'] }}</div>
                    <div class="text-sm text-gray-600">Tersedia</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-primary-500">
                    <div class="text-2xl font-bold text-primary-600">{{ $stats['occupied'] }}</div>
                    <div class="text-sm text-gray-600">Terisi</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-accent-500">
                    <div class="text-2xl font-bold text-accent-600">{{ $stats['reserved'] }}</div>
                    <div class="text-sm text-gray-600">Reserved</div>
                </div>
            </div>

            {{-- Legend --}}
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="flex flex-wrap gap-4 text-sm">
                    <div class="flex items-center">
                        <span class="w-4 h-4 rounded-full bg-secondary-500 mr-2"></span>
                        <span>Tersedia</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 rounded-full bg-primary-500 mr-2"></span>
                        <span>Terisi</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 rounded-full bg-accent-500 mr-2"></span>
                        <span>Reserved</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 rounded-full bg-gray-400 mr-2"></span>
                        <span>Maintenance</span>
                    </div>
                </div>
            </div>

            {{-- Floor Plan by Area --}}
            @if ($areas->isEmpty())
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada area meja</h3>
                    <p class="mt-1 text-sm text-gray-500">Buat area meja terlebih dahulu sebelum menambahkan meja.</p>
                    <div class="mt-6">
                        <a href="{{ route('table-areas.create') }}"
                           class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500">
                            Tambah Area
                        </a>
                    </div>
                </div>
            @else
                @foreach ($areas as $area)
                    <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b">
                            <h3 class="font-semibold text-lg text-gray-900">{{ $area->name }}</h3>
                        </div>
                        <div class="p-6">
                            @if ($area->tables->isEmpty())
                                <div class="text-center py-8 text-gray-500">
                                    <p>Belum ada meja di area ini</p>
                                    <a href="{{ route('tables.create') }}?area={{ $area->id }}"
                                       class="mt-2 inline-flex items-center text-primary-600 hover:text-primary-800 text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Tambah Meja
                                    </a>
                                </div>
                            @else
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                    @foreach ($area->tables as $table)
                                        @php
                                            $statusColors = [
                                                'available' => 'bg-secondary-100 border-secondary-500 hover:bg-secondary-200',
                                                'occupied' => 'bg-primary-100 border-primary-500 hover:bg-primary-200',
                                                'reserved' => 'bg-accent-100 border-accent-500 hover:bg-accent-200',
                                                'maintenance' => 'bg-gray-100 border-gray-400 hover:bg-gray-200',
                                            ];
                                            $colorClass = $statusColors[$table->status] ?? $statusColors['available'];
                                        @endphp
                                        <div class="relative group">
                                            <div class="aspect-square rounded-xl border-2 {{ $colorClass }} flex flex-col items-center justify-center cursor-pointer transition-all duration-200 {{ !$table->is_active ? 'opacity-50' : '' }}"
                                                 onclick="openTableModal({{ $table->id }}, '{{ $table->number }}', '{{ $table->name ?? '' }}', {{ $table->capacity }}, '{{ $table->status }}', '{{ $table->qr_code }}')">
                                                <span class="text-xl font-bold text-gray-800">{{ $table->number }}</span>
                                                @if ($table->name)
                                                    <span class="text-xs text-gray-500">{{ Str::limit($table->name, 10) }}</span>
                                                @endif
                                                <div class="flex items-center text-xs text-gray-600 mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                    </svg>
                                                    {{ $table->capacity }}
                                                </div>
                                            </div>
                                            {{-- Quick Edit --}}
                                            <a href="{{ route('tables.edit', $table) }}"
                                               class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 p-1 bg-white rounded-full shadow text-gray-600 hover:text-gray-900 transition-opacity">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Table Detail Modal --}}
    <div id="tableModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeTableModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900" id="modalTableNumber">Meja</h3>
                            <p class="text-sm text-gray-500" id="modalTableName"></p>
                        </div>
                        <button onclick="closeTableModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        {{-- Capacity --}}
                        <div class="flex items-center text-sm">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Kapasitas: <strong id="modalCapacity">4</strong> orang</span>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ubah Status</label>
                            <form id="statusForm" method="POST" class="flex flex-wrap gap-2">
                                @csrf
                                <button type="submit" name="status" value="available"
                                        class="px-3 py-1.5 text-sm rounded-full border-2 border-secondary-500 bg-secondary-100 text-secondary-800 hover:bg-secondary-200 transition status-btn">
                                    Tersedia
                                </button>
                                <button type="submit" name="status" value="occupied"
                                        class="px-3 py-1.5 text-sm rounded-full border-2 border-primary-500 bg-primary-100 text-primary-800 hover:bg-primary-200 transition status-btn">
                                    Terisi
                                </button>
                                <button type="submit" name="status" value="reserved"
                                        class="px-3 py-1.5 text-sm rounded-full border-2 border-accent-500 bg-accent-100 text-accent-800 hover:bg-accent-200 transition status-btn">
                                    Reserved
                                </button>
                                <button type="submit" name="status" value="maintenance"
                                        class="px-3 py-1.5 text-sm rounded-full border-2 border-gray-400 bg-gray-100 text-gray-800 hover:bg-gray-200 transition status-btn">
                                    Maintenance
                                </button>
                            </form>
                        </div>

                        {{-- QR Code --}}
                        <div class="pt-4 border-t">
                            <label class="block text-sm font-medium text-gray-700 mb-2">QR Code</label>
                            <div class="flex items-center gap-4">
                                <div id="qrCodeContainer" class="bg-white p-2 border rounded-lg">
                                    {{-- QR Code will be generated here --}}
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-2" id="modalQrUrl"></p>
                                    <a id="downloadQrBtn" href="#"
                                       class="inline-flex items-center px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Download QR
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <a id="editTableBtn" href="#"
                       class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Edit Meja
                    </a>
                    <button type="button" onclick="closeTableModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentTableId = null;

        function openTableModal(id, number, name, capacity, status, qrUrl) {
            currentTableId = id;

            document.getElementById('modalTableNumber').textContent = 'Meja ' + number;
            document.getElementById('modalTableName').textContent = name || '';
            document.getElementById('modalCapacity').textContent = capacity;
            document.getElementById('modalQrUrl').textContent = qrUrl;

            // Update status form action
            document.getElementById('statusForm').action = '/tables/' + id + '/status';

            // Update edit button
            document.getElementById('editTableBtn').href = '/tables/' + id + '/edit';

            // Update download QR button
            document.getElementById('downloadQrBtn').href = '/tables/' + id + '/download-qr';

            // Generate simple QR placeholder (in production, use a QR library)
            document.getElementById('qrCodeContainer').innerHTML = '<div class="w-24 h-24 flex items-center justify-center bg-gray-100 rounded"><svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg></div>';

            // Highlight current status
            document.querySelectorAll('.status-btn').forEach(btn => {
                btn.classList.remove('ring-2', 'ring-offset-2');
                if (btn.value === status) {
                    btn.classList.add('ring-2', 'ring-offset-2');
                }
            });

            document.getElementById('tableModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeTableModal() {
            document.getElementById('tableModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentTableId = null;
        }

        // Close on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeTableModal();
            }
        });
    </script>
</x-app-layout>
