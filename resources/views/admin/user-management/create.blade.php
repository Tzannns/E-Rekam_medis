<x-app-layout>
    <div>
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white">Tambah Data User</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Tambahkan user baru ke sistem</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <form action="{{ route('admin.user-management.store') }}" method="POST" class="p-8 space-y-8" id="userForm">
                @csrf

                <!-- Role Selection -->
                <div>
                    <label class="block text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Pilih Tipe User
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <label
                            class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:shadow-md transition"
                            id="role-admin"
                            :class="selectedRole === 'Admin' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900' :
                                'border-gray-200 dark:border-gray-700 dark:bg-gray-700'">
                            <input type="radio" name="role" value="Admin" class="role-input w-5 h-5" required>
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900 dark:text-white block">Admin</span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Akses penuh</span>
                            </div>
                        </label>
                        <label
                            class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:shadow-md transition"
                            id="role-dokter"
                            :class="selectedRole === 'Dokter' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900' :
                                'border-gray-200 dark:border-gray-700 dark:bg-gray-700'">
                            <input type="radio" name="role" value="Dokter" class="role-input w-5 h-5" required>
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900 dark:text-white block">Dokter</span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Medis</span>
                            </div>
                        </label>
                        <label
                            class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:shadow-md transition"
                            id="role-petugas"
                            :class="selectedRole === 'Petugas' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900' :
                                'border-gray-200 dark:border-gray-700 dark:bg-gray-700'">
                            <input type="radio" name="role" value="Petugas" class="role-input w-5 h-5" required>
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900 dark:text-white block">Petugas</span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Staf</span>
                            </div>
                        </label>
                        <label
                            class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:shadow-md transition"
                            id="role-pasien"
                            :class="selectedRole === 'Pasien' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900' :
                                'border-gray-200 dark:border-gray-700 dark:bg-gray-700'">
                            <input type="radio" name="role" value="Pasien" class="role-input w-5 h-5" required>
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900 dark:text-white block">Pasien</span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Umum</span>
                            </div>
                        </label>
                    </div>

                    @error('role')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 dark:border-gray-700"></div>

                <!-- Basic User Fields -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Data Akun User
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror" />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror" />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password <span
                                    class="text-red-500">*</span></label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 @enderror" />
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konfirmasi
                                Password <span class="text-red-500">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password_confirmation') border-red-500 @enderror" />
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Dokter Specific Fields -->
                <div id="dokter-fields" class="hidden pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM9 20H5a2 2 0 01-2-2v-1a6 6 0 0112 0v1a2 2 0 01-2 2H9z">
                            </path>
                        </svg>
                        Data Dokter
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nip"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">NIP <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nip') border-red-500 @enderror" />
                            @error('nip')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="spesialisasi"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Spesialisasi
                                <span class="text-red-500">*</span></label>
                            <input type="text" id="spesialisasi" name="spesialisasi"
                                value="{{ old('spesialisasi') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('spesialisasi') border-red-500 @enderror" />
                            @error('spesialisasi')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="dokter_no_telp" class="block text-sm font-medium text-gray-700">No. Telepon
                                <span class="text-red-500">*</span></label>
                            <input type="text" id="dokter_no_telp" name="no_telp" value="{{ old('no_telp') }}"
                                class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('no_telp') border-red-500 @enderror" />
                            @error('no_telp')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Pasien Specific Fields -->
                    <div id="pasien-fields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t">
                        <div class="md:col-span-2">
                            <h3 class="font-medium text-gray-900 mb-4">Data Pasien</h3>
                        </div>
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700">NIK <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                                class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nik') border-red-500 @enderror" />
                            @error('nik')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir
                                <span class="text-red-500">*</span></label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}"
                                class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_lahir') border-red-500 @enderror" />
                            @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin
                                <span class="text-red-500">*</span></label>
                            <select id="jenis_kelamin" name="jenis_kelamin"
                                class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('jenis_kelamin') border-red-500 @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki"
                                    {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan"
                                    {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat <span
                                    class="text-red-500">*</span></label>
                            <textarea id="alamat" name="alamat"
                                class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="pasien_no_telp" class="block text-sm font-medium text-gray-700">No. Telepon
                                <span class="text-red-500">*</span></label>
                            <input type="text" id="pasien_no_telp" name="no_telp" value="{{ old('no_telp') }}"
                                class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('no_telp') border-red-500 @enderror" />
                            @error('no_telp')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-6 border-t">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Simpan
                        </button>
                        <a href="{{ route('admin.user-management.index') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                            Batal
                        </a>
                    </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleInputs = document.querySelectorAll('.role-input');
            const dokterFields = document.getElementById('dokter-fields');
            const pasienFields = document.getElementById('pasien-fields');

            function updateFieldsVisibility() {
                const selectedRole = document.querySelector('.role-input:checked')?.value;

                dokterFields.classList.toggle('hidden', selectedRole !== 'Dokter');
                dokterFields.classList.toggle('grid', selectedRole === 'Dokter');

                pasienFields.classList.toggle('hidden', selectedRole !== 'Pasien');
                pasienFields.classList.toggle('grid', selectedRole === 'Pasien');

                // Update role button styling
                document.querySelectorAll('[id^="role-"]').forEach(label => {
                    const role = label.querySelector('input').value;
                    if (role === selectedRole) {
                        label.classList.add('border-blue-500', 'bg-blue-50');
                        label.classList.remove('border-gray-200', 'bg-white');
                    } else {
                        label.classList.remove('border-blue-500', 'bg-blue-50');
                        label.classList.add('border-gray-200', 'bg-white');
                    }
                });
            }

            roleInputs.forEach(input => {
                input.addEventListener('change', updateFieldsVisibility);
            });

            // Initialize on page load
            updateFieldsVisibility();
        });
    </script>
</x-app-layout>
