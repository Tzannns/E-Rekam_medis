<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Edit Obat</h2>
            <p class="mt-1 text-sm text-gray-500">Edit data obat</p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.apotik.obat.update', $obat) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="apotik_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Apotik <span class="text-red-500">*</span>
                        </label>
                        <select name="apotik_id" id="apotik_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('apotik_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Apotik</option>
                            @foreach ($apotiks as $apotik)
                                <option value="{{ $apotik->id }}"
                                    {{ old('apotik_id', $obat->apotik_id) == $apotik->id ? 'selected' : '' }}>
                                    {{ $apotik->nama_apotik }}
                                </option>
                            @endforeach
                        </select>
                        @error('apotik_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Supplier
                        </label>
                        <select name="supplier_id" id="supplier_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('supplier_id') border-red-500 @enderror">
                            <option value="">Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id', $obat->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Obat
                        </label>
                        <input type="text" value="{{ $obat->kode_obat }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" disabled>
                    </div>

                    <div>
                        <label for="nama_obat" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Obat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_obat" id="nama_obat"
                            value="{{ old('nama_obat', $obat->nama_obat) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_obat') border-red-500 @enderror"
                            required>
                        @error('nama_obat')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="kategori" id="kategori"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kategori') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Kategori</option>
                            <option value="Tablet"
                                {{ old('kategori', $obat->kategori) === 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Kapsul"
                                {{ old('kategori', $obat->kategori) === 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                            <option value="Sirup" {{ old('kategori', $obat->kategori) === 'Sirup' ? 'selected' : '' }}>
                                Sirup</option>
                            <option value="Salep" {{ old('kategori', $obat->kategori) === 'Salep' ? 'selected' : '' }}>
                                Salep</option>
                            <option value="Cairan"
                                {{ old('kategori', $obat->kategori) === 'Cairan' ? 'selected' : '' }}>Cairan</option>
                            <option value="Injeksi"
                                {{ old('kategori', $obat->kategori) === 'Injeksi' ? 'selected' : '' }}>Injeksi</option>
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="satuan" class="block text-sm font-medium text-gray-700 mb-2">
                            Satuan <span class="text-red-500">*</span>
                        </label>
                        <select name="satuan" id="satuan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('satuan') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Satuan</option>
                            <option value="Strip" {{ old('satuan', $obat->satuan) === 'Strip' ? 'selected' : '' }}>
                                Strip</option>
                            <option value="Box" {{ old('satuan', $obat->satuan) === 'Box' ? 'selected' : '' }}>Box
                            </option>
                            <option value="Botol" {{ old('satuan', $obat->satuan) === 'Botol' ? 'selected' : '' }}>
                                Botol</option>
                            <option value="Tube" {{ old('satuan', $obat->satuan) === 'Tube' ? 'selected' : '' }}>Tube
                            </option>
                            <option value="Ampul" {{ old('satuan', $obat->satuan) === 'Ampul' ? 'selected' : '' }}>
                                Ampul</option>
                            <option value="Vial" {{ old('satuan', $obat->satuan) === 'Vial' ? 'selected' : '' }}>Vial
                            </option>
                        </select>
                        @error('satuan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $obat->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="harga_beli" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Beli <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="harga_beli" id="harga_beli"
                            value="{{ old('harga_beli', $obat->harga_beli) }}" min="0" step="0.01"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('harga_beli') border-red-500 @enderror"
                            required>
                        @error('harga_beli')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Jual <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="harga_jual" id="harga_jual"
                            value="{{ old('harga_jual', $obat->harga_jual) }}" min="0" step="0.01"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('harga_jual') border-red-500 @enderror"
                            required>
                        @error('harga_jual')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Stok Saat Ini
                        </label>
                        <input type="text" value="{{ $obat->stok }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" disabled>
                        <p class="mt-1 text-xs text-gray-500">Gunakan menu Kelola Stok untuk mengubah stok</p>
                    </div>

                    <div>
                        <label for="stok_minimum" class="block text-sm font-medium text-gray-700 mb-2">
                            Stok Minimum <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stok_minimum" id="stok_minimum"
                            value="{{ old('stok_minimum', $obat->stok_minimum) }}" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stok_minimum') border-red-500 @enderror"
                            required>
                        @error('stok_minimum')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_kadaluarsa" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kadaluarsa
                        </label>
                        <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa"
                            value="{{ old('tanggal_kadaluarsa', $obat->tanggal_kadaluarsa?->format('Y-m-d')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_kadaluarsa') border-red-500 @enderror">
                        @error('tanggal_kadaluarsa')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_batch" class="block text-sm font-medium text-gray-700 mb-2">
                            No Batch
                        </label>
                        <input type="text" name="no_batch" id="no_batch"
                            value="{{ old('no_batch', $obat->no_batch) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_batch') border-red-500 @enderror">
                        @error('no_batch')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror"
                            required>
                            <option value="Tersedia"
                                {{ old('status', $obat->status) === 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Habis" {{ old('status', $obat->status) === 'Habis' ? 'selected' : '' }}>Habis
                            </option>
                            <option value="Kadaluarsa"
                                {{ old('status', $obat->status) === 'Kadaluarsa' ? 'selected' : '' }}>Kadaluarsa
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.apotik.obat.show', $obat) }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
