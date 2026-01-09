<x-app-layout>
    <x-slot name="title">Siap Saji</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Siap Saji
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Pesanan yang siap diantarkan ke customer
            </p>
        </div>
        <div class="flex items-center gap-2">
            <x-ui.button href="{{ route('orders.create') }}" variant="primary">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="hidden sm:inline">Pesanan Baru</span>
            </x-ui.button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-success-50 dark:bg-success-500/10">
                    <svg class="size-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $readyCount }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Siap Diantar</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/10">
                    <svg class="size-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $completedTodayCount }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Diantar Hari Ini</p>
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
            <a href="{{ route('orders.ready', ['status' => 'ready']) }}"
                class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status', 'ready') === 'ready' 
                    ? 'bg-success-500 text-white' 
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                <span class="flex items-center gap-2">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Siap Diantar
                </span>
            </a>
            <a href="{{ route('orders.ready', ['status' => 'completed']) }}"
                class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'completed' 
                    ? 'bg-brand-500 text-white' 
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                <span class="flex items-center gap-2">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Sudah Diantar
                </span>
            </a>
            <a href="{{ route('orders.ready', ['status' => 'all']) }}"
                class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'all' 
                    ? 'bg-gray-600 text-white' 
                    : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                Semua
            </a>
        </div>
    </div>

    <!-- Orders Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($orders as $order)
            @php
                $isReady = $order->status === 'ready';
                $isCompleted = $order->status === 'completed';
                $isPaid = $order->isPaid();
            @endphp

            <div class="rounded-xl border transition-all overflow-hidden {{ $isReady ? 'border-success-300 bg-success-50/50 dark:border-success-700 dark:bg-success-500/5' : 'border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]' }}">
                
                {{-- Card Header --}}
                <div class="px-5 pt-5 pb-3">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-white/90">{{ $order->order_number }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                @if($order->table)
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/>
                                        </svg>
                                        Meja {{ $order->table->number }}
                                    </span>
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $order->order_type)) }}
                                @endif
                            </p>
                        </div>
                        
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $isReady ? 'bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400' }}">
                            {{ $isReady ? 'Siap Antar' : 'Sudah Diantar' }}
                        </span>
                    </div>

                    {{-- Payment Status --}}
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs {{ $isPaid ? 'bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400' : 'bg-warning-50 text-warning-700 dark:bg-warning-500/10 dark:text-warning-400' }}">
                            <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($isPaid)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 10v1"/>
                                @endif
                            </svg>
                            {{ $isPaid ? 'Lunas' : 'Belum Bayar' }}
                        </span>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="px-5 pb-3">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            {{ $order->items->count() }} item pesanan
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $order->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between bg-gray-50/50 dark:bg-gray-900/50">
                    <span class="text-xs text-gray-400">{{ $order->user?->name ?? 'System' }}</span>
                    <span class="font-bold text-brand-600 dark:text-brand-400">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Action Button --}}
                @if($isReady)
                    <form action="{{ route('orders.update-status', $order) }}" method="POST" class="px-5 py-3 bg-success-50 dark:bg-success-500/10 border-t border-success-200 dark:border-success-500/20">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="w-full py-2 px-4 bg-success-500 hover:bg-success-600 text-white font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Sudah Diantar
                        </button>
                    </form>
                @endif

                {{-- View Details --}}
                <div class="px-5 pb-3">
                    <a href="{{ route('orders.show', $order) }}" class="block text-center py-2 text-sm text-brand-600 dark:text-brand-400 hover:text-brand-700 dark:hover:text-brand-300 font-medium transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-xl border border-gray-200 bg-white p-12 text-center dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 mx-auto mb-4">
                    <svg class="size-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                    @if(request('status', 'ready') === 'ready')
                        Tidak ada pesanan yang siap diantar
                    @else
                        Belum ada pesanan yang telah diantar
                    @endif
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    @if(request('status', 'ready') === 'ready')
                        Semua pesanan masih dalam proses dapur
                    @else
                        Antar pesanan yang sudah siap ke customer
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
