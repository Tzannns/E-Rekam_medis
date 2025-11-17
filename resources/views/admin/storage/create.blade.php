<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Tambah Barang Storage</h2>
            <p class="mt-1 text-sm text-gray-500">Daftarkan barang baru ke dalam gudang</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.storage.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode Barang -->
                    <div>
                        <label for="kode_barang" class="block text-sm font-medium text-gray-700">Kode Barang <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="kode_barang" name="kode_barang" required
                            value="{{ old('kode_barang') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('kode_barang') border-red-500 @enderror" />
                        @error('kode_barang')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Barang -->
                    <div>
                        <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="nama_barang" name="nama_barang" required
                            value="{{ old('nama_barang') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nama_barang') border-red-500 @enderror" />
                        @error('nama_barang')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori <span
                                class="text-red-500">*</span></label>
                        <select id="kategori" name="kategori" required
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('kategori') border-red-500 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Obat" @selected(old('kategori') == 'Obat')>Obat</option>
                            <option value="Alat Medis" @selected(old('kategori') == 'Alat Medis')>Alat Medis</option>
                            <option value="Consumable" @selected(old('kategori') == 'Consumable')>Consumable</option>
                            <option value="Lainnya" @selected(old('kategori') == 'Lainnya')>Lainnya</option>
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Supplier -->
                    <div>
                        <label for="supplier" class="block text-sm font-medium text-gray-700">Supplier</label>
                        <input type="text" id="supplier" name="supplier" value="{{ old('supplier') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('supplier') border-red-500 @enderror" />
                        @error('supplier')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok Awal -->
                    <div>
                        <label for="stok_awal" class="block text-sm font-medium text-gray-700">Stok Awal <span
                                class="text-red-500">*</span></label>
                        <input type="number" id="stok_awal" name="stok_awal" required value="{{ old('stok_awal', 0) }}"
                            min="0"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('stok_awal') border-red-500 @enderror" />
                        @error('stok_awal')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok Minimal -->
                    <div>
                        <label for="stok_minimal" class="block text-sm font-medium text-gray-700">Stok Minimal <span
                                class="text-red-500">*</span></label>
                        <input type="number" id="stok_minimal" name="stok_minimal" required
                            value="{{ old('stok_minimal', 10) }}" min="0"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('stok_minimal') border-red-500 @enderror" />
                        @error('stok_minimal')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label for="satuan" class="block text-sm font-medium text-gray-700">Satuan <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="satuan" name="satuan" required value="{{ old('satuan', 'Pcs') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('satuan') border-red-500 @enderror" />
                        @error('satuan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga Satuan -->
                    <div>
                        <label for="harga_satuan" class="block text-sm font-medium text-gray-700">Harga Satuan (Rp)
                            <span class="text-red-500">*</span></label>
                        <input type="number" id="harga_satuan" name="harga_satuan" required
                            value="{{ old('harga_satuan', 0) }}" step="0.01" min="0"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('harga_satuan') border-red-500 @enderror" />
                        @error('harga_satuan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi Penyimpanan</label>
                        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('lokasi') border-red-500 @enderror" />
                        @error('lokasi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Batch -->
                    <div>
                        <label for="nomor_batch" class="block text-sm font-medium text-gray-700">Nomor Batch</label>
                        <input type="text" id="nomor_batch" name="nomor_batch" value="{{ old('nomor_batch') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nomor_batch') border-red-500 @enderror" />
                        @error('nomor_batch')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Masuk -->
                    <div>
                        <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700">Tanggal Masuk <span
                                class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk" required
                            value="{{ old('tanggal_masuk', date('Y-m-d')) }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_masuk') border-red-500 @enderror" />
                        @error('tanggal_masuk')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Kadaluarsa -->
                    <div>
                        <label for="tanggal_kadaluarsa" class="block text-sm font-medium text-gray-700">Tanggal
                            Kadaluarsa</label>
                        <input type="date" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa"
                            value="{{ old('tanggal_kadaluarsa') }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tanggal_kadaluarsa') border-red-500 @enderror" />
                        @error('tanggal_kadaluarsa')
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
                            <option value="Aktif" @selected(old('status') == 'Aktif')>Aktif</option>
                            <option value="Nonaktif" @selected(old('status') == 'Nonaktif')>Nonaktif</option>
                            <option value="Kadaluarsa" @selected(old('status') == 'Kadaluarsa')>Kadaluarsa</option>
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
                    <a href="{{ route('admin.storage.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
