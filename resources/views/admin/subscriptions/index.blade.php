<x-admin-layout>
    <x-slot name="title">Daftar Langganan</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Daftar Langganan</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola semua transaksi langganan MARUPOS</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="flex gap-2 flex-wrap">
                <select name="status" class="rounded-lg border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-gray-300">
                    <option value="">Semua Status</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                <select name="plan" class="rounded-lg border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-700 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-gray-300">
                    <option value="">Semua Paket</option>
                    @foreach($plans as $plan)
                    <option value="{{ $plan->id }}" {{ request('plan') == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['status', 'plan']))
                <a href="{{ route('admin.subscriptions.index') }}" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        @php
            $statusCounts = $subscriptions->getCollection()->countBy('status');
            $totalAmount = $subscriptions->getCollection()->where('status', 'paid')->sum('amount');
        @endphp
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Transaksi</p>
            <p class="text-2xl font-bold text-gray-800 dark:text-white/90 mt-1">{{ $subscriptions->total() }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Paid</p>
            <p class="text-2xl font-bold text-success-600 dark:text-success-400 mt-1">{{ $statusCounts['paid'] ?? 0 }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Pending</p>
            <p class="text-2xl font-bold text-warning-600 dark:text-warning-400 mt-1">{{ $statusCounts['pending'] ?? 0 }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
            <p class="text-sm text-gray-500 dark:text-gray-400">Pendapatan (Page)</p>
            <p class="text-2xl font-bold text-gray-800 dark:text-white/90 mt-1">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Subscriptions Table -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Order ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Perusahaan</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Paket</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Jumlah</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Pembayaran</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($subscriptions as $subscription)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-mono text-xs text-gray-600 dark:text-gray-400">{{ $subscription->order_id }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-brand-100 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400 font-semibold text-sm">
                                    {{ strtoupper(substr($subscription->company?->name ?? $subscription->temp_restaurant_name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-white/90">
                                        {{ $subscription->company?->name ?? $subscription->temp_restaurant_name ?? 'Pending Registration' }}
                                    </p>
                                    @if(!$subscription->company && $subscription->temp_email)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $subscription->temp_email }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-600 dark:text-gray-300">{{ $subscription->plan?->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ ucfirst($subscription->billing_cycle) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800 dark:text-white/90">{{ $subscription->formatted_amount }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($subscription->status === 'paid')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400">
                                Paid
                            </span>
                            @elseif($subscription->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400">
                                Pending
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-400">
                                {{ ucfirst($subscription->status) }}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ $subscription->payment_type ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $subscription->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $subscription->created_at->format('H:i') }}</p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <svg class="mx-auto size-12 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <p class="text-lg font-medium mb-1">Tidak ada transaksi</p>
                            <p>Belum ada transaksi langganan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscriptions->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
            {{ $subscriptions->links() }}
        </div>
        @endif
    </div>

</x-admin-layout>
