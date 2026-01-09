<x-app-layout>
    <x-slot name="title">Kasir - Daftar Pembayaran</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Kasir
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Proses pembayaran pesanan customer
            </p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-warning-50 dark:bg-warning-500/10">
                    <svg class="size-6 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $unpaidCount }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum Dibayar</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-success-50 dark:bg-success-500/10">
                    <svg class="size-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $paidTodayCount }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Lunas Hari Ini</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/10">
                    <svg class="size-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-800 dark:text-white/90">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pendapatan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="mb-6 rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="p-4 space-y-4">
            <!-- Search Bar -->
            <form method="GET" action="{{ route('cashier.index') }}" class="relative">
                <input type="hidden" name="payment" value="{{ request('payment', 'unpaid') }}">
                <input type="hidden" name="date" value="{{ request('date', today()->format('Y-m-d')) }}">
                
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="size-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari nomor meja..." 
                        class="w-full pl-12 pr-24 py-3.5 text-gray-900 border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 transition-colors">
                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <span class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white font-medium rounded-lg transition-colors text-sm">
                            Cari
                        </span>
                    </button>
                </div>
                
                @if(request('search'))
                    <div class="mt-2">
                        <a href="{{ route('cashier.index', ['payment' => request('payment', 'unpaid'), 'date' => request('date', today()->format('Y-m-d'))]) }}" 
                           class="inline-flex items-center gap-1 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Hapus pencarian
                        </a>
                    </div>
                @endif
            </form>

            <!-- Filter Buttons -->
            <div class="flex items-center gap-3 overflow-x-auto pb-2">
                <a href="{{ route('cashier.index', array_merge(request()->query(), ['payment' => 'unpaid'])) }}"
                    class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('payment', 'unpaid') === 'unpaid' 
                        ? 'bg-warning-500 text-white' 
                        : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                    <span class="flex items-center gap-2">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Belum Bayar
                    </span>
                </a>
                <a href="{{ route('cashier.index', array_merge(request()->query(), ['payment' => 'paid'])) }}"
                    class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('payment') === 'paid' 
                        ? 'bg-success-500 text-white' 
                        : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                    <span class="flex items-center gap-2">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Sudah Lunas
                    </span>
                </a>
                <a href="{{ route('cashier.index', array_merge(request()->query(), ['payment' => 'all'])) }}"
                    class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('payment') === 'all' 
                        ? 'bg-brand-500 text-white' 
                        : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                    Semua
                </a>

                <div class="flex-1"></div>

                <!-- Date Filter -->
                <form method="GET" class="flex items-center gap-2">
                    <input type="hidden" name="payment" value="{{ request('payment', 'unpaid') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="date"
                        name="date"
                        value="{{ request('date', today()->format('Y-m-d')) }}"
                        onchange="this.form.submit()"
                        class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </form>
            </div>
        </div>
    </div>

    <!-- Orders Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($orders as $order)
            @php
                $isPaid = $order->isPaid();
            @endphp

            <a href="{{ $isPaid ? route('orders.show', $order) : route('payments.create', $order) }}"
                class="block rounded-xl border transition-all hover:shadow-lg overflow-hidden {{ !$isPaid ? 'border-warning-300 dark:border-warning-700 bg-warning-50/50 dark:bg-warning-500/5 hover:border-warning-400' : 'border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] hover:border-brand-300' }}">
                
                {{-- Card Header --}}
                <div class="px-5 pt-5 pb-3">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-white/90">{{ $order->order_number }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                @if($order->table)
                                    <span class="inline-flex items-center gap-1 font-semibold text-brand-600 dark:text-brand-400">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/>
                                        </svg>
                                        Meja {{ $order->table->number }}
                                    </span>
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $order->order_type)) }}
                                @endif
                            </p>
                        </div>
                        
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $isPaid ? 'bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400' : 'bg-warning-100 text-warning-700 dark:bg-warning-500/20 dark:text-warning-400' }}">
                            {{ $isPaid ? 'Lunas' : 'Belum Bayar' }}
                        </span>
                    </div>

                    {{-- Order Status --}}
                    @php
                        $statusConfig = [
                            'confirmed' => ['bg' => 'bg-brand-50 dark:bg-brand-500/15', 'text' => 'text-brand-700 dark:text-brand-400', 'label' => 'Menunggu'],
                            'preparing' => ['bg' => 'bg-purple-50 dark:bg-purple-500/15', 'text' => 'text-purple-700 dark:text-purple-400', 'label' => 'Dimasak'],
                            'ready' => ['bg' => 'bg-success-50 dark:bg-success-500/15', 'text' => 'text-success-700 dark:text-success-400', 'label' => 'Siap'],
                            'completed' => ['bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-700 dark:text-gray-400', 'label' => 'Selesai'],
                        ];
                        $status = $statusConfig[$order->status] ?? $statusConfig['confirmed'];
                    @endphp
                    
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs {{ $status['bg'] }} {{ $status['text'] }}">
                            {{ $status['label'] }}
                        </span>
                    </div>
                </div>

                {{-- Order Info --}}
                <div class="px-5 pb-3">
                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
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
                </div>

                {{-- Footer --}}
                <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between {{ !$isPaid ? 'bg-warning-50/50 dark:bg-warning-500/5' : 'bg-gray-50/50 dark:bg-gray-900/50' }}">
                    <span class="text-xs text-gray-400">{{ $order->user?->name ?? 'System' }}</span>
                    <span class="text-lg font-bold {{ !$isPaid ? 'text-warning-600 dark:text-warning-400' : 'text-brand-600 dark:text-brand-400' }}">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Action Indicator --}}
                @if(!$isPaid)
                    <div class="px-5 py-2.5 bg-warning-100 dark:bg-warning-500/10 border-t border-warning-200 dark:border-warning-500/20">
                        <span class="text-xs font-medium text-warning-700 dark:text-warning-400 flex items-center justify-center gap-2">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                            Klik untuk proses pembayaran
                        </span>
                    </div>
                @endif
            </a>
        @empty
            <div class="col-span-full rounded-xl border border-gray-200 bg-white p-12 text-center dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 mx-auto mb-4">
                    <svg class="size-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                    @if(request('search'))
                        Tidak ditemukan pesanan dengan meja "{{ request('search') }}"
                    @elseif(request('payment', 'unpaid') === 'unpaid')
                        Tidak ada pesanan yang perlu dibayar
                    @else
                        Belum ada transaksi
                    @endif
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    @if(request('search'))
                        Coba cari dengan nomor meja lain
                    @elseif(request('payment', 'unpaid') === 'unpaid')
                        Semua pesanan sudah lunas 🎉
                    @else
                        Belum ada pesanan pada tanggal ini
                    @endif
                </p>
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
