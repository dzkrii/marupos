<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Dashboard</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Ringkasan performa restoran Anda</p>
        </div>

        <div class="flex items-center gap-3 rounded-xl border border-gray-200 bg-white p-2 pl-4 shadow-sm dark:border-gray-800 dark:bg-gray-800/50">
            <div class="text-right">
                <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-400 dark:text-gray-500">Kode Akses QR</p>
                <div class="flex items-center justify-end gap-2">
                    <p class="text-xl font-bold font-mono text-brand-600 dark:text-brand-400 tracking-widest">{{ $stats['qr_access_code'] ?? '------' }}</p>
                </div>
            </div>
            <div class="h-8 w-px bg-gray-200 dark:bg-gray-700"></div>
            <form action="{{ route('outlets.regenerate-access-code') }}" method="POST">
                @csrf
                <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-50 text-gray-500 hover:bg-brand-50 hover:text-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500/20 active:bg-brand-100 transition-all dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-brand-500/20 dark:hover:text-brand-400" title="Ubah Kode">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-6">
            <!-- Metrics -->
            <x-dashboard.metrics :stats="$stats" />

            <!-- Monthly Sales Chart -->
            <x-dashboard.monthly-sale :stats="$stats" />
        </div>
    </div>
</x-app-layout>
