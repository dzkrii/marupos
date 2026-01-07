<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Daftarkan Restoran Anda</h2>
        <p class="text-gray-600 mt-1">Mulai kelola bisnis kuliner Anda dengan Restozen</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Restaurant Name -->
        <div>
            <x-input-label for="restaurant_name" :value="__('Nama Restoran')" class="text-gray-700 font-medium" />
            <x-text-input id="restaurant_name" 
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 transition" 
                type="text" 
                name="restaurant_name" 
                :value="old('restaurant_name')" 
                required 
                autofocus
                placeholder="Warung Makan Nusantara" />
            <x-input-error :messages="$errors->get('restaurant_name')" class="mt-2" />
        </div>

        <!-- Owner Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Pemilik')" class="text-gray-700 font-medium" />
            <x-text-input id="name" 
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 transition" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required
                placeholder="Budi Santoso" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
            <x-text-input id="email" 
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 transition" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required
                placeholder="nama@restoran.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('No. Telepon')" class="text-gray-700 font-medium" />
            <x-text-input id="phone" 
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 transition" 
                type="tel" 
                name="phone" 
                :value="old('phone')"
                placeholder="08123456789" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
            <x-text-input id="password" 
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 transition"
                type="password"
                name="password"
                required 
                autocomplete="new-password"
                placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-700 font-medium" />
            <x-text-input id="password_confirmation" 
                class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 transition"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms -->
        <div class="flex items-start">
            <input id="terms" type="checkbox" 
                class="mt-1 rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" 
                name="terms"
                required>
            <label for="terms" class="ms-2 text-sm text-gray-600">
                Saya setuju dengan <a href="#" class="text-primary-600 hover:underline">Syarat & Ketentuan</a> 
                dan <a href="#" class="text-primary-600 hover:underline">Kebijakan Privasi</a>
            </label>
        </div>

        <!-- Register Button -->
        <button type="submit" 
            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 ease-in-out transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
            Daftar Sekarang
        </button>
    </form>

    <!-- Divider -->
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="bg-gray-50 px-4 text-gray-500">atau</span>
        </div>
    </div>

    <!-- Login Link -->
    <div class="text-center">
        <p class="text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-500 font-semibold">
                Masuk
            </a>
        </p>
    </div>
</x-guest-layout>
