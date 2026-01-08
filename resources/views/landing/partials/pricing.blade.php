{{-- Pricing Section --}}
<section id="pricing" class="py-24 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto">
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up" data-aos-duration="600">
            <span class="inline-block px-4 py-1.5 rounded-full bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 text-theme-sm font-semibold mb-4">
                HARGA
            </span>
            <h2 class="text-title-md font-bold text-gray-900 dark:text-white mb-4">
                Pilih Paket yang Sesuai Kebutuhan
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-lg">
                Mulai gratis 14 hari, tanpa kartu kredit. Upgrade kapan saja sesuai kebutuhan bisnis Anda.
            </p>
        </div>

        {{-- Pricing Toggle (Monthly/Yearly) --}}
        <div class="flex justify-center mb-12" data-aos="fade-up" data-aos-duration="600">
            <div x-data="{ yearly: false }" class="inline-flex items-center gap-4 p-1.5 bg-gray-100 dark:bg-gray-800 rounded-xl">
                <button @click="yearly = false" :class="!yearly ? 'bg-white dark:bg-gray-700 shadow-theme-sm' : 'text-gray-500'" class="px-5 py-2.5 rounded-lg font-medium transition-all">
                    Bulanan
                </button>
                <button @click="yearly = true" :class="yearly ? 'bg-white dark:bg-gray-700 shadow-theme-sm' : 'text-gray-500'" class="px-5 py-2.5 rounded-lg font-medium transition-all flex items-center gap-2">
                    Tahunan
                    <span class="px-2 py-0.5 rounded-full bg-success-100 dark:bg-success-500/20 text-success-600 dark:text-success-400 text-theme-xs font-semibold">-20%</span>
                </button>
            </div>
        </div>

        {{-- Pricing Cards --}}
        <div class="grid md:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto">
            {{-- Starter Plan --}}
            <div class="bg-white dark:bg-gray-800 p-6 lg:p-8 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-theme-lg transition-all duration-300" data-aos="fade-up" data-aos-duration="600">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Starter</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-theme-sm">Untuk restoran kecil yang baru mulai</p>
                </div>
                <div class="mb-6">
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-bold text-gray-900 dark:text-white">Rp 299K</span>
                        <span class="text-gray-500 dark:text-gray-400">/bulan</span>
                    </div>
                    <p class="text-theme-xs text-gray-400 mt-1">Atau Rp 2.8jt/tahun (hemat 20%)</p>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">1 Outlet</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">Maksimal 20 Meja</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">POS & Menu Management</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">QR Order</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">Laporan Dasar</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">Email Support</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="block w-full text-center py-3.5 px-6 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:border-brand-500 hover:text-brand-500 dark:hover:border-brand-400 dark:hover:text-brand-400 transition-all">
                    Mulai Gratis
                </a>
            </div>

            {{-- Professional Plan (Popular) --}}
            <div class="relative bg-gray-900 dark:bg-gray-800 p-6 lg:p-8 rounded-2xl border-2 border-brand-500 shadow-theme-xl" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                    <span class="inline-block px-4 py-1.5 rounded-full bg-gradient-to-r from-brand-500 to-brand-600 text-white text-theme-sm font-semibold shadow-lg">
                        Paling Populer
                    </span>
                </div>
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-white mb-2">Professional</h3>
                    <p class="text-gray-400 text-theme-sm">Untuk restoran yang berkembang</p>
                </div>
                <div class="mb-6">
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-bold text-white">Rp 599K</span>
                        <span class="text-gray-400">/bulan</span>
                    </div>
                    <p class="text-theme-xs text-gray-500 mt-1">Atau Rp 5.7jt/tahun (hemat 20%)</p>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">Hingga 3 Outlet</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">Meja Unlimited</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">Semua Fitur Starter</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">Kitchen Display System</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">Laporan Lengkap + Export PDF</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">Manajemen Karyawan</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300">Priority Support</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="block w-full text-center py-3.5 px-6 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-brand-500/25">
                    Mulai Gratis
                </a>
            </div>

            {{-- Enterprise Plan --}}
            <div class="bg-white dark:bg-gray-800 p-6 lg:p-8 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-theme-lg transition-all duration-300" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Enterprise</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-theme-sm">Untuk jaringan restoran besar</p>
                </div>
                <div class="mb-6">
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-bold text-gray-900 dark:text-white">Custom</span>
                    </div>
                    <p class="text-theme-xs text-gray-400 mt-1">Hubungi kami untuk penawaran</p>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">Outlet Unlimited</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">Semua Fitur Professional</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">Dedicated Account Manager</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">Custom Integration & API</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">SLA Guarantee 99.9%</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-success-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-600 dark:text-gray-400">On-site Training</span>
                    </li>
                </ul>
                <a href="#contact" class="block w-full text-center py-3.5 px-6 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:border-brand-500 hover:text-brand-500 dark:hover:border-brand-400 dark:hover:text-brand-400 transition-all">
                    Hubungi Sales
                </a>
            </div>
        </div>

        {{-- Money Back Guarantee --}}
        <div class="mt-12 text-center" data-aos="fade-up" data-aos-duration="600">
            <div class="inline-flex items-center gap-3 px-6 py-3 bg-success-50 dark:bg-success-500/10 rounded-full">
                <svg class="w-6 h-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span class="text-success-700 dark:text-success-400 font-medium">Garansi 30 hari uang kembali tanpa pertanyaan</span>
            </div>
        </div>
    </div>
</section>
