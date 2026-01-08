<x-app-layout>
    <x-slot name="title">Laporan Metode Pembayaran</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Laporan Metode Pembayaran</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Breakdown revenue per metode pembayaran</p>
        </div>
        <x-ui.button onclick="window.print()" variant="primary" class="print:hidden">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print / Save PDF
        </x-ui.button>
    </div>

    <!-- Date Filter -->
    <div class="mb-6 print:hidden">
        <form method="GET" action="{{ route('reports.payment-methods') }}" class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" 
                        class="shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" 
                        class="shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>
                <div class="flex items-end gap-2 col-span-2">
                    <x-ui.button type="submit" variant="primary">
                        Terapkan
                    </x-ui.button>
                    <x-ui.button href="{{ route('reports.payment-methods') }}" variant="outline">
                        Reset
                    </x-ui.button>
                </div>
            </div>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="rounded-xl bg-gradient-to-br from-success-500 to-success-600 p-6 text-white">
            <p class="text-success-100 text-sm mb-1">Total Revenue</p>
            <p class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-brand-500 to-brand-600 p-6 text-white">
            <p class="text-brand-100 text-sm mb-1">Total Transaksi</p>
            <p class="text-3xl font-bold">{{ number_format($totalTransactions) }}</p>
        </div>
    </div>

    <!-- Payment Methods Breakdown -->
    <div class="rounded-xl border border-gray-200 bg-white overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
            <h3 class="font-semibold text-gray-800 dark:text-white/90">Breakdown Per Metode Pembayaran</h3>
        </div>
        <div class="p-6">
            @if($paymentData->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Table -->
                    <div class="space-y-3">
                        @php
                            $paymentIcons = [
                                'cash' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>',
                                'card' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>',
                                'qris' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>',
                                'transfer' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>',
                                'ewallet' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>',
                            ];
                        @endphp

                        @foreach($paymentData as $payment)
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 bg-brand-100 dark:bg-brand-500/20 rounded-lg flex items-center justify-center">
                                        <svg class="size-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $paymentIcons[$payment->payment_method] ?? $paymentIcons['cash'] !!}
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800 dark:text-white/90 capitalize">{{ str_replace('_', ' ', $payment->payment_method) }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($payment->transaction_count) }} transaksi</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-800 dark:text-white/90">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $totalRevenue > 0 ? number_format(($payment->total_amount / $totalRevenue) * 100, 1) : 0 }}%
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Visual Chart (Progress Bars) -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-800 dark:text-white/90 mb-4">Visualisasi Persentase</h4>
                        @foreach($paymentData as $payment)
                            @php
                                $percentage = $totalRevenue > 0 ? ($payment->total_amount / $totalRevenue) * 100 : 0;
                                $colors = [
                                    'cash' => 'bg-success-500',
                                    'card' => 'bg-brand-500',
                                    'qris' => 'bg-purple-500',
                                    'transfer' => 'bg-warning-500',
                                    'ewallet' => 'bg-pink-500',
                                ];
                                $color = $colors[$payment->payment_method] ?? 'bg-gray-500';
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 capitalize">{{ str_replace('_', ' ', $payment->payment_method) }}</span>
                                    <span class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ number_format($percentage, 1) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-800 rounded-full h-3 overflow-hidden">
                                    <div class="{{ $color }} h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="size-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"/>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada data pembayaran untuk periode ini</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
