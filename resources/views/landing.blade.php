<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- SEO Meta Tags --}}
    <title>MARUPOS - Modern POS untuk Restoran Anda</title>
    <meta name="description" content="MARUPOS adalah sistem POS modern untuk restoran dengan fitur lengkap: manajemen menu, QR order, kitchen display, dan laporan keuangan. Coba gratis 14 hari!">
    <meta name="keywords" content="POS restoran, sistem kasir restoran, manajemen restoran, QR order, kitchen display system">
    <meta name="author" content="MARUPOS">
    
    {{-- Open Graph / Social Media --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="MARUPOS - Modern POS untuk Restoran Anda">
    <meta property="og:description" content="Sistem POS modern untuk restoran Indonesia. Kelola bisnis lebih efisien dengan teknologi terkini.">
    <meta property="og:image" content="{{ asset('images/og-image.png') }}">
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="MARUPOS - Modern POS untuk Restoran Anda">
    <meta name="twitter:description" content="Sistem POS modern untuk restoran Indonesia. Kelola bisnis lebih efisien dengan teknologi terkini.">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/marupos-symbol.png') }}">
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    
    {{-- Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- AOS Animation Library --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    {{-- Alpine.js Collapse Plugin --}}
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        html { 
            scroll-behavior: smooth; 
        }
        
        /* Custom scrollbar for light mode */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        /* Dark mode scrollbar */
        .dark ::-webkit-scrollbar-track {
            background: #1f2937;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>
</head>
<body class="bg-white dark:bg-gray-950 font-inter antialiased">
    {{-- Navbar --}}
    @include('landing.partials.navbar')
    
    {{-- Hero Section --}}
    @include('landing.partials.hero')
    
    {{-- Stats Section --}}
    @include('landing.partials.stats')
    
    {{-- Features Section --}}
    @include('landing.partials.features')
    
    {{-- How It Works Section --}}
    @include('landing.partials.how-it-works')
    
    {{-- Testimonials Section --}}
    @include('landing.partials.testimonials')
    
    {{-- Pricing Section --}}
    @include('landing.partials.pricing')
    
    {{-- FAQ Section --}}
    @include('landing.partials.faq')
    
    {{-- CTA Section --}}
    @include('landing.partials.cta')
    
    {{-- Footer --}}
    @include('landing.partials.footer')

    {{-- AOS Animation Script --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 600,
            easing: 'ease-out-cubic',
            offset: 50,
        });
    </script>
    
    {{-- Smooth scroll offset for fixed header --}}
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 100;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
