{{-- Testimonials Section --}}
<section id="testimonials" class="py-24 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-950">
    <div class="max-w-7xl mx-auto">
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up" data-aos-duration="600">
            <span class="inline-block px-4 py-1.5 rounded-full bg-warning-50 dark:bg-warning-500/10 text-warning-600 dark:text-warning-400 text-theme-sm font-semibold mb-4">
                TESTIMONI
            </span>
            <h2 class="text-title-md font-bold text-gray-900 dark:text-white mb-4">
                Dipercaya oleh Ribuan Pemilik Bisnis
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-lg">
                Lihat bagaimana MARUPOS telah membantu berbagai jenis usaha meningkatkan efisiensi operasional mereka.
            </p>
        </div>

        {{-- Testimonials Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            {{-- Testimonial 1 --}}
            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 lg:p-8 border border-gray-100 dark:border-gray-800" data-aos="fade-up" data-aos-duration="600">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-warning-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                    "Sistem inventory MARUPOS sangat membantu kami memantau stok barang di toko retail kami. Notifikasi stok menipis sangat berguna, kami jadi jarang kehabisan barang best seller."
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-semibold text-lg">
                        DI
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">Dani Iskandar</div>
                        <div class="text-theme-sm text-gray-500 dark:text-gray-400">Owner, Toko Berkah Retail</div>
                    </div>
                </div>
            </div>

            {{-- Testimonial 2 --}}
            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 lg:p-8 border border-gray-100 dark:border-gray-800" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-warning-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                    "Fitur QR Order-nya game changer! Pelanggan bisa langsung order dari meja mereka. Staff kami jadi bisa fokus ke pelayanan yang lebih personal. Highly recommended."
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-success-400 to-success-600 flex items-center justify-center text-white font-semibold text-lg">
                        SA
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">Sari Andini</div>
                        <div class="text-theme-sm text-gray-500 dark:text-gray-400">Manager, Cafe Kopi Nusantara</div>
                    </div>
                </div>
            </div>

            {{-- Testimonial 3 --}}
            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 lg:p-8 border border-gray-100 dark:border-gray-800" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-warning-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                    "Kami mengelola 5 cabang franchise minuman dan MARUPOS memudahkan pemantauan penjualan secara real-time dari pusat. Sangat efisien untuk manajemen multi-outlet."
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-warning-400 to-warning-600 flex items-center justify-center text-white font-semibold text-lg">
                        RH
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">Rudi Hartono</div>
                        <div class="text-theme-sm text-gray-500 dark:text-gray-400">CEO, Fresh Tea Franchise</div>
                    </div>
                </div>
            </div>

            {{-- Testimonial 4 --}}
            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 lg:p-8 border border-gray-100 dark:border-gray-800" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-warning-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                    "Kitchen Display System-nya luar biasa. Pesanan langsung muncul di layar dapur, tidak ada lagi sticky notes yang hilang. Waktu masak jadi lebih cepat dan akurat."
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-error-400 to-error-600 flex items-center justify-center text-white font-semibold text-lg">
                        DM
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">Dewi Maharani</div>
                        <div class="text-theme-sm text-gray-500 dark:text-gray-400">Head Chef, Dapur Mama</div>
                    </div>
                </div>
            </div>

            {{-- Testimonial 5 --}}
            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 lg:p-8 border border-gray-100 dark:border-gray-800" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-warning-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                    "Sistem kasir yang simpel tapi powerful. Sangat cocok untuk food truck kami yang butuh kecepatan transaksi. struk digital via WA juga jadi nilai plus buat pelanggan."
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-light-400 to-blue-light-600 flex items-center justify-center text-white font-semibold text-lg">
                        AW
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">Anton Wijaya</div>
                        <div class="text-theme-sm text-gray-500 dark:text-gray-400">Owner, Burger On Wheels</div>
                    </div>
                </div>
            </div>

            {{-- Testimonial 6 --}}
            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 lg:p-8 border border-gray-100 dark:border-gray-800" data-aos="fade-up" data-aos-duration="600" data-aos-delay="500">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-warning-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                    "Fitur pelanggan dan loyalty point-nya sangat membantu kami menjaga customer retention di barbershop kami. Pelanggan senang bisa kumpulkan poin setiap kali datang."
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-semibold text-lg">
                        LP
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">Linda Permata</div>
                        <div class="text-theme-sm text-gray-500 dark:text-gray-400">Owner, Gentleman Barber</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
