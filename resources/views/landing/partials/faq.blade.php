{{-- FAQ Section --}}
<section id="faq" class="py-24 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-950">
    <div class="max-w-4xl mx-auto">
        {{-- Section Header --}}
        <div class="text-center mb-16" data-aos="fade-up" data-aos-duration="600">
            <span class="inline-block px-4 py-1.5 rounded-full bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 text-theme-sm font-semibold mb-4">
                FAQ
            </span>
            <h2 class="text-title-md font-bold text-gray-900 dark:text-white mb-4">
                Pertanyaan yang Sering Ditanyakan
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-lg">
                Temukan jawaban untuk pertanyaan umum tentang MARUPOS
            </p>
        </div>

        {{-- FAQ Accordion --}}
        <div x-data="{ activeIndex: 0 }" class="space-y-4" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
            {{-- FAQ Item 1 --}}
            <div class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
                <button @click="activeIndex = activeIndex === 0 ? null : 0" class="w-full flex items-center justify-between p-5 text-left bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="font-semibold text-gray-900 dark:text-white">Apakah ada trial gratis?</span>
                    <svg :class="activeIndex === 0 ? 'rotate-180' : ''" class="w-5 h-5 text-gray-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="activeIndex === 0" x-collapse>
                    <div class="p-5 bg-white dark:bg-gray-950 text-gray-600 dark:text-gray-400">
                        Ya! Kami menyediakan trial gratis selama 14 hari untuk semua fitur tanpa memerlukan kartu kredit. Anda bisa mencoba semua fitur Professional selama periode trial.
                    </div>
                </div>
            </div>

            {{-- FAQ Item 2 --}}
            <div class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
                <button @click="activeIndex = activeIndex === 1 ? null : 1" class="w-full flex items-center justify-between p-5 text-left bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="font-semibold text-gray-900 dark:text-white">Bisakah saya upgrade atau downgrade paket?</span>
                    <svg :class="activeIndex === 1 ? 'rotate-180' : ''" class="w-5 h-5 text-gray-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="activeIndex === 1" x-collapse>
                    <div class="p-5 bg-white dark:bg-gray-950 text-gray-600 dark:text-gray-400">
                        Tentu! Anda bisa upgrade atau downgrade paket kapan saja melalui dashboard. Perubahan akan berlaku di periode billing berikutnya. Untuk upgrade, Anda bisa langsung menggunakan fitur baru.
                    </div>
                </div>
            </div>

            {{-- FAQ Item 3 --}}
            <div class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
                <button @click="activeIndex = activeIndex === 2 ? null : 2" class="w-full flex items-center justify-between p-5 text-left bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="font-semibold text-gray-900 dark:text-white">Apakah data saya aman?</span>
                    <svg :class="activeIndex === 2 ? 'rotate-180' : ''" class="w-5 h-5 text-gray-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="activeIndex === 2" x-collapse>
                    <div class="p-5 bg-white dark:bg-gray-950 text-gray-600 dark:text-gray-400">
                        Keamanan data adalah prioritas utama kami. Semua data di-encrypt baik saat transit maupun saat disimpan. Kami menggunakan infrastruktur cloud terpercaya dengan backup harian dan disaster recovery yang solid.
                    </div>
                </div>
            </div>

            {{-- FAQ Item 4 --}}
            <div class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
                <button @click="activeIndex = activeIndex === 3 ? null : 3" class="w-full flex items-center justify-between p-5 text-left bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="font-semibold text-gray-900 dark:text-white">Apakah bisa digunakan offline?</span>
                    <svg :class="activeIndex === 3 ? 'rotate-180' : ''" class="w-5 h-5 text-gray-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="activeIndex === 3" x-collapse>
                    <div class="p-5 bg-white dark:bg-gray-950 text-gray-600 dark:text-gray-400">
                        MARUPOS adalah aplikasi web-based yang membutuhkan koneksi internet. Namun, kami sedang mengembangkan mode offline untuk transaksi dasar yang akan segera tersedia. Data akan di-sync otomatis saat online kembali.
                    </div>
                </div>
            </div>

            {{-- FAQ Item 5 --}}
            <div class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
                <button @click="activeIndex = activeIndex === 4 ? null : 4" class="w-full flex items-center justify-between p-5 text-left bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="font-semibold text-gray-900 dark:text-white">Bagaimana dengan support teknis?</span>
                    <svg :class="activeIndex === 4 ? 'rotate-180' : ''" class="w-5 h-5 text-gray-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="activeIndex === 4" x-collapse>
                    <div class="p-5 bg-white dark:bg-gray-950 text-gray-600 dark:text-gray-400">
                        Kami menyediakan support 24/7 melalui berbagai channel: email, live chat, dan WhatsApp. Paket Professional dan Enterprise mendapatkan priority support dengan response time yang lebih cepat.
                    </div>
                </div>
            </div>

            {{-- FAQ Item 6 --}}
            <div class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
                <button @click="activeIndex = activeIndex === 5 ? null : 5" class="w-full flex items-center justify-between p-5 text-left bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <span class="font-semibold text-gray-900 dark:text-white">Apakah ada biaya tambahan selain subscription?</span>
                    <svg :class="activeIndex === 5 ? 'rotate-180' : ''" class="w-5 h-5 text-gray-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="activeIndex === 5" x-collapse>
                    <div class="p-5 bg-white dark:bg-gray-950 text-gray-600 dark:text-gray-400">
                        Tidak ada biaya tersembunyi. Harga subscription sudah mencakup semua fitur sesuai paket yang dipilih, unlimited transaksi, dan penyimpanan data. Tidak ada biaya per transaksi atau biaya setup.
                    </div>
                </div>
            </div>
        </div>

        {{-- Still Have Questions CTA --}}
        <div class="mt-12 text-center p-8 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800" data-aos="fade-up" data-aos-duration="600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Masih punya pertanyaan?</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Tim kami siap membantu menjawab pertanyaan Anda</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="mailto:support@marupos.id" class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl font-medium text-gray-700 dark:text-gray-300 hover:border-brand-500 hover:text-brand-500 transition-all shadow-theme-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    support@marupos.id
                </a>
                <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 bg-success-500 hover:bg-success-600 rounded-xl font-medium text-white transition-all shadow-theme-xs">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    WhatsApp Kami
                </a>
            </div>
        </div>
    </div>
</section>
