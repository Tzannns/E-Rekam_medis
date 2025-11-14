<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Tambah Data Rawat Jalan</h2>
            <p class="mt-1 text-sm text-gray-500">Daftarkan pasien baru ke Rawat Jalan</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.rawat-jalan.store') }}" method="POST" class="p-6 space-y-6">
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

                    <!-- Poli -->
                    <div>
                        <label for="poli_id" class="block text-sm font-medium text-gray-700">Poli</label>
                        <select id="poli_id" name="poli_id"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('poli_id') border-red-500 @enderror">
                            <option value="">-- Pilih Poli (Opsional) --</option>
                            @foreach ($polis as $poli)
                                <option value="{{ $poli->id }}" @selected(old('poli_id') == $poli->id)>
                                    {{ $poli->nama_poli }}
                                </option>
                            @endforeach
                        </select>
                        @error('poli_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Kunjungan -->
                    <div>
                        <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700">Tanggal Kunjungan <span
                                class="text-red-500">*</span></label>
                        <input type="datetime-local" id="tanggal_kunjungan" name="tanggal_kunjungan" required
                            value="{{ old('tanggal_kunjungan', now()->format('Y-m-d\TH:i')) }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_kunjungan') border-red-500 @enderror" />
                        @error('tanggal_kunjungan')
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
                            <option value="Sedang Diperiksa" @selected(old('status') == 'Sedang Diperiksa')>Sedang Diperiksa</option>
                            <option value="Selesai" @selected(old('status') == 'Selesai')>Selesai</option>
                            <option value="Batal" @selected(old('status') == 'Batal')>Batal</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Keluhan -->
                <div>
                    <label for="keluhan" class="block text-sm font-medium text-gray-700">Keluhan <span
                            class="text-red-500">*</span></label>
                    <textarea id="keluhan" name="keluhan" required rows="3"
                        class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('keluhan') border-red-500 @enderror">{{ old('keluhan') }}</textarea>
                    @error('keluhan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Diagnosa -->
                <div>
                    <label for="diagnosa" class="block text-sm font-medium text-gray-700">Diagnosa</label>
                    <textarea id="diagnosa" name="diagnosa" rows="3"
                        class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('diagnosa') border-red-500 @enderror">{{ old('diagnosa') }}</textarea>
                    @error('diagnosa')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tindakan -->
                <div>
                    <label for="tindakan" class="block text-sm font-medium text-gray-700">Tindakan</label>
                    <textarea id="tindakan" name="tindakan" rows="3"
                        class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tindakan') border-red-500 @enderror">{{ old('tindakan') }}</textarea>
                    @error('tindakan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Resep Obat -->
                <div>
                    <label for="resep_obat" class="block text-sm font-medium text-gray-700">Resep Obat</label>
                    <textarea id="resep_obat" name="resep_obat" rows="3"
                        class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('resep_obat') border-red-500 @enderror">{{ old('resep_obat') }}</textarea>
                    @error('resep_obat')
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
                    <a href="{{ route('admin.rawat-jalan.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

