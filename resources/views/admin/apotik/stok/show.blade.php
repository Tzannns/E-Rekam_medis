<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Riwayat Stok</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap pergerakan stok</p>
            </div>
            <a href="{{ route('admin.apotik.stok.index') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Transaksi -->
            <div class="lg:col-span-2 bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Transaksi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal & Waktu</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $stok->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tipe Transaksi</label>
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full
                                @if ($stok->tipe === 'Masuk') bg-green-100 text-green-800
                                @elseif($stok->tipe === 'Keluar') bg-red-100 text-red-800
                                @elseif($stok->tipe === 'Retur') bg-yellow-100 text-yellow-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ $stok->tipe }}
                            </span>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Obat</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $stok->obat->nama_obat }}</p>
                            <p class="text-sm text-gray-500">{{ $stok->obat->kode_obat }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Petugas</label>
                            <p class="text-gray-900">{{ $stok->user->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">No Referensi</label>
                            <p class="text-gray-900">{{ $stok->no_referensi ?? '-' }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Keterangan</label>
                            <p class="text-gray-900">{{ $stok->keterangan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perubahan Stok -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Perubahan Stok</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Stok Sebelum</label>
                        <p class="text-2xl font-bold text-gray-900">{{ $stok->stok_sebelum }}</p>
                    </div>

                    <div class="flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                            </path>
                        </svg>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jumlah</label>
                        <p class="text-2xl font-bold
                            @if (in_array($stok->tipe, ['Masuk', 'Retur'])) text-green-600
                            @else text-red-600 @endif">
                            {{ in_array($stok->tipe, ['Masuk', 'Retur']) ? '+' : '-' }}{{ $stok->jumlah }}
                        </p>
                    </div>

                    <div class="flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                            </path>
                        </svg>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Stok Sesudah</label>
                        <p class="text-2xl font-bold text-blue-600">{{ $stok->stok_sesudah }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Obat Saat Ini -->
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Obat Saat Ini</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Stok Saat Ini</label>
                    <p class="text-2xl font-bold text-gray-900">{{ $stok->obat->stok }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Stok Minimum</label>
                    <p class="text-gray-900">{{ $stok->obat->stok_minimum }}</p>
                    @if ($stok->obat->stok <= $stok->obat->stok_minimum)
                        <p class="mt-1 text-sm text-red-600 font-medium">⚠️ Stok Rendah!</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                    <span
                        class="px-3 py-1 text-sm font-semibold rounded-full
                        @if ($stok->obat->status === 'Tersedia') bg-green-100 text-green-800
                        @elseif($stok->obat->status === 'Habis') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $stok->obat->status }}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Harga Jual</label>
                    <p class="text-gray-900">Rp {{ number_format($stok->obat->harga_jual, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
