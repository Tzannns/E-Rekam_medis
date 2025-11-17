<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Pengaturan Aplikasi</h2>
                <p class="mt-1 text-sm text-gray-500">Konfigurasi umum aplikasi dan informasi instansi</p>
            </div>
            <a href="{{ route('admin.manajemen.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                ← Kembali
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.manajemen.update-pengaturan') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg">
            @csrf
            @method('POST')
            
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Informasi Aplikasi</h3>
            </div>
            
            <div class="p-6 space-y-6">
                {{-- Nama Aplikasi --}}
                <div>
                    <label for="nama_aplikasi" class="block text-sm font-medium text-gray-700 mb-2">Nama Aplikasi</label>
                    <input type="text" name="nama_aplikasi" id="nama_aplikasi" value="{{ old('nama_aplikasi', $pengaturan->nama_aplikasi) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('nama_aplikasi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Instansi --}}
                <div>
                    <label for="nama_instansi" class="block text-sm font-medium text-gray-700 mb-2">Nama Instansi</label>
                    <input type="text" name="nama_instansi" id="nama_instansi" value="{{ old('nama_instansi', $pengaturan->nama_instansi) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('nama_instansi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat Instansi --}}
                <div>
                    <label for="alamat_instansi" class="block text-sm font-medium text-gray-700 mb-2">Alamat Instansi</label>
                    <textarea name="alamat_instansi" id="alamat_instansi" rows="3" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('alamat_instansi', $pengaturan->alamat_instansi) }}</textarea>
                    @error('alamat_instansi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No Telp & Email --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                        <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $pengaturan->no_telp) }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @error('no_telp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $pengaturan->email) }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Logo & Favicon --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Logo Aplikasi</label>
                        @if($pengaturan->logo)
                            <div class="mb-2">
                                <img src="{{ Storage::url($pengaturan->logo) }}" alt="Logo" class="h-16 w-auto">
                            </div>
                        @endif
                        <input type="file" name="logo" id="logo" accept="image/*" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF. Max: 2MB</p>
                        @error('logo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="favicon" class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                        @if($pengaturan->favicon)
                            <div class="mb-2">
                                <img src="{{ Storage::url($pengaturan->favicon) }}" alt="Favicon" class="h-8 w-8">
                            </div>
                        @endif
                        <input type="file" name="favicon" id="favicon" accept="image/x-icon,image/vnd.microsoft.icon,image/png" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Format: ICO, PNG. Max: 512KB</p>
                        @error('favicon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Pengaturan Sistem</h3>
            </div>
            
            <div class="p-6 space-y-6">
                {{-- Timezone --}}
                <div>
                    <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                    <select name="timezone" id="timezone" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="Asia/Jakarta" {{ old('timezone', $pengaturan->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                        <option value="Asia/Makassar" {{ old('timezone', $pengaturan->timezone) == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                        <option value="Asia/Jayapura" {{ old('timezone', $pengaturan->timezone) == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                    </select>
                    @error('timezone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bahasa --}}
                <div>
                    <label for="bahasa" class="block text-sm font-medium text-gray-700 mb-2">Bahasa</label>
                    <select name="bahasa" id="bahasa" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="id" {{ old('bahasa', $pengaturan->bahasa) == 'id' ? 'selected' : '' }}>Indonesia</option>
                        <option value="en" {{ old('bahasa', $pengaturan->bahasa) == 'en' ? 'selected' : '' }}>English</option>
                    </select>
                    @error('bahasa')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tema --}}
                <div>
                    <label for="tema" class="block text-sm font-medium text-gray-700 mb-2">Tema</label>
                    <select name="tema" id="tema" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="light" {{ old('tema', $pengaturan->tema) == 'light' ? 'selected' : '' }}>Light</option>
                        <option value="dark" {{ old('tema', $pengaturan->tema) == 'dark' ? 'selected' : '' }}>Dark</option>
                    </select>
                    @error('tema')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Items Per Page --}}
                <div>
                    <label for="items_per_page" class="block text-sm font-medium text-gray-700 mb-2">Item per Halaman</label>
                    <input type="number" name="items_per_page" id="items_per_page" value="{{ old('items_per_page', $pengaturan->items_per_page) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="5" max="100" required>
                    @error('items_per_page')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Maintenance Mode --}}
                <div class="flex items-center">
                    <input type="checkbox" name="maintenance_mode" id="maintenance_mode" value="1" 
                           {{ old('maintenance_mode', $pengaturan->maintenance_mode) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <label for="maintenance_mode" class="ml-2 block text-sm text-gray-900">Mode Maintenance</label>
                </div>

                {{-- Maintenance Message --}}
                <div id="maintenance_message_div" style="display: {{ $pengaturan->maintenance_mode ? 'block' : 'none' }}">
                    <label for="maintenance_message" class="block text-sm font-medium text-gray-700 mb-2">Pesan Maintenance</label>
                    <textarea name="maintenance_message" id="maintenance_message" rows="3" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('maintenance_message', $pengaturan->maintenance_message) }}</textarea>
                    @error('maintenance_message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Registrasi Pasien --}}
                <div class="flex items-center">
                    <input type="checkbox" name="registrasi_pasien" id="registrasi_pasien" value="1" 
                           {{ old('registrasi_pasien', $pengaturan->registrasi_pasien) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <label for="registrasi_pasien" class="ml-2 block text-sm text-gray-900">Izinkan Registrasi Pasien</label>
                </div>

                {{-- Antrian Online --}}
                <div class="flex items-center">
                    <input type="checkbox" name="antrian_online" id="antrian_online" value="1" 
                           {{ old('antrian_online', $pengaturan->antrian_online) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <label for="antrian_online" class="ml-2 block text-sm text-gray-900">Aktifkan Antrian Online</label>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 text-right">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    <script>
        // Toggle maintenance message visibility
        document.getElementById('maintenance_mode').addEventListener('change', function() {
            const messageDiv = document.getElementById('maintenance_message_div');
            if (this.checked) {
                messageDiv.style.display = 'block';
            } else {
                messageDiv.style.display = 'none';
            }
        });
    </script>
</x-app-layout>