<x-app-layout>
    <x-slot name="title">Daftar Pesanan</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Daftar Pesanan</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola pesanan masuk dan riwayat transaksi</p>
        </div>
        <x-ui.button href="{{ route('orders.create') }}" variant="primary">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Pesanan Baru
        </x-ui.button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/10">
                    <svg class="size-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $todayOrders }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pesanan Hari Ini</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-success-50 dark:bg-success-500/10">
                    <svg class="size-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-800 dark:text-white/90">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pendapatan Hari Ini</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-warning-50 dark:bg-warning-500/10">
                    <svg class="size-6 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $pendingCount }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pesanan Aktif</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                    <svg class="size-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-bold text-gray-800 dark:text-white/90">{{ now()->format('d M Y') }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('H:i') }} WIB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-6 rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-3 p-4 overflow-x-auto">
            <a href="{{ route('orders.index', ['status' => 'all', 'date' => request('date', today()->format('Y-m-d'))]) }}"
                class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('status') || request('status') === 'all' 
                    ? 'bg-brand-500 text-white' 
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                Semua
            </a>
            <a href="{{ route('orders.index', ['status' => 'pending', 'date' => request('date', today()->format('Y-m-d'))]) }}"
                class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'pending' 
                    ? 'bg-warning-500 text-white' 
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                Pending
            </a>
            <a href="{{ route('orders.index', ['status' => 'confirmed', 'date' => request('date', today()->format('Y-m-d'))]) }}"
                class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'confirmed' 
                    ? 'bg-brand-500 text-white' 
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                Dikonfirmasi
            </a>
            <a href="{{ route('orders.index', ['status' => 'preparing', 'date' => request('date', today()->format('Y-m-d'))]) }}"
                class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'preparing' 
                    ? 'bg-purple-500 text-white' 
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                Dimasak
            </a>
            <a href="{{ route('orders.index', ['status' => 'ready', 'date' => request('date', today()->format('Y-m-d'))]) }}"
                class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'ready' 
                    ? 'bg-success-500 text-white' 
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                Siap
            </a>
            <a href="{{ route('orders.index', ['status' => 'completed', 'date' => request('date', today()->format('Y-m-d'))]) }}"
                class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'completed' 
                    ? 'bg-success-600 text-white' 
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                Selesai
            </a>

            <div class="flex-1"></div>

            <form method="GET" class="flex items-center gap-2">
                <input type="hidden" name="status" value="{{ request('status', 'all') }}">
                <input type="date"
                    name="date"
                    value="{{ request('date', today()->format('Y-m-d')) }}"
                    onchange="this.form.submit()"
                    class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
            </form>
        </div>
    </div>

    <!-- Orders Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($orders as $order)
            @php
                $statusConfig = [
                    'pending' => ['bg' => 'bg-warning-50 dark:bg-warning-500/15', 'text' => 'text-warning-700 dark:text-warning-400', 'label' => 'Pending'],
                    'confirmed' => ['bg' => 'bg-brand-50 dark:bg-brand-500/15', 'text' => 'text-brand-700 dark:text-brand-400', 'label' => 'Dikonfirmasi'],
                    'preparing' => ['bg' => 'bg-purple-50 dark:bg-purple-500/15', 'text' => 'text-purple-700 dark:text-purple-400', 'label' => 'Dimasak'],
                    'ready' => ['bg' => 'bg-success-50 dark:bg-success-500/15', 'text' => 'text-success-700 dark:text-success-400', 'label' => 'Siap'],
                    'served' => ['bg' => 'bg-brand-50 dark:bg-brand-500/15', 'text' => 'text-brand-700 dark:text-brand-400', 'label' => 'Disajikan'],
                    'completed' => ['bg' => 'bg-success-50 dark:bg-success-500/15', 'text' => 'text-success-700 dark:text-success-400', 'label' => 'Selesai'],
                    'cancelled' => ['bg' => 'bg-error-50 dark:bg-error-500/15', 'text' => 'text-error-700 dark:text-error-400', 'label' => 'Dibatalkan'],
                ];
                $status = $statusConfig[$order->status] ?? $statusConfig['pending'];
            @endphp

            <a href="{{ route('orders.show', $order) }}"
                class="block rounded-xl border border-gray-200 bg-white transition-all hover:shadow-lg hover:border-brand-200 dark:border-gray-800 dark:bg-white/[0.03] dark:hover:border-brand-800 overflow-hidden">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-white/90">{{ $order->order_number }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                @if($order->table)
                                    Meja {{ $order->table->number }}
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $order->order_type)) }}
                                @endif
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $status['bg'] }} {{ $status['text'] }}">
                            {{ $status['label'] }}
                        </span>
                    </div>

                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-3">
                        <span class="flex items-center gap-1">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $order->created_at->format('H:i') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            {{ $order->items->count() }} item
                        </span>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-800">
                        <span class="text-xs text-gray-400">{{ $order->user?->name ?? 'System' }}</span>
                        <span class="font-bold text-brand-600 dark:text-brand-400">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full rounded-xl border border-gray-200 bg-white p-12 text-center dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 mx-auto mb-4">
                    <svg class="size-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">Belum ada pesanan</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Buat pesanan baru untuk memulai</p>
                <x-ui.button href="{{ route('orders.create') }}" variant="primary" class="mt-4">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Pesanan
                </x-ui.button>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</x-app-layout>
