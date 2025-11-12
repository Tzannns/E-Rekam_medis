<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Tambah Data IGD</h2>
            <p class="mt-1 text-sm text-gray-500">Daftarkan pasien baru ke IGD</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.igd.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Pasien -->
                    <div>
                        <label for="pasien_id" class="block text-sm font-medium text-gray-700">Pasien <span
                                class="text-red-500">*</span></label>
                        <select id="pasien_id" name="pasien_id" required
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('pasien_id') border-red-500 @enderror">
                            <option value="">-- Pilih Pasien --</option>
                            @foreach ($pasiens as $pasien)
                                <option value="{{ $pasien->id }}" @selected(old('pasien_id') == $pasien->id)>
                                    {{ $pasien->user->name }} ({{ $pasien->nik }})
                                </option>
                            @endforeach
                        </select>
                        @error('pasien_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dokter -->
                    <div>
                        <label for="dokter_id" class="block text-sm font-medium text-gray-700">Dokter</label>
                        <select id="dokter_id" name="dokter_id"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('dokter_id') border-red-500 @enderror">
                            <option value="">-- Pilih Dokter (Opsional) --</option>
                            @foreach ($dokters as $dokter)
                                <option value="{{ $dokter->id }}" @selected(old('dokter_id') == $dokter->id)>
                                    {{ $dokter->user->name }} ({{ $dokter->spesialisasi }})
                                </option>
                            @endforeach
                        </select>
                        @error('dokter_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Masuk -->
                    <div>
                        <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700">Tanggal Masuk <span
                                class="text-red-500">*</span></label>
                        <input type="datetime-local" id="tanggal_masuk" name="tanggal_masuk" required
                            value="{{ old('tanggal_masuk', now()->format('Y-m-d\TH:i')) }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_masuk') border-red-500 @enderror" />
                        @error('tanggal_masuk')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Keluar -->
                    <div>
                        <label for="tanggal_keluar" class="block text-sm font-medium text-gray-700">Tanggal
                            Keluar</label>
                        <input type="datetime-local" id="tanggal_keluar" name="tanggal_keluar"
                            value="{{ old('tanggal_keluar') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_keluar') border-red-500 @enderror" />
                        @error('tanggal_keluar')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Triase Level -->
                    <div>
                        <label for="triase_level" class="block text-sm font-medium text-gray-700">Level Triase <span
                                class="text-red-500">*</span></label>
                        <select id="triase_level" name="triase_level" required
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('triase_level') border-red-500 @enderror">
                            <option value="">-- Pilih Level --</option>
                            <option value="Hijau" @selected(old('triase_level') == 'Hijau')>Hijau (Non-Urgent)</option>
                            <option value="Kuning" @selected(old('triase_level') == 'Kuning')>Kuning (Urgent)</option>
                            <option value="Merah" @selected(old('triase_level') == 'Merah')>Merah (Emergency)</option>
                            <option value="Hitam" @selected(old('triase_level') == 'Hitam')>Hitam (Deceased)</option>
                        </select>
                        @error('triase_level')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status <span
                                class="text-red-500">*</span></label>
                        <select id="status" name="status" required
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="Menunggu" @selected(old('status') == 'Menunggu')>Menunggu</option>
                            <option value="Sedang Ditangani" @selected(old('status') == 'Sedang Ditangani')>Sedang Ditangani</option>
                            <option value="Selesai" @selected(old('status') == 'Selesai')>Selesai</option>
                            <option value="Dirujuk" @selected(old('status') == 'Dirujuk')>Dirujuk</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Keluhan Utama -->
                <div>
                    <label for="keluhan_utama" class="block text-sm font-medium text-gray-700">Keluhan Utama <span
                            class="text-red-500">*</span></label>
                    <textarea id="keluhan_utama" name="keluhan_utama" required rows="3"
                        class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('keluhan_utama') border-red-500 @enderror">{{ old('keluhan_utama') }}</textarea>
                    @error('keluhan_utama')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan -->
                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="3"
                        class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-6 border-t">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route('admin.igd.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
