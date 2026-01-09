{{-- Hero Section --}}
<section class="relative overflow-hidden bg-gradient-to-b from-gray-25 to-white dark:from-gray-900 dark:to-gray-950">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2260%22%20height%3D%2260%22%3E%3Cpath%20d%3D%22M0%200h60v60H0z%22%20fill%3D%22none%22%2F%3E%3Cpath%20d%3D%22M60%200v60M0%200h60%22%20stroke%3D%22%23e4e7ec%22%20stroke-width%3D%221%22%2F%3E%3C%2Fsvg%3E')] dark:opacity-10"></div>
    
    {{-- Gradient Orbs --}}
    <div class="absolute top-20 left-10 w-72 h-72 bg-brand-400/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-success-400/20 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-24">
        <div class="text-center">
            {{-- Badge --}}
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 border border-brand-200 dark:border-brand-800 rounded-full px-1 pr-5 py-1 text-theme-sm font-medium text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/10 hover:bg-brand-100 dark:hover:bg-brand-500/20 transition shadow-theme-xs" data-aos="fade-up" data-aos-duration="600">
                <span class="bg-gradient-to-r from-brand-500 to-brand-600 text-white text-theme-xs px-3 py-1 rounded-full font-semibold shadow-sm">
                    BARU
                </span>
                <span class="flex items-center gap-1.5">
                    Coba gratis 14 hari tanpa kartu kredit
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            </a>

            {{-- Headline --}}
            <h1 class="mt-8 text-4xl sm:text-5xl lg:text-title-lg font-bold text-gray-900 dark:text-white leading-tight" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                Kelola Bisnis Anda dengan <br class="hidden sm:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-500 to-brand-700">Lebih Mudah</span> dan Efisien
            </h1>

            {{-- Subtitle --}}
            <p class="mt-6 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                MARUPOS membantu Anda mengelola pesanan, menu, meja, dapur, dan laporan keuangan dalam satu platform terintegrasi yang modern dan mudah digunakan.
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-10" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                <a href="{{ route('register') }}" class="group flex items-center gap-2 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white rounded-xl px-8 py-4 font-semibold transition-all shadow-lg shadow-brand-500/25 hover:shadow-xl hover:shadow-brand-500/30 hover:-translate-y-0.5">
                    Mulai Gratis Sekarang
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="#features" class="group flex items-center gap-2 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-gray-700 dark:text-gray-300 rounded-xl px-8 py-4 font-semibold shadow-theme-xs">
                    <svg class="w-5 h-5 text-brand-500" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    Lihat Demo
                </a>
            </div>

            {{-- Trusted By --}}
            <div class="mt-16" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                <p class="text-theme-sm text-gray-500 dark:text-gray-500 uppercase tracking-wider font-medium mb-6">Dipercaya oleh 500+ usaha di Indonesia</p>
                <div class="flex flex-wrap items-center justify-center gap-x-12 gap-y-6 grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                    <div class="text-2xl font-bold text-gray-400">WARUNG<span class="text-brand-500">KU</span></div>
                    <div class="text-2xl font-bold text-gray-400">RESTO<span class="text-success-500">ID</span></div>
                    <div class="text-2xl font-bold text-gray-400">MAKAN<span class="text-orange-500">YUK</span></div>
                    <div class="text-2xl font-bold text-gray-400">CAFE<span class="text-brand-500">+</span></div>
                </div>
            </div>
        </div>

        {{-- Dashboard Preview --}}
        <div class="mt-20 relative" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
            {{-- Glow Effect Behind --}}
            <div class="absolute -inset-4 bg-gradient-to-r from-brand-500/20 via-success-500/20 to-brand-500/20 rounded-3xl blur-2xl"></div>
            
            <div class="relative bg-gradient-to-b from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 p-2 sm:p-4 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700">
                <div class="bg-gray-900 rounded-xl overflow-hidden">
                    {{-- Browser Chrome --}}
                    <div class="flex items-center gap-2 px-4 py-3 bg-gray-800 border-b border-gray-700">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 bg-error-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-warning-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-success-500 rounded-full"></div>
                        </div>
                        <div class="flex-1 flex justify-center">
                            <div class="flex items-center gap-2 bg-gray-700 rounded-lg px-4 py-1.5">
                                <svg class="w-3.5 h-3.5 text-success-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                <span class="text-gray-400 text-theme-xs">marupos.id/dashboard</span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Dashboard Content Preview --}}
                    <div class="bg-gray-50 dark:bg-gray-900 p-4 sm:p-6">
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-4">
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-theme-xs border border-gray-100 dark:border-gray-700">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-success-100 dark:bg-success-500/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                </div>
                                <div class="text-theme-xs text-gray-500 dark:text-gray-400 mb-1">Penjualan Hari Ini</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">Rp 4.5M</div>
                                <div class="flex items-center gap-1 text-theme-xs text-success-600 dark:text-success-400 mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                    12% dari kemarin
                                </div>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-theme-xs border border-gray-100 dark:border-gray-700">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-brand-100 dark:bg-brand-500/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    </div>
                                </div>
                                <div class="text-theme-xs text-gray-500 dark:text-gray-400 mb-1">Total Order</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">127</div>
                                <div class="flex items-center gap-1 text-theme-xs text-success-600 dark:text-success-400 mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                    8% dari kemarin
                                </div>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-theme-xs border border-gray-100 dark:border-gray-700">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-warning-100 dark:bg-warning-500/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                                    </div>
                                </div>
                                <div class="text-theme-xs text-gray-500 dark:text-gray-400 mb-1">Meja Terisi</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">18/25</div>
                                <div class="text-theme-xs text-warning-600 dark:text-warning-400 mt-1">72% kapasitas</div>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-theme-xs border border-gray-100 dark:border-gray-700">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-error-100 dark:bg-error-500/20 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-error-600 dark:text-error-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                </div>
                                <div class="text-theme-xs text-gray-500 dark:text-gray-400 mb-1">Order Pending</div>
                                <div class="text-xl font-bold text-error-500">5</div>
                                <div class="text-theme-xs text-gray-400 mt-1">Menunggu diproses</div>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-3 gap-3 sm:gap-4">
                            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl p-4 shadow-theme-xs border border-gray-100 dark:border-gray-700 h-32 sm:h-40">
                                <div class="h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                        <span class="text-theme-xs">Grafik Penjualan</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-theme-xs border border-gray-100 dark:border-gray-700 h-32 sm:h-40">
                                <div class="h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                                        <span class="text-theme-xs">Menu Terlaris</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
