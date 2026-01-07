{{-- Top Navigation Bar --}}
<header class="sticky top-0 z-30 h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-6">
    {{-- Left: Mobile Menu Toggle & Breadcrumb --}}
    <div class="flex items-center gap-4">
        {{-- Mobile menu button --}}
        <button @click="sidebarMobileOpen = true" class="lg:hidden p-2 -ml-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- Page Title / Breadcrumb --}}
        @isset($header)
            <div class="hidden sm:block">
                {{ $header }}
            </div>
        @endisset
    </div>

    {{-- Right: Actions --}}
    <div class="flex items-center gap-2 sm:gap-4">
        {{-- Quick Actions --}}
        <a href="{{ route('menu-items.create') }}"
           class="hidden md:inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Menu</span>
        </a>

        {{-- Notifications (Placeholder) --}}
        <button class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            {{-- Badge --}}
            <span class="absolute top-1 right-1 w-2 h-2 bg-primary-500 rounded-full"></span>
        </button>

        {{-- Theme Toggle (Placeholder) --}}
        <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>

        {{-- Mobile User Avatar --}}
        <div class="lg:hidden">
            <a href="{{ route('profile.edit') }}" class="flex items-center justify-center w-9 h-9 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-full">
                <span class="text-sm font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </a>
        </div>
    </div>
</header>
