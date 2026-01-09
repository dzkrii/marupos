{{-- How It Works Section --}}
<section id="how-it-works" class="py-24 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto">
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up" data-aos-duration="600">
            <span class="inline-block px-4 py-1.5 rounded-full bg-success-50 dark:bg-success-500/10 text-success-600 dark:text-success-400 text-theme-sm font-semibold mb-4">
                CARA KERJA
            </span>
            <h2 class="text-title-md font-bold text-gray-900 dark:text-white mb-4">
                Mulai dalam 3 Langkah Mudah
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-lg">
                Tidak perlu instalasi rumit. Daftar, setup, dan langsung gunakan MARUPOS untuk restoran Anda.
            </p>
        </div>

        {{-- Steps --}}
        <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
            {{-- Step 1 --}}
            <div class="relative" data-aos="fade-up" data-aos-duration="600">
                <div class="text-center">
                    <div class="relative inline-flex items-center justify-center mb-8">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                            <span class="text-3xl font-bold text-white">1</span>
                        </div>
                        {{-- Connector Line (hidden on mobile) --}}
                        <div class="hidden md:block absolute left-full top-1/2 w-full h-0.5 bg-gradient-to-r from-brand-300 to-success-300 dark:from-brand-700 dark:to-success-700 -translate-y-1/2 ml-4"></div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Daftar Akun</h3>
                    <p class="text-gray-600 dark:text-gray-400">Buat akun gratis dalam 2 menit. Tidak perlu kartu kredit untuk mencoba trial 14 hari.</p>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="relative" data-aos="fade-up" data-aos-duration="600" data-aos-delay="150">
                <div class="text-center">
                    <div class="relative inline-flex items-center justify-center mb-8">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-success-500 to-success-600 flex items-center justify-center shadow-lg shadow-success-500/30">
                            <span class="text-3xl font-bold text-white">2</span>
                        </div>
                        {{-- Connector Line (hidden on mobile) --}}
                        <div class="hidden md:block absolute left-full top-1/2 w-full h-0.5 bg-gradient-to-r from-success-300 to-warning-300 dark:from-success-700 dark:to-warning-700 -translate-y-1/2 ml-4"></div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Setup Restoran</h3>
                    <p class="text-gray-600 dark:text-gray-400">Tambahkan outlet, meja, dan menu Anda. Import data existing atau mulai dari awal dengan mudah.</p>
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="relative" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center mb-8">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-warning-500 to-warning-600 flex items-center justify-center shadow-lg shadow-warning-500/30">
                            <span class="text-3xl font-bold text-white">3</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Mulai Operasional</h3>
                    <p class="text-gray-600 dark:text-gray-400">Langsung terima pesanan dan mulai tingkatkan efisiensi restoran Anda hari ini juga.</p>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="mt-16 text-center" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white rounded-xl px-8 py-4 font-semibold transition-all shadow-lg shadow-brand-500/25 hover:shadow-xl hover:shadow-brand-500/30">
                Coba Gratis Sekarang
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>
    </div>
</section>
