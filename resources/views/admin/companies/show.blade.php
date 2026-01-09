<x-admin-layout>
    <x-slot name="title">Detail Perusahaan</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.companies.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $company->name }}</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Detail informasi perusahaan</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            @if($company->is_active)
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400">
                <span class="h-2 w-2 rounded-full bg-success-500"></span>
                Aktif
            </span>
            @else
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                Tidak Aktif
            </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Company Info Card -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Informasi Perusahaan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nama</p>
                        <p class="mt-1 font-medium text-gray-800 dark:text-white/90">{{ $company->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Slug</p>
                        <p class="mt-1 font-medium text-gray-800 dark:text-white/90">{{ $company->slug }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                        <p class="mt-1 font-medium text-gray-800 dark:text-white/90">{{ $company->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Telepon</p>
                        <p class="mt-1 font-medium text-gray-800 dark:text-white/90">{{ $company->phone ?? '-' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Alamat</p>
                        <p class="mt-1 font-medium text-gray-800 dark:text-white/90">{{ $company->address ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Terdaftar</p>
                        <p class="mt-1 font-medium text-gray-800 dark:text-white/90">{{ $company->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Outlets -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Outlet</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-50 text-brand-700 dark:bg-brand-500/15 dark:text-brand-400">
                        {{ $company->outlets->count() }} outlet
                    </span>
                </div>
                @if($company->outlets->count() > 0)
                <div class="space-y-3">
                    @foreach($company->outlets as $outlet)
                    <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-white/90">{{ $outlet->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $outlet->address ?? '-' }}</p>
                        </div>
                        @if($outlet->is_active)
                        <span class="h-2.5 w-2.5 rounded-full bg-success-500"></span>
                        @else
                        <span class="h-2.5 w-2.5 rounded-full bg-gray-400"></span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada outlet</p>
                @endif
            </div>

            <!-- Subscription History -->
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="p-6 border-b border-gray-200 dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Riwayat Langganan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Paket</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @forelse($subscriptions as $subscription)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800 dark:text-white/90">{{ $subscription->plan?->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($subscription->billing_cycle) }}</p>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800 dark:text-white/90">
                                    {{ $subscription->formatted_amount }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($subscription->status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400">Paid</span>
                                    @elseif($subscription->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400">Pending</span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-400">{{ ucfirst($subscription->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $subscription->created_at->format('d M Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada riwayat langganan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div class="space-y-6">
            <!-- Stats Card -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Statistik</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                        <span class="text-gray-600 dark:text-gray-300">Total Pesanan</span>
                        <span class="font-semibold text-gray-800 dark:text-white/90">{{ number_format($totalOrders) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                        <span class="text-gray-600 dark:text-gray-300">Total Pendapatan</span>
                        <span class="font-semibold text-gray-800 dark:text-white/90">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                        <span class="text-gray-600 dark:text-gray-300">Total Outlet</span>
                        <span class="font-semibold text-gray-800 dark:text-white/90">{{ $company->outlets->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                        <span class="text-gray-600 dark:text-gray-300">Total User</span>
                        <span class="font-semibold text-gray-800 dark:text-white/90">{{ $company->users->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Users Card -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Pengguna</h3>
                @if($company->users->count() > 0)
                <div class="space-y-3">
                    @foreach($company->users->take(5) as $user)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 font-semibold text-sm dark:bg-brand-500/20 dark:text-brand-400">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 dark:text-white/90 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                    @endforeach
                    @if($company->users->count() > 5)
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                        +{{ $company->users->count() - 5 }} lainnya
                    </p>
                    @endif
                </div>
                @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada pengguna</p>
                @endif
            </div>
        </div>
    </div>

</x-admin-layout>
