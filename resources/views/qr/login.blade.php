<x-layouts.guest-qr>
    <x-slot name="title">Masuk - {{ $outlet->name }}</x-slot>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col justify-center py-12 px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Outlet Info -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-2">{{ $outlet->name }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Silakan masukkan kode akses untuk memesan.</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white dark:bg-gray-800 py-8 px-6 shadow-theme-lg rounded-2xl sm:px-10 border border-gray-100 dark:border-gray-700/50">
                
                @if(session('error'))
                    <div class="mb-6 bg-error-50 dark:bg-error-500/10 border border-error-100 dark:border-error-500/20 text-error-600 dark:text-error-400 px-4 py-3 rounded-xl text-sm font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('qr.verify', [$outletSlug, $tableQr]) }}" method="POST">
                    @csrf
                    <div>
                        <label for="access_code" class="block text-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Masukkan 6 Digit Kode Akses
                        </label>
                        <div class="mt-4 relative rounded-xl shadow-sm">
                            <input 
                                id="access_code" 
                                name="access_code" 
                                type="text" 
                                inputmode="numeric" 
                                pattern="[0-9]*"
                                maxlength="6"
                                autocomplete="off" 
                                required 
                                class="focus:ring-brand-500 focus:border-brand-500 block w-full text-center text-3xl tracking-[1rem] font-bold border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-brand-400 rounded-xl py-4 placeholder:text-gray-300 dark:placeholder:text-gray-600" 
                                placeholder="000000">
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-theme-sm text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all hover:scale-[1.02] active:scale-[0.98]">
                            Masuk
                        </button>
                    </div>
                </form>

                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                Bantuan
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-400 dark:text-gray-500">
                            Silakan tanyakan kode akses kepada pelayan atau kasir yang bertugas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest-qr>
