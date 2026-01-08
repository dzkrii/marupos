<x-app-layout>
    <x-slot name="title">Edit Karyawan - {{ $employee->name }}</x-slot>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('employees.index') }}" 
                class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Edit Karyawan</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $employee->name }}</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="mx-auto max-w-4xl">
        <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data" x-data="employeeForm()">
            @csrf
            @method('PUT')

            <!-- Basic Info Card -->
            <x-ui.card title="Informasi Karyawan" description="Perbarui data karyawan" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <x-ui.input name="name" label="Nama Lengkap" placeholder="Masukkan nama lengkap" :value="$employee->name" required autofocus />
                    </div>

                    <!-- Email (Read-only) -->
                    <div>
                        <x-ui.input type="email" name="email_display" label="Email" :value="$employee->email" disabled hint="Email tidak dapat diubah" />
                    </div>

                    <!-- Phone -->
                    <div>
                        <x-ui.input name="phone" label="Nomor Telepon" placeholder="08123456789" :value="$employee->phone" />
                    </div>

                    <!-- Current Avatar -->
                    @if($employee->avatar)
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Foto Profil Saat Ini</label>
                            <div class="flex items-center gap-4">
                                <img src="{{ Storage::url($employee->avatar) }}" alt="{{ $employee->name }}"
                                    class="w-20 h-20 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700">
                                <label class="flex items-center text-sm text-error-600 cursor-pointer hover:text-error-700 dark:text-error-400 dark:hover:text-error-300">
                                    <input type="checkbox" name="remove_avatar" value="1"
                                        class="rounded border-gray-300 text-error-600 shadow-sm focus:ring-error-500 mr-2 dark:border-gray-600 dark:bg-gray-800">
                                    Hapus foto
                                </label>
                            </div>
                        </div>
                    @endif

                    <!-- New Avatar -->
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ $employee->avatar ? 'Upload Foto Baru' : 'Foto Profil' }}
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="avatar"
                                class="flex flex-col items-center justify-center w-full h-32 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 cursor-pointer transition-colors hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:hover:bg-gray-800">
                                <div id="avatar-preview" class="hidden w-full h-full">
                                    <img src="" alt="Preview" class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div id="avatar-placeholder" class="flex flex-col items-center justify-center py-4">
                                    <svg class="size-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Klik untuk upload</p>
                                </div>
                                <input id="avatar" name="avatar" type="file" class="hidden" accept="image/*" onchange="previewAvatar(this)">
                            </label>
                        </div>
                        @error('avatar')
                            <p class="mt-1.5 text-sm text-error-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            <!-- Capabilities Card -->
            <x-ui.card title="Hak Akses" description="Atur kemampuan yang diberikan kepada karyawan ini" class="mb-6">
                <!-- Role Presets -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-3">Template Cepat</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($rolePresets as $presetKey => $preset)
                            <button type="button"
                                @click="applyPreset('{{ $presetKey }}')"
                                class="inline-flex items-center px-4 py-2 rounded-lg border-2 text-sm font-medium transition-all"
                                :class="activePreset === '{{ $presetKey }}' 
                                    ? 'border-brand-500 bg-brand-50 text-brand-700 dark:bg-brand-500/15 dark:text-brand-400' 
                                    : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-600'">
                                {{ $preset['name'] }}
                            </button>
                        @endforeach
                        <button type="button"
                            @click="clearPreset()"
                            class="inline-flex items-center px-4 py-2 rounded-lg border-2 text-sm font-medium transition-all"
                            :class="activePreset === 'custom' 
                                ? 'border-purple-500 bg-purple-50 text-purple-700 dark:bg-purple-500/15 dark:text-purple-400' 
                                : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-600'">
                            <svg class="size-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            Custom
                        </button>
                    </div>
                </div>

                <!-- Capabilities Checkboxes -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($capabilities as $key => $capability)
                        <label 
                            class="relative flex items-start p-4 rounded-xl border-2 cursor-pointer transition-all"
                            :class="selectedCapabilities.includes('{{ $key }}') 
                                ? 'border-brand-500 bg-brand-50 dark:bg-brand-500/10' 
                                : 'border-gray-200 hover:border-gray-300 dark:border-gray-700 dark:hover:border-gray-600'">
                            <input type="checkbox" 
                                name="capabilities[]" 
                                value="{{ $key }}"
                                x-model="selectedCapabilities"
                                @change="updatePreset()"
                                class="mt-0.5 h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-800">
                            <div class="ml-3">
                                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">
                                    {{ $capability['name'] }}
                                </span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ $capability['description'] }}
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>

                @error('capabilities')
                    <p class="mt-3 text-sm text-error-500">{{ $message }}</p>
                @enderror
                @error('capabilities.*')
                    <p class="mt-3 text-sm text-error-500">{{ $message }}</p>
                @enderror

                <!-- Selected Summary -->
                <div class="mt-6 p-4 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Akses Terpilih:
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400" x-text="selectedCapabilities.length + ' kemampuan'"></span>
                    </div>
                    <div class="mt-2 flex flex-wrap gap-1" x-show="selectedCapabilities.length > 0">
                        <template x-for="cap in selectedCapabilities" :key="cap">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-brand-100 text-brand-700 dark:bg-brand-500/20 dark:text-brand-400" x-text="capabilityNames[cap]"></span>
                        </template>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400" x-show="selectedCapabilities.length === 0">
                        Belum ada kemampuan yang dipilih
                    </p>
                </div>
            </x-ui.card>

            <!-- Security Card -->
            <x-ui.card title="Keamanan" description="Pengaturan password dan PIN" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Change Password -->
                    <div>
                        <x-ui.input type="password" name="password" label="Password Baru" hint="Kosongkan jika tidak ingin mengubah password" />
                    </div>

                    <!-- PIN -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            PIN (6 Digit)
                        </label>
                        <div class="flex gap-2">
                            <input type="text" name="pin" id="pin" value="{{ old('pin', $employee->pin) }}"
                                class="shadow-theme-xs h-11 flex-1 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                pattern="[0-9]{6}" maxlength="6" placeholder="123456">
                            <button type="button" onclick="generateRandomPin()"
                                class="flex items-center gap-1 px-4 py-2 text-sm font-medium bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 dark:text-white transition-colors">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Generate
                            </button>
                        </div>
                        <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">Untuk login cepat di kasir</p>
                        @error('pin')
                            <p class="mt-1.5 text-sm text-error-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3">
                <x-ui.button href="{{ route('employees.index') }}" variant="outline">
                    Batal
                </x-ui.button>
                <x-ui.button type="submit" variant="primary">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </x-ui.button>
            </div>
        </form>
    </div>

    <script>
        function previewAvatar(input) {
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function generateRandomPin() {
            const pin = Math.floor(100000 + Math.random() * 900000);
            document.getElementById('pin').value = pin;
        }

        function employeeForm() {
            return {
                selectedCapabilities: @json(old('capabilities', $currentCapabilities)),
                activePreset: 'custom',
                presets: @json($rolePresets),
                capabilityNames: {
                    @foreach($capabilities as $key => $cap)
                        '{{ $key }}': '{{ $cap['name'] }}',
                    @endforeach
                },
                
                init() {
                    // Determine initial preset based on selected capabilities
                    this.updatePreset();
                },
                
                applyPreset(presetKey) {
                    this.activePreset = presetKey;
                    this.selectedCapabilities = [...this.presets[presetKey].capabilities];
                },
                
                clearPreset() {
                    this.activePreset = 'custom';
                    this.selectedCapabilities = ['dashboard'];
                },
                
                updatePreset() {
                    // Check if current selection matches any preset
                    for (const [key, preset] of Object.entries(this.presets)) {
                        if (this.arraysEqual(this.selectedCapabilities.sort(), preset.capabilities.sort())) {
                            this.activePreset = key;
                            return;
                        }
                    }
                    this.activePreset = 'custom';
                },
                
                arraysEqual(a, b) {
                    if (a.length !== b.length) return false;
                    const sortedA = [...a].sort();
                    const sortedB = [...b].sort();
                    return sortedA.every((val, i) => val === sortedB[i]);
                }
            }
        }
    </script>
</x-app-layout>
