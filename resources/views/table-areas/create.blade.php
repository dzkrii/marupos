<x-app-layout>
    <x-slot name="title">Tambah Area Meja</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('table-areas.index') }}" 
                class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Tambah Area Meja</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Buat area baru untuk pengelompokan meja</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="mx-auto max-w-2xl">
        <x-ui.card title="Informasi Area" description="Lengkapi data area meja di bawah ini">
            <form action="{{ route('table-areas.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Name -->
                    <x-ui.input 
                        name="name" 
                        label="Nama Area" 
                        placeholder="Contoh: Indoor, Outdoor, VIP Room, Teras"
                        required 
                        autofocus 
                    />

                    <!-- Status -->
                    <x-ui.toggle name="is_active" :checked="true" label="Area aktif dan ditampilkan" />
                </div>

                <!-- Actions -->
                <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-200 pt-6 dark:border-gray-800">
                    <x-ui.button href="{{ route('table-areas.index') }}" variant="outline">
                        Batal
                    </x-ui.button>
                    <x-ui.button type="submit" variant="primary">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Area
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-app-layout>
