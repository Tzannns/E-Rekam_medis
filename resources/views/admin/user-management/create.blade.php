<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Tambah Data User</h2>
            <p class="mt-1 text-sm text-gray-500">Tambahkan user baru ke sistem</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.user-management.store') }}" method="POST" class="p-6 space-y-6" id="userForm">
                @csrf

                <!-- Role Selection -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-blue-50 transition"
                        id="role-admin"
                        :class="selectedRole === 'Admin' ? 'border-blue-500 bg-blue-50' : 'border-gray-200'">
                        <input type="radio" name="role" value="Admin" class="role-input" required>
                        <span class="ml-2 font-medium text-gray-900">Admin</span>
                    </label>
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-blue-50 transition"
                        id="role-dokter"
                        :class="selectedRole === 'Dokter' ? 'border-blue-500 bg-blue-50' : 'border-gray-200'">
                        <input type="radio" name="role" value="Dokter" class="role-input" required>
                        <span class="ml-2 font-medium text-gray-900">Dokter</span>
                    </label>
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-blue-50 transition"
                        id="role-petugas"
                        :class="selectedRole === 'Petugas' ? 'border-blue-500 bg-blue-50' : 'border-gray-200'">
                        <input type="radio" name="role" value="Petugas" class="role-input" required>
                        <span class="ml-2 font-medium text-gray-900">Petugas</span>
                    </label>
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-blue-50 transition"
                        id="role-pasien"
                        :class="selectedRole === 'Pasien' ? 'border-blue-500 bg-blue-50' : 'border-gray-200'">
                        <input type="radio" name="role" value="Pasien" class="role-input" required>
                        <span class="ml-2 font-medium text-gray-900">Pasien</span>
                    </label>
                </div>

                @error('role')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                <!-- Basic User Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t">
                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" />
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror" />
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" id="password" name="password" required
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 @enderror" />
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                            Password <span class="text-red-500">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password_confirmation') border-red-500 @enderror" />
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Dokter Specific Fields -->
                <div id="dokter-fields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t">
                    <div class="md:col-span-2">
                        <h3 class="font-medium text-gray-900 mb-4">Data Dokter</h3>
                    </div>
                    <div>
                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nip') border-red-500 @enderror" />
                        @error('nip')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="spesialisasi" class="block text-sm font-medium text-gray-700">Spesialisasi <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="spesialisasi" name="spesialisasi" value="{{ old('spesialisasi') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('spesialisasi') border-red-500 @enderror" />
                        @error('spesialisasi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="dokter_no_telp" class="block text-sm font-medium text-gray-700">No. Telepon <span
                                class="text-red-500">*</span></label>
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
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir <span
                                class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_lahir') border-red-500 @enderror" />
                        @error('tanggal_lahir')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin <span
                                class="text-red-500">*</span></label>
                        <select id="jenis_kelamin" name="jenis_kelamin"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('jenis_kelamin') border-red-500 @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>
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
                        <label for="pasien_no_telp" class="block text-sm font-medium text-gray-700">No. Telepon <span
                                class="text-red-500">*</span></label>
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
