<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Edit Data User</h2>
            <p class="mt-1 text-sm text-gray-500">Update data user</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.user-management.update', $user) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Current Role Information -->
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm text-gray-700">
                        <span class="font-medium">Role Saat Ini:</span>
                        @forelse ($user->roles as $role)
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-medium ml-2
                                {{ $role->name === 'Admin' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $role->name === 'Dokter' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $role->name === 'Petugas' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $role->name === 'Pasien' ? 'bg-purple-100 text-purple-800' : '' }}
                            ">
                                {{ $role->name }}
                            </span>
                        @empty
                            <span class="text-gray-500 ml-2">Tidak ada role</span>
                        @endforelse
                    </p>
                </div>

                <!-- Basic User Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t">
                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" required
                            value="{{ old('name', $user->name) }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" />
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" required
                            value="{{ old('email', $user->email) }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror" />
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru
                            <span class="text-gray-500 text-xs">(Kosongkan jika tidak ingin mengubah)</span></label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 @enderror" />
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                            Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password_confirmation') border-red-500 @enderror" />
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Dokter Specific Fields -->
                @if ($user->dokter)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t">
                        <div class="md:col-span-2">
                            <h3 class="font-medium text-gray-900 mb-4">Data Dokter</h3>
                        </div>
                        <div>
                            <label for="nip" class="block text-sm font-medium text-gray-700">NIP <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="nip" name="nip"
                                value="{{ old('nip', $user->dokter->nip) }}"
                                class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nip') border-red-500 @enderror" />
                            @error('nip')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="spesialisasi" class="block text-sm font-medium text-gray-700">Spesialisasi <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="spesialisasi" name="spesialisasi"
                                value="{{ old('spesialisasi', $user->dokter->spesialisasi) }}"
                                class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('spesialisasi') border-red-500 @enderror" />
                            @error('spesialisasi')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="dokter_no_telp" class="block text-sm font-medium text-gray-700">No. Telepon
                                <span class="text-red-500">*</span></label>
                            <input type="text" id="dokter_no_telp" name="no_telp"
                                value="{{ old('no_telp', $user->dokter->no_telp) }}"
                                class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('no_telp') border-red-500 @enderror" />
                            @error('no_telp')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif

                <!-- Pasien Specific Fields -->
                @if ($user->pasien)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t">
                        <div class="md:col-span-2">
                            <h3 class="font-medium text-gray-900 mb-4">Data Pasien</h3>
                        </div>
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700">NIK <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="nik" name="nik"
                                value="{{ old('nik', $user->pasien->nik) }}"
                                class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nik') border-red-500 @enderror" />
                            @error('nik')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir
                                <span class="text-red-500">*</span></label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $user->pasien->tanggal_lahir?->format('Y-m-d')) }}"
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
                                    {{ old('jenis_kelamin', $user->pasien->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan"
                                    {{ old('jenis_kelamin', $user->pasien->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>
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
                                class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', $user->pasien->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="pasien_no_telp" class="block text-sm font-medium text-gray-700">No. Telepon
                                <span class="text-red-500">*</span></label>
                            <input type="text" id="pasien_no_telp" name="no_telp"
                                value="{{ old('no_telp', $user->pasien->no_telp) }}"
                                class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('no_telp') border-red-500 @enderror" />
                            @error('no_telp')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif

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
</x-app-layout>
