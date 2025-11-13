<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Tambah Data Poli</h2>
            <p class="mt-1 text-sm text-gray-500">Daftarkan poli/poliklinik baru</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.poli.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode Poli -->
                    <div>
                        <label for="kode_poli" class="block text-sm font-medium text-gray-700">Kode Poli <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="kode_poli" name="kode_poli" required
                            value="{{ old('kode_poli') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('kode_poli') border-red-500 @enderror" />
                        @error('kode_poli')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Poli -->
                    <div>
                        <label for="nama_poli" class="block text-sm font-medium text-gray-700">Nama Poli <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="nama_poli" name="nama_poli" required
                            value="{{ old('nama_poli') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nama_poli') border-red-500 @enderror" />
                        @error('nama_poli')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi"
                            value="{{ old('lokasi') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('lokasi') border-red-500 @enderror" />
                        @error('lokasi')
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
                            <option value="aktif" @selected(old('status') == 'aktif')>Aktif</option>
                            <option value="tidak_aktif" @selected(old('status') == 'tidak_aktif')>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                        class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-6 border-t">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route('admin.poli.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

