@props(['stats'])

@php
    $formatMoneyShort = function($amount) {
        if ($amount >= 1000000000) return number_format($amount / 1000000000, 1) . ' M';
        if ($amount >= 1000000) return number_format($amount / 1000000, 1) . ' Jt';
        if ($amount >= 1000) return number_format($amount / 1000, 1) . ' Rb';
        return number_format($amount);
    };
@endphp

<div class="rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="shadow-default rounded-2xl bg-white px-5 pb-11 pt-5 dark:bg-gray-900 sm:px-6 sm:pt-6">
        <div class="flex justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Target Bulanan
                </h3>
                <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                    Target yang ditentukan per bulan
                </p>
            </div>
        </div>
        <div class="relative max-h-[195px] h-[195px] flex items-center justify-center bg-gray-50 dark:bg-gray-800 rounded mt-4">
             <p class="text-gray-400 text-sm">Target Chart Progress</p>
             <!-- Chart would go here -->
            <div id="chartTwo" class="hidden h-full"></div>
            @if($stats['monthly_target'] > 0)
            <div class="absolute inset-0 flex items-center justify-center flex-col">
                <span class="text-3xl font-bold text-brand-500">{{ round(($stats['this_month_revenue'] / $stats['monthly_target']) * 100) }}%</span>
                <span class="text-sm text-gray-500">Tercapai</span>
            </div>
            @endif
        </div>
        <p class="mx-auto mt-1.5 w-full max-w-[380px] text-center text-sm text-gray-500 sm:text-base">
            Pendapatan hari ini Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}.
        </p>
    </div>

    <div class="flex items-center justify-center gap-5 px-6 py-3.5 sm:gap-8 sm:py-5">
        <div>
            <p class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Target
            </p>
            <p class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                {{ $formatMoneyShort($stats['monthly_target']) }}
            </p>
        </div>

        <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

        <div>
            <p class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Pendapatan
            </p>
            <p class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                {{ $formatMoneyShort($stats['this_month_revenue']) }}
            </p>
        </div>

        <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

        <div>
            <p class="mb-1 text-center text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Hari Ini
            </p>
            <p class="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
                {{ $formatMoneyShort($stats['today_revenue']) }}
            </p>
        </div>
    </div>
</div>
