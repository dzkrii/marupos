{{-- CTA Section --}}
<section class="py-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    {{-- Background Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-br from-brand-600 via-brand-500 to-brand-700"></div>
    
    {{-- Decorative Elements --}}
    <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-success-500/20 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>
    <div class="absolute top-1/2 left-1/2 w-[600px] h-[600px] -translate-x-1/2 -translate-y-1/2">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2260%22%20height%3D%2260%22%3E%3Cpath%20d%3D%22M0%200h60v60H0z%22%20fill%3D%22none%22%2F%3E%3Cpath%20d%3D%22M60%200v60M0%200h60%22%20stroke%3D%22rgba(255,255,255,0.08)%22%20stroke-width%3D%221%22%2F%3E%3C%2Fsvg%3E')]"></div>
    </div>
    
    <div class="relative max-w-4xl mx-auto text-center" data-aos="fade-up" data-aos-duration="600">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white/90 text-theme-sm font-medium mb-6">
            <svg class="w-5 h-5 text-success-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Bergabung sekarang dan dapatkan setup gratis!
        </div>
        
        <h2 class="text-3xl sm:text-4xl lg:text-title-lg font-bold text-white mb-6">
            Siap Tingkatkan Bisnis <br class="hidden sm:block">Restoran Anda?
        </h2>
        
        <p class="text-white/80 text-lg mb-10 max-w-2xl mx-auto">
            Mulai gratis 14 hari. Tidak perlu kartu kredit. Batalkan kapan saja. 
            <span class="text-white font-medium">Lebih dari 500 restoran</span> sudah mempercayai MARUPOS.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="group flex items-center gap-2 bg-white hover:bg-gray-100 text-brand-600 rounded-xl px-8 py-4 font-semibold transition-all shadow-xl hover:shadow-2xl hover:-translate-y-0.5">
                Daftar Sekarang — Gratis
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
            <a href="#contact" class="flex items-center gap-2 px-8 py-4 border border-white/30 hover:border-white/50 hover:bg-white/10 text-white rounded-xl font-semibold transition-all backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Hubungi Kami
            </a>
        </div>
        
        {{-- Trust Indicators --}}
        <div class="mt-12 flex flex-wrap items-center justify-center gap-6 text-white/70 text-theme-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-success-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Setup dalam 5 menit
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-success-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Tidak perlu kartu kredit
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-success-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Support 24/7
            </div>
        </div>
    </div>
</section>
