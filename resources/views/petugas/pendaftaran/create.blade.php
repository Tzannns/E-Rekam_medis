<x-app-layout>
    <div>
        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Terjadi kesalahan!
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Pendaftaran Pasien Baru</h2>
                <p class="mt-1 text-sm text-gray-500">Daftarkan pasien baru ke sistem</p>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('petugas.pendaftaran.store') }}" method="POST" class="px-6 py-4"
                id="registrationForm">
                @csrf

                <!-- Nama -->
                <div class="mb-6">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" name="nama" id="nama"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama') border-red-500 @enderror"
                        value="{{ old('nama') }}" required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIK -->
                <div class="mb-6">
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK (16 Digit)</label>
                    <div class="relative">
                        <input type="text" name="nik" id="nik" inputmode="numeric" maxlength="16"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nik') border-red-500 @enderror"
                            value="{{ old('nik') }}" placeholder="Contoh: 3201010101900001" required
                            autocomplete="off">
                        <span class="absolute right-4 top-3 text-xs text-gray-500" id="nikCounter">0/16</span>
                    </div>
                    @error('nik')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Masukkan 16 digit angka saja (tanpa spasi atau karakter lain)
                    </p>
                </div>

                <!-- Alamat -->
                <div class="mb-6">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('alamat') border-red-500 @enderror"
                        required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div class="mb-6">
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                        Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_lahir') border-red-500 @enderror"
                        value="{{ old('tanggal_lahir') }}" required>
                    @error('tanggal_lahir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-6">
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis
                        Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jenis_kelamin') border-red-500 @enderror"
                        required>
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div class="mb-6">
                    <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="tel" name="no_telp" id="no_telp"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('no_telp') border-red-500 @enderror"
                        value="{{ old('no_telp') }}" placeholder="Contoh: 081234567890" maxlength="20">
                    @error('no_telp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Opsional - maksimal 20 karakter</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" id="submitBtn"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium disabled:bg-blue-400 disabled:cursor-not-allowed"
                        data-loading-text="Menyimpan...">
                        Daftar
                    </button>
                    <a href="{{ route('petugas.pendaftaran.index') }}"
                        class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Real-time NIK counter
        const nikInput = document.getElementById('nik');
        const nikCounter = document.getElementById('nikCounter');

        nikInput.addEventListener('input', function(e) {
            // Only allow digits
            const value = e.target.value.replace(/\D/g, '');
            e.target.value = value;

            // Update counter
            nikCounter.textContent = value.length + '/16';

            // Change color based on length
            if (value.length === 16) {
                nikCounter.classList.remove('text-gray-500');
                nikCounter.classList.add('text-green-600', 'font-medium');
            } else if (value.length > 0) {
                nikCounter.classList.remove('text-green-600', 'font-medium');
                nikCounter.classList.add('text-gray-500');
            } else {
                nikCounter.classList.remove('text-green-600', 'font-medium');
                nikCounter.classList.add('text-gray-500');
            }
        });

        // Form submit validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const nikValue = nikInput.value.trim();
            const submitBtn = document.getElementById('submitBtn');

            // Validate NIK length
            if (nikValue.length !== 16) {
                e.preventDefault();
                alert('NIK harus terdiri dari 16 digit!');
                nikInput.focus();
                return false;
            }

            // Validate NIK is numeric only
            if (!/^\d+$/.test(nikValue)) {
                e.preventDefault();
                alert('NIK hanya boleh berisi angka!');
                nikInput.focus();
                return false;
            }

            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.textContent = submitBtn.getAttribute('data-loading-text');
        });

        // Re-enable button if user navigates back
        window.addEventListener('pageshow', function(e) {
            if (e.persisted) {
                document.getElementById('submitBtn').disabled = false;
                document.getElementById('submitBtn').textContent = 'Daftar';
            }
        });
    </script>
</x-app-layout>
