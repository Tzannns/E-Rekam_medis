<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Edit Barang Storage</h2>
            <p class="mt-1 text-sm text-gray-500">{{ $storage->kode_barang }} - {{ $storage->nama_barang }}</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.storage.update', $storage) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode Barang (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang</label>
                        <input type="text" value="{{ $storage->kode_barang }}" disabled
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 bg-gray-50 text-gray-600" />
                    </div>

                    <!-- Nama Barang -->
                    <div>
                        <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="nama_barang" name="nama_barang" required
                            value="{{ old('nama_barang', $storage->nama_barang) }}"
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
                            <option value="Obat" @selected($storage->kategori === 'Obat')>Obat</option>
                            <option value="Alat Medis" @selected($storage->kategori === 'Alat Medis')>Alat Medis</option>
                            <option value="Consumable" @selected($storage->kategori === 'Consumable')>Consumable</option>
                            <option value="Lainnya" @selected($storage->kategori === 'Lainnya')>Lainnya</option>
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Supplier -->
                    <div>
                        <label for="supplier" class="block text-sm font-medium text-gray-700">Supplier</label>
                        <input type="text" id="supplier" name="supplier"
                            value="{{ old('supplier', $storage->supplier) }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('supplier') border-red-500 @enderror" />
                        @error('supplier')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok Awal (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                        <input type="text" value="{{ $storage->stok_awal }}" disabled
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 bg-gray-50 text-gray-600" />
                    </div>

                    <!-- Stok Saat Ini -->
                    <div>
                        <label for="stok_saat_ini" class="block text-sm font-medium text-gray-700">Stok Saat Ini <span
                                class="text-red-500">*</span></label>
                        <input type="number" id="stok_saat_ini" name="stok_saat_ini" required
                            value="{{ old('stok_saat_ini', $storage->stok_saat_ini) }}" min="0"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('stok_saat_ini') border-red-500 @enderror" />
                        @error('stok_saat_ini')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok Minimal -->
                    <div>
                        <label for="stok_minimal" class="block text-sm font-medium text-gray-700">Stok Minimal <span
                                class="text-red-500">*</span></label>
                        <input type="number" id="stok_minimal" name="stok_minimal" required
                            value="{{ old('stok_minimal', $storage->stok_minimal) }}" min="0"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('stok_minimal') border-red-500 @enderror" />
                        @error('stok_minimal')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label for="satuan" class="block text-sm font-medium text-gray-700">Satuan <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="satuan" name="satuan" required
                            value="{{ old('satuan', $storage->satuan) }}"
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
                            value="{{ old('harga_satuan', $storage->harga_satuan) }}" step="0.01" min="0"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('harga_satuan') border-red-500 @enderror" />
                        @error('harga_satuan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi Penyimpanan</label>
                        <input type="text" id="lokasi" name="lokasi"
                            value="{{ old('lokasi', $storage->lokasi) }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('lokasi') border-red-500 @enderror" />
                        @error('lokasi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Batch (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Batch</label>
                        <input type="text" value="{{ $storage->nomor_batch ?? '-' }}" disabled
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 bg-gray-50 text-gray-600" />
                    </div>

                    <!-- Tanggal Kadaluarsa -->
                    <div>
                        <label for="tanggal_kadaluarsa" class="block text-sm font-medium text-gray-700">Tanggal
                            Kadaluarsa</label>
                        <input type="date" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa"
                            value="{{ old('tanggal_kadaluarsa', $storage->tanggal_kadaluarsa?->format('Y-m-d')) }}"
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
                            <option value="Aktif" @selected($storage->status === 'Aktif')>Aktif</option>
                            <option value="Nonaktif" @selected($storage->status === 'Nonaktif')>Nonaktif</option>
                            <option value="Kadaluarsa" @selected($storage->status === 'Kadaluarsa')>Kadaluarsa</option>
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
                        class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $storage->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-6 border-t">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.storage.show', $storage) }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
