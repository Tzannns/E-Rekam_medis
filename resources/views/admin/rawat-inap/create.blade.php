<x-app-layout>
    <div class="max-w-2xl">
        @php($prefix = \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'petugas.') ? 'petugas' : 'admin')
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Tambah Rawat Inap</h2>
            <p class="mt-1 text-sm text-gray-500">Buat data pasien rawat inap baru</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route($prefix . '.rawat-inap.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Pasien -->
                <div>
                    <label for="pasien_id" class="block text-sm font-medium text-gray-700">Pasien <span
                            class="text-red-500">*</span></label>
                    <select id="pasien_id" name="pasien_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('pasien_id') border-red-500 @else border @endif">
                        <option value="">Pilih Pasien</option>
                        @foreach ($pasiens as $pasien)
                            <option value="{{ $pasien->id }}"
                                {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>
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
                    <label for="dokter_id"
                        class="block text-sm font-medium text-gray-700">Dokter</label>
                        <select id="dokter_id" name="dokter_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('dokter_id') border-red-500 @else border @endif">
                        <option value="">Pilih Dokter (Opsional)</option>
                        @foreach ($dokters as $dokter)
                            <option value="{{ $dokter->id }}"
                                {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
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
                    <label for="tanggal_masuk"
                            class="block text-sm font-medium text-gray-700">Tanggal Masuk <span
                                class="text-red-500">*</span></label>
                            <input type="date" id="tanggal_masuk" name="tanggal_masuk" required
                                value="{{ old('tanggal_masuk') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_masuk') border-red-500 @else border @endif">
                    @error('tanggal_masuk')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Keluar -->
                <div>
                    <label for="tanggal_keluar"
                                class="block text-sm font-medium text-gray-700">Tanggal Keluar</label>
                            <input type="date" id="tanggal_keluar" name="tanggal_keluar"
                                value="{{ old('tanggal_keluar') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_keluar') border-red-500 @else border @endif">
                    @error('tanggal_keluar')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ruang -->
                <div>
                    <label for="ruang"
                                class="block text-sm font-medium text-gray-700">Ruang <span
                                class="text-red-500">*</span></label>
                            <select id="ruang" name="ruang" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('ruang') border-red-500 @else border @endif">
                        <option value="">Pilih Ruang</option>
                        <option value="ICU" {{ old('ruang') == 'ICU' ? 'selected' : '' }}>ICU</option>
                        <option value="Bersalin" {{ old('ruang') == 'Bersalin' ? 'selected' : '' }}>Bersalin</option>
                        <option value="Anak" {{ old('ruang') == 'Anak' ? 'selected' : '' }}>Anak</option>
                        <option value="Bedah" {{ old('ruang') == 'Bedah' ? 'selected' : '' }}>Bedah</option>
                        <option value="Penyakit Dalam" {{ old('ruang') == 'Penyakit Dalam' ? 'selected' : '' }}>
                            Penyakit Dalam</option>
                    </select>
                    @error('ruang')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Tempat Tidur -->
                <div>
                    <label for="no_tempat_tidur"
                                class="block text-sm font-medium text-gray-700">No Tempat Tidur <span
                                    class="text-red-500">*</span></label>
                                <input type="text" id="no_tempat_tidur" name="no_tempat_tidur" required
                                    value="{{ old('no_tempat_tidur') }}" placeholder="Contoh: 101, 102A"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('no_tempat_tidur') border-red-500 @else @endif">
                    @error('no_tempat_tidur')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Diagnosa -->
                <div>
                    <label for="diagnosa"
                                    class="block text-sm font-medium text-gray-700">Diagnosa <span
                                    class="text-red-500">*</span></label>
                                <textarea id="diagnosa" name="diagnosa" required rows="4"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('diagnosa') border-red-500 @else @endif"
                        placeholder="Masukkan diagnosa medis">{{ old('diagnosa') }}</textarea>
                    @error('diagnosa')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status"
                                    class="block text-sm font-medium text-gray-700">Status <span
                            class="text-red-500">*</span></label>
                    <select id="status" name="status" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-500 @else border @endif">
                        <option value="">Pilih Status</option>
                        <option value="Menunggu" {{ old('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu
                        </option>
                        <option value="Sedang Dirawat" {{ old('status') == 'Sedang Dirawat' ? 'selected' : '' }}>
                            Sedang Dirawat</option>
                        <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dirujuk" {{ old('status') == 'Dirujuk' ? 'selected' : '' }}>Dirujuk</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan -->
                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="3"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('catatan') border-red-500 @else @endif"
                        placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route($prefix . '.rawat-inap.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Load pasiens dan dokters on page load
        document.addEventListener('DOMContentLoaded', function() {
            const pasienSelect = document.getElementById('pasien_id');
            const dokterSelect = document.getElementById('dokter_id');

            if (pasienSelect) {
                pasienSelect.focus();
            }
        });
    </script>
</x-app-layout>
