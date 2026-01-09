@php
    $currentPath = request()->path();
    
    // Admin menu groups
    $menuGroups = [
        [
            'title' => 'Overview',
            'items' => [
                [
                    'name' => 'Dashboard',
                    'path' => '/admin',
                    'icon' => 'dashboard',
                    'routes' => ['admin.dashboard'],
                ],
            ]
        ],
        [
            'title' => 'Manajemen',
            'items' => [
                [
                    'name' => 'Perusahaan',
                    'path' => '/admin/companies',
                    'icon' => 'building',
                    'routes' => ['admin.companies.*'],
                ],
                [
                    'name' => 'Langganan',
                    'path' => '/admin/subscriptions',
                    'icon' => 'credit-card',
                    'routes' => ['admin.subscriptions.*'],
                ],
            ]
        ],
        [
            'title' => 'Pengaturan',
            'items' => [
                [
                    'name' => 'Paket Langganan',
                    'path' => '/admin/plans',
                    'icon' => 'package',
                    'routes' => ['admin.plans.*'],
                ],
            ]
        ],
    ];
    
    // Icon SVGs
    $icons = [
        'dashboard' => '<svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
        'building' => '<svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
        'credit-card' => '<svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>',
        'package' => '<svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>',
        'users' => '<svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
        'settings' => '<svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
    ];
    
    function isAdminRouteActive($routes) {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return true;
            }
        }
        return false;
    }
@endphp

<aside id="sidebar"
    class="fixed flex flex-col mt-0 top-0 px-5 left-0 bg-white dark:bg-gray-900 dark:border-gray-800 text-gray-900 h-screen transition-all duration-300 ease-in-out z-99999 border-r border-gray-200"
    :class="{
        'w-[290px]': $store.sidebar.isExpanded || $store.sidebar.isMobileOpen || $store.sidebar.isHovered,
        'w-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
        'translate-x-0': $store.sidebar.isMobileOpen,
        '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
    }"
    @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
    @mouseleave="$store.sidebar.setHovered(false)">
    
    <!-- Logo Section -->
    <div class="pt-8 pb-7 flex"
        :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'xl:justify-center' : 'justify-start'">
        <a href="{{ route('admin.dashboard') }}">
            <!-- Full Logo -->
            <div x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                class="flex items-center gap-2">
                <img class="h-10 w-auto dark:brightness-0 dark:invert" 
                    src="{{ asset('images/logo-premium-nobg.png') }}" 
                    alt="MARUPOS" />
                <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-error-100 text-error-600 dark:bg-error-500/20 dark:text-error-400">
                    Admin
                </span>
            </div>
            <!-- Icon Only -->
            <div x-show="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen"
                class="flex items-center justify-center w-10 h-10 rounded-lg bg-error-500 text-white font-bold text-lg">
                A
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <nav class="mb-6">
            <div class="flex flex-col gap-4">
                @foreach ($menuGroups as $groupIndex => $menuGroup)
                    <div>
                        <!-- Menu Group Title -->
                        <h2 class="mb-4 text-xs uppercase flex leading-[20px] text-gray-400 font-medium"
                            :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'lg:justify-center' : 'justify-start'">
                            <template x-if="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                                <span>{{ $menuGroup['title'] }}</span>
                            </template>
                            <template x-if="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen">
                                <svg class="size-6" viewBox="0 0 24 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z" fill="currentColor"/>
                                </svg>
                            </template>
                        </h2>

                        <!-- Menu Items -->
                        <ul class="flex flex-col gap-1">
                            @foreach ($menuGroup['items'] as $itemIndex => $item)
                                @php
                                    $isActive = isAdminRouteActive($item['routes']);
                                @endphp
                                <li>
                                    <a href="{{ $item['path'] }}" 
                                        class="menu-item group {{ $isActive ? 'menu-item-active' : 'menu-item-inactive' }}"
                                        :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'xl:justify-center' : 'justify-start'">
                                        
                                        <!-- Icon -->
                                        <span class="{{ $isActive ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}">
                                            {!! $icons[$item['icon']] !!}
                                        </span>

                                        <!-- Text -->
                                        <span
                                            x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                            class="menu-item-text">
                                            {{ $item['name'] }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </nav>

        <!-- Back to Main App -->
        <div x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" 
            x-transition 
            class="mt-auto mb-6">
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="mb-2 text-sm font-medium text-gray-800 dark:text-white/90">Mode Admin</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Anda sedang di panel admin</p>
                <a href="{{ route('dashboard') }}" 
                    class="flex items-center justify-center gap-2 rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 transition-colors dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke App
                </a>
            </div>
        </div>
    </div>
</aside>
