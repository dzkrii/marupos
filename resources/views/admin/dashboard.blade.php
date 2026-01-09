<x-admin-layout>
    <x-slot name="title">Dashboard Admin</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Dashboard Admin</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Ringkasan performa platform RestoZen</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400">
                <span class="mr-1.5 h-2 w-2 rounded-full bg-success-500 animate-pulse"></span>
                Platform Aktif
            </span>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 md:gap-6 mb-6">
        <!-- Total Revenue -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-center w-12 h-12 bg-success-50 rounded-xl dark:bg-success-500/10">
                <svg class="size-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">Total Pendapatan</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">
                    Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                </h4>
            </div>
            <div class="flex items-center mt-3">
                @if($stats['revenue_growth'] >= 0)
                <span class="flex items-center gap-1 text-sm font-medium text-success-600 dark:text-success-400">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    {{ number_format($stats['revenue_growth'], 1) }}%
                </span>
                @else
                <span class="flex items-center gap-1 text-sm font-medium text-error-600 dark:text-error-400">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                    {{ number_format(abs($stats['revenue_growth']), 1) }}%
                </span>
                @endif
                <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">vs bulan lalu</span>
            </div>
        </div>

        <!-- Total Companies -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-center w-12 h-12 bg-brand-50 rounded-xl dark:bg-brand-500/10">
                <svg class="size-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">Total Perusahaan</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">
                    {{ number_format($stats['total_companies']) }}
                </h4>
            </div>
            <div class="flex items-center mt-3">
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $stats['active_companies'] }} aktif
                </span>
            </div>
        </div>

        <!-- Active Subscriptions -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-center w-12 h-12 bg-warning-50 rounded-xl dark:bg-warning-500/10">
                <svg class="size-6 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">Langganan Aktif</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">
                    {{ number_format($stats['active_subscriptions']) }}
                </h4>
            </div>
            <div class="flex items-center gap-3 mt-3">
                <span class="text-xs text-warning-600 dark:text-warning-400">
                    {{ $stats['pending_subscriptions'] }} pending
                </span>
                <span class="text-xs text-error-600 dark:text-error-400">
                    {{ $stats['expired_subscriptions'] }} expired
                </span>
            </div>
        </div>

        <!-- Total Outlets -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-center w-12 h-12 bg-error-50 rounded-xl dark:bg-error-500/10">
                <svg class="size-6 text-error-600 dark:text-error-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">Total Outlet</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">
                    {{ number_format($stats['total_outlets']) }}
                </h4>
            </div>
            <div class="flex items-center mt-3">
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ number_format($stats['total_orders']) }} pesanan
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <!-- Left Column - Charts -->
        <div class="col-span-12 xl:col-span-8 space-y-6">
            <!-- Revenue Chart -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Pendapatan Langganan</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">12 bulan terakhir</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-gray-800 dark:text-white/90">
                            Rp {{ number_format($stats['this_month_revenue'], 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Bulan ini</p>
                    </div>
                </div>
                <div id="revenueChart" class="h-[300px]"></div>
            </div>

            <!-- Subscription Plans Stats -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Statistik Paket Langganan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($planStats as $plan)
                    <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-700 {{ $plan->is_popular ? 'bg-brand-50/50 dark:bg-brand-500/5 border-brand-200 dark:border-brand-500/20' : 'bg-gray-50 dark:bg-gray-800/50' }}">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-800 dark:text-white/90">{{ $plan->name }}</h4>
                            @if($plan->is_popular)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-brand-100 text-brand-700 dark:bg-brand-500/20 dark:text-brand-400">
                                Popular
                            </span>
                            @endif
                        </div>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $plan->active_count }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">pelanggan aktif</p>
                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {{ $plan->formatted_monthly_price }}/bln
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-span-12 xl:col-span-4 space-y-6">
            <!-- Revenue This Month -->
            <div class="rounded-2xl border border-gray-200 bg-gradient-to-br from-success-500 to-success-600 p-5 dark:border-gray-800 md:p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-white/20 rounded-xl">
                        <svg class="size-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-white/80">Pendapatan Bulan Ini</p>
                        <h3 class="text-2xl font-bold text-white">Rp {{ number_format($stats['this_month_revenue'], 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/10 rounded-lg p-3">
                        <p class="text-xs text-white/70">Bulan Lalu</p>
                        <p class="text-lg font-semibold text-white">Rp {{ number_format($stats['last_month_revenue'], 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-3">
                        <p class="text-xs text-white/70">Growth</p>
                        <p class="text-lg font-semibold text-white">
                            @if($stats['revenue_growth'] >= 0)+@endif{{ number_format($stats['revenue_growth'], 1) }}%
                        </p>
                    </div>
                </div>
            </div>

            <!-- Expiring Soon -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Akan Kedaluwarsa</h3>
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400">
                        {{ count($expiringSoon) }} perusahaan
                    </span>
                </div>
                @if($expiringSoon->count() > 0)
                <div class="space-y-3">
                    @foreach($expiringSoon as $sub)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-white/90">{{ $sub->company?->name ?? 'Unknown' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $sub->plan?->name ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-warning-600 dark:text-warning-400">
                                {{ $sub->expires_at?->diffForHumans() }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $sub->expires_at?->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">
                    Tidak ada langganan yang akan kedaluwarsa dalam 7 hari ke depan.
                </p>
                @endif
            </div>

            <!-- Recent Companies -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Perusahaan Baru</h3>
                    <a href="{{ route('admin.companies.index') }}" class="text-sm text-brand-500 hover:text-brand-600 dark:text-brand-400">
                        Lihat Semua
                    </a>
                </div>
                @if($recentCompanies->count() > 0)
                <div class="space-y-3">
                    @foreach($recentCompanies as $company)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-brand-100 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400 font-semibold">
                            {{ strtoupper(substr($company->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 dark:text-white/90 truncate">{{ $company->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $company->outlets->count() }} outlet • {{ $company->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @if($company->is_active)
                        <span class="flex-shrink-0 h-2 w-2 rounded-full bg-success-500"></span>
                        @else
                        <span class="flex-shrink-0 h-2 w-2 rounded-full bg-gray-400"></span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">
                    Belum ada perusahaan terdaftar.
                </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Subscriptions Table -->
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="p-5 md:p-6 border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Transaksi Langganan Terbaru</h3>
                <a href="{{ route('admin.subscriptions.index') }}" class="text-sm text-brand-500 hover:text-brand-600 dark:text-brand-400">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Perusahaan</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Paket</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Jumlah</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($recentSubscriptions as $subscription)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-brand-100 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400 font-semibold text-sm">
                                    {{ strtoupper(substr($subscription->company?->name ?? $subscription->temp_restaurant_name ?? 'U', 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800 dark:text-white/90">
                                    {{ $subscription->company?->name ?? $subscription->temp_restaurant_name ?? 'Pending Registration' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-gray-600 dark:text-gray-300">{{ $subscription->plan?->name ?? 'N/A' }}</span>
                            <span class="text-xs text-gray-400 dark:text-gray-500 ml-1">({{ $subscription->billing_cycle }})</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-medium text-gray-800 dark:text-white/90">{{ $subscription->formatted_amount }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
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
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                            {{ $subscription->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            Belum ada transaksi langganan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Revenue Chart
    const revenueOptions = {
        series: [{
            name: 'Pendapatan',
            data: @json($stats['monthly_revenue'])
        }],
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: false },
            zoom: { enabled: false },
            fontFamily: 'Inter, sans-serif',
        },
        colors: ['#12b76a'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.1,
                stops: [0, 90, 100]
            }
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: @json($stats['months']),
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        yaxis: {
            labels: {
                formatter: function(val) {
                    if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + ' Jt';
                    if (val >= 1000) return 'Rp ' + (val / 1000).toFixed(0) + ' Rb';
                    return 'Rp ' + val;
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                }
            }
        },
        grid: {
            borderColor: '#e5e7eb',
            strokeDashArray: 4,
        },
    };
    
    const revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
    revenueChart.render();
    
    // Handle dark mode for chart
    if (document.documentElement.classList.contains('dark')) {
        revenueChart.updateOptions({
            grid: { borderColor: '#374151' },
            xaxis: { labels: { style: { colors: '#9ca3af' } } },
            yaxis: { labels: { style: { colors: '#9ca3af' } } },
        });
    }
</script>
@endpush
