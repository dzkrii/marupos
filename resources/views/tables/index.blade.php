<x-app-layout>
    <x-slot name="title">Daftar Meja</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Daftar Meja</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola denah meja dan status ketersediaan</p>
        </div>
        <x-ui.button href="{{ route('tables.create') }}" variant="primary">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Meja
        </x-ui.button>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <x-ui.alert variant="success">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </x-ui.alert>
    @endif

    @if (session('error'))
        <x-ui.alert variant="error">
            <span class="font-medium">Error!</span> {{ session('error') }}
        </x-ui.alert>
    @endif

    <!-- Statistics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">
                    <svg class="size-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $stats['total'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Meja</p>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-success-50 dark:bg-success-500/10">
                    <svg class="size-5 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-success-600 dark:text-success-400">{{ $stats['available'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tersedia</p>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-error-50 dark:bg-error-500/10">
                    <svg class="size-5 text-error-600 dark:text-error-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-error-600 dark:text-error-400">{{ $stats['occupied'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Terisi</p>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-warning-50 dark:bg-warning-500/10">
                    <svg class="size-5 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-warning-600 dark:text-warning-400">{{ $stats['reserved'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Reserved</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Legend -->
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-wrap gap-6 text-sm">
            <div class="flex items-center gap-2">
                <span class="h-4 w-4 rounded-full bg-success-500"></span>
                <span class="text-gray-700 dark:text-gray-300">Tersedia</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="h-4 w-4 rounded-full bg-error-500"></span>
                <span class="text-gray-700 dark:text-gray-300">Terisi</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="h-4 w-4 rounded-full bg-warning-500"></span>
                <span class="text-gray-700 dark:text-gray-300">Reserved</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="h-4 w-4 rounded-full bg-gray-400"></span>
                <span class="text-gray-700 dark:text-gray-300">Maintenance</span>
            </div>
        </div>
    </div>

    <!-- Floor Plan by Area -->
    @if ($areas->isEmpty())
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex flex-col items-center justify-center py-16 px-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                    <svg class="size-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-base font-semibold text-gray-800 dark:text-white/90">Belum ada area meja</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Buat area meja terlebih dahulu sebelum menambahkan meja.</p>
                <x-ui.button href="{{ route('table-areas.create') }}" variant="primary" class="mt-6">
                    Tambah Area
                </x-ui.button>
            </div>
        </div>
    @else
        @foreach ($areas as $area)
            <div class="mb-6 rounded-xl border border-gray-200 bg-white overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 dark:border-gray-800 dark:bg-white/[0.02]">
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-white/90">{{ $area->name }}</h3>
                </div>
                <div class="p-6">
                    @if ($area->tables->isEmpty())
                        <div class="py-8 text-center">
                            <p class="text-gray-500 dark:text-gray-400">Belum ada meja di area ini</p>
                            <a href="{{ route('tables.create') }}?area={{ $area->id }}"
                                class="mt-2 inline-flex items-center text-brand-600 hover:text-brand-700 dark:text-brand-400 text-sm">
                                <svg class="size-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Meja
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach ($area->tables as $table)
                                @php
                                    $statusColors = [
                                        'available' => 'bg-success-50 border-success-400 hover:bg-success-100 dark:bg-success-500/10 dark:border-success-500/50 dark:hover:bg-success-500/20',
                                        'occupied' => 'bg-error-50 border-error-400 hover:bg-error-100 dark:bg-error-500/10 dark:border-error-500/50 dark:hover:bg-error-500/20',
                                        'reserved' => 'bg-warning-50 border-warning-400 hover:bg-warning-100 dark:bg-warning-500/10 dark:border-warning-500/50 dark:hover:bg-warning-500/20',
                                        'maintenance' => 'bg-gray-50 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:hover:bg-gray-700',
                                    ];
                                    $colorClass = $statusColors[$table->status] ?? $statusColors['available'];
                                @endphp
                                <div class="relative group">
                                    <div class="aspect-square rounded-xl border-2 {{ $colorClass }} flex flex-col items-center justify-center cursor-pointer transition-all duration-200 {{ !$table->is_active ? 'opacity-50' : '' }}"
                                        onclick="openTableModal({{ $table->id }}, '{{ $table->number }}', '{{ $table->name ?? '' }}', {{ $table->capacity }}, '{{ $table->status }}', '{{ $table->qr_code }}')">
                                        <span class="text-xl font-bold text-gray-800 dark:text-white/90">{{ $table->number }}</span>
                                        @if ($table->name)
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($table->name, 10) }}</span>
                                        @endif
                                        <div class="flex items-center text-xs text-gray-600 dark:text-gray-400 mt-1">
                                            <svg class="size-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            {{ $table->capacity }}
                                        </div>
                                    </div>
                                    <!-- Quick Edit -->
                                    <a href="{{ route('tables.edit', $table) }}"
                                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 flex h-7 w-7 items-center justify-center rounded-full bg-white text-gray-600 shadow-md hover:text-gray-900 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white transition-all">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
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

    <!-- Table Detail Modal -->
    <div id="tableModal" class="fixed inset-0 z-99999 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-900/50 transition-opacity" onclick="closeTableModal()"></div>

            <div class="relative w-full max-w-lg rounded-2xl border border-gray-200 bg-white shadow-xl dark:border-gray-800 dark:bg-gray-900">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90" id="modalTableNumber">Meja</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400" id="modalTableName"></p>
                        </div>
                        <button onclick="closeTableModal()" class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800">
                            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-6">
                        <!-- Capacity -->
                        <div class="flex items-center gap-3 text-sm">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">
                                <svg class="size-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Kapasitas</p>
                                <p class="font-medium text-gray-800 dark:text-white/90"><span id="modalCapacity">4</span> orang</p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-400">Ubah Status</label>
                            <form id="statusForm" method="POST" class="flex flex-wrap gap-2">
                                @csrf
                                <button type="submit" name="status" value="available"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border-2 border-success-400 bg-success-50 text-success-700 hover:bg-success-100 dark:bg-success-500/10 dark:text-success-400 dark:border-success-500/50 dark:hover:bg-success-500/20 transition-colors status-btn">
                                    Tersedia
                                </button>
                                <button type="submit" name="status" value="occupied"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border-2 border-error-400 bg-error-50 text-error-700 hover:bg-error-100 dark:bg-error-500/10 dark:text-error-400 dark:border-error-500/50 dark:hover:bg-error-500/20 transition-colors status-btn">
                                    Terisi
                                </button>
                                <button type="submit" name="status" value="reserved"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border-2 border-warning-400 bg-warning-50 text-warning-700 hover:bg-warning-100 dark:bg-warning-500/10 dark:text-warning-400 dark:border-warning-500/50 dark:hover:bg-warning-500/20 transition-colors status-btn">
                                    Reserved
                                </button>
                                <button type="submit" name="status" value="maintenance"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border-2 border-gray-300 bg-gray-50 text-gray-700 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors status-btn">
                                    Maintenance
                                </button>
                            </form>
                        </div>

                        <!-- QR Code -->
                        <div class="border-t border-gray-200 pt-6 dark:border-gray-800">
                            <label class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-400">QR Code</label>
                            <div class="flex items-center gap-4">
                                <div id="qrCodeContainer" class="flex h-24 w-24 items-center justify-center rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                    <svg class="size-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3 break-all" id="modalQrUrl"></p>
                                    <x-ui.button id="downloadQrBtn" href="#" variant="secondary" size="sm">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Download QR
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-200 px-6 py-4 dark:border-gray-800">
                    <x-ui.button onclick="closeTableModal()" variant="outline">
                        Tutup
                    </x-ui.button>
                    <x-ui.button id="editTableBtn" href="#" variant="primary">
                        Edit Meja
                    </x-ui.button>
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

            // Highlight current status
            document.querySelectorAll('.status-btn').forEach(btn => {
                btn.classList.remove('ring-2', 'ring-offset-2', 'ring-brand-500');
                if (btn.value === status) {
                    btn.classList.add('ring-2', 'ring-offset-2', 'ring-brand-500');
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
