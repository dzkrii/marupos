<x-app-layout>
    <x-slot name="title">Laporan Top Selling</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Laporan Top Selling</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Menu dan kategori terlaris</p>
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
        <form method="GET" action="{{ route('reports.top-selling') }}" class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
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
                    <x-ui.button href="{{ route('reports.top-selling') }}" variant="outline">
                        Reset
                    </x-ui.button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabs -->
    <div class="mb-6" x-data="{ tab: 'items' }">
        <div class="border-b border-gray-200 dark:border-gray-800 print:hidden">
            <nav class="-mb-px flex gap-6">
                <button @click="tab = 'items'" 
                        :class="tab === 'items' ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Top Menu Items
                </button>
                <button @click="tab = 'categories'" 
                        :class="tab === 'categories' ? 'border-brand-500 text-brand-600 dark:text-brand-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Top Categories
                </button>
            </nav>
        </div>

        <!-- Top Items Tab -->
        <div x-show="tab === 'items'" class="mt-6">
            <div class="rounded-xl border border-gray-200 bg-white overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                    <h3 class="font-semibold text-gray-800 dark:text-white/90">Top 20 Menu Items Terlaris</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200 dark:bg-gray-900 dark:border-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Rank</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Nama Menu</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Qty Terjual</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @forelse($topItems as $index => $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            @if($index < 3)
                                                <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-white text-sm
                                                    {{ $index === 0 ? 'bg-yellow-400' : ($index === 1 ? 'bg-gray-400' : 'bg-orange-400') }}">
                                                    {{ $index + 1 }}
                                                </span>
                                            @else
                                                <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-semibold text-gray-600 dark:text-gray-400 text-sm bg-gray-100 dark:bg-gray-800">
                                                    {{ $index + 1 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $item->menu_item_name }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ number_format($item->total_quantity) }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">pcs</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="text-sm font-bold text-gray-800 dark:text-white/90">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada data penjualan menu
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Categories Tab -->
        <div x-show="tab === 'categories'" class="mt-6">
            <div class="rounded-xl border border-gray-200 bg-white overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                    <h3 class="font-semibold text-gray-800 dark:text-white/90">Top Categories Terlaris</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200 dark:bg-gray-900 dark:border-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Rank</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Kategori</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Qty Terjual</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Total Revenue</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Kontribusi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @php
                                $totalCategoryRevenue = $topCategories->sum('total_revenue');
                            @endphp
                            @forelse($topCategories as $index => $category)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            @if($index < 3)
                                                <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-white text-sm
                                                    {{ $index === 0 ? 'bg-yellow-400' : ($index === 1 ? 'bg-gray-400' : 'bg-orange-400') }}">
                                                    {{ $index + 1 }}
                                                </span>
                                            @else
                                                <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-semibold text-gray-600 dark:text-gray-400 text-sm bg-gray-100 dark:bg-gray-800">
                                                    {{ $index + 1 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $category->category_name }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ number_format($category->total_quantity) }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">items</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="text-sm font-bold text-gray-800 dark:text-white/90">Rp {{ number_format($category->total_revenue, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        @php
                                            $contribution = $totalCategoryRevenue > 0 ? ($category->total_revenue / $totalCategoryRevenue) * 100 : 0;
                                        @endphp
                                        <span class="text-sm font-semibold text-brand-600 dark:text-brand-400">{{ number_format($contribution, 1) }}%</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada data penjualan kategori
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
