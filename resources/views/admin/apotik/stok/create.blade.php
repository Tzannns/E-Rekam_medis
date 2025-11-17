<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Kelola Stok Obat</h2>
            <p class="mt-1 text-sm text-gray-500">Tambah atau kurangi stok obat</p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.apotik.stok.store') }}" method="POST" x-data="stokForm()">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="obat_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Obat <span class="text-red-500">*</span>
                        </label>
                        <select name="obat_id" id="obat_id" x-model="obatId" @change="updateStokInfo()"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('obat_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Obat</option>
                            @foreach ($obats as $obat)
                                <option value="{{ $obat->id }}" data-stok="{{ $obat->stok }}"
                                    data-nama="{{ $obat->nama_obat }}" data-kode="{{ $obat->kode_obat }}"
                                    {{ old('obat_id') == $obat->id ? 'selected' : '' }}>
                                    {{ $obat->kode_obat }} - {{ $obat->nama_obat }} (Stok: {{ $obat->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('obat_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Stok Saat Ini -->
                    <div class="md:col-span-2" x-show="obatId">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-blue-800 font-medium">Stok Saat Ini</p>
                                    <p class="text-2xl font-bold text-blue-900" x-text="stokSekarang"></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-blue-800 font-medium">Stok Setelah Transaksi</p>
                                    <p class="text-2xl font-bold" :class="stokAkhir >= 0 ? 'text-green-600' : 'text-red-600'"
                                        x-text="stokAkhir"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="tipe" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipe Transaksi <span class="text-red-500">*</span>
                        </label>
                        <select name="tipe" id="tipe" x-model="tipe" @change="calculateStok()"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tipe') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Tipe</option>
                            <option value="Masuk" {{ old('tipe') === 'Masuk' ? 'selected' : '' }}>Masuk (Tambah Stok)
                            </option>
                            <option value="Keluar" {{ old('tipe') === 'Keluar' ? 'selected' : '' }}>Keluar (Kurangi
                                Stok)</option>
                            <option value="Retur" {{ old('tipe') === 'Retur' ? 'selected' : '' }}>Retur (Tambah Stok)
                            </option>
                            <option value="Adjustment" {{ old('tipe') === 'Adjustment' ? 'selected' : '' }}>Adjustment
                            </option>
                        </select>
                        @error('tipe')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="jumlah" id="jumlah" x-model="jumlah" @input="calculateStok()"
                            value="{{ old('jumlah') }}" min="1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jumlah') border-red-500 @enderror"
                            required>
                        @error('jumlah')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500" x-show="tipe === 'Keluar' && jumlah > stokSekarang">
                            <span class="text-red-600 font-medium">⚠️ Jumlah melebihi stok yang tersedia!</span>
                        </p>
                    </div>

                    <div>
                        <label for="no_referensi" class="block text-sm font-medium text-gray-700 mb-2">
                            No Referensi
                        </label>
                        <input type="text" name="no_referensi" id="no_referensi" value="{{ old('no_referensi') }}"
                            placeholder="PO-001, INV-001, dll"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_referensi') border-red-500 @enderror">
                        @error('no_referensi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                            Keterangan
                        </label>
                        <textarea name="keterangan" id="keterangan" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.apotik.stok.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function stokForm() {
            return {
                obatId: '{{ old('obat_id') }}',
                tipe: '{{ old('tipe') }}',
                jumlah: {{ old('jumlah', 0) }},
                stokSekarang: 0,
                stokAkhir: 0,

                updateStokInfo() {
                    const select = document.getElementById('obat_id');
                    const option = select.options[select.selectedIndex];
                    if (option.value) {
                        this.stokSekarang = parseInt(option.dataset.stok) || 0;
                        this.calculateStok();
                    }
                },

                calculateStok() {
                    if (!this.obatId || !this.tipe || !this.jumlah) {
                        this.stokAkhir = this.stokSekarang;
                        return;
                    }

                    const jumlah = parseInt(this.jumlah) || 0;

                    if (this.tipe === 'Masuk' || this.tipe === 'Retur') {
                        this.stokAkhir = this.stokSekarang + jumlah;
                    } else if (this.tipe === 'Keluar') {
                        this.stokAkhir = this.stokSekarang - jumlah;
                    } else {
                        this.stokAkhir = this.stokSekarang;
                    }
                },

                init() {
                    if (this.obatId) {
                        this.updateStokInfo();
                    }
                }
            }
        }
    </script>
</x-app-layout>
