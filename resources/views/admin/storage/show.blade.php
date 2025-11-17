<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">{{ $storage->nama_barang }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $storage->kode_barang }}</p>
            </div>
            <div class="space-x-3">
                <a href="{{ route('admin.storage.edit', $storage) }}"
                    class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition inline-block">
                    Edit
                </a>
                <a href="{{ route('admin.storage.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition inline-block">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- Informasi Barang -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Barang</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Kategori</p>
                            <p class="text-sm text-gray-900 mt-1">{{ $storage->kategori }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Supplier</p>
                            <p class="text-sm text-gray-900 mt-1">{{ $storage->supplier ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Nomor Batch</p>
                            <p class="text-sm text-gray-900 mt-1">{{ $storage->nomor_batch ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Lokasi</p>
                            <p class="text-sm text-gray-900 mt-1">{{ $storage->lokasi ?? '-' }}</p>
                        </div>
                    </div>
                    @if ($storage->deskripsi)
                        <div class="mt-4 pt-4 border-t">
                            <p class="text-xs font-medium text-gray-500 uppercase">Deskripsi</p>
                            <p class="text-sm text-gray-900 mt-1">{{ $storage->deskripsi }}</p>
                        </div>
                    @endif
                </div>

                <!-- Stok dan Harga -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Stok dan Harga</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Stok Awal</p>
                            <p class="text-sm text-gray-900 mt-1">{{ $storage->stok_awal }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Stok Saat Ini</p>
                            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $storage->stok_saat_ini }}
                                {{ $storage->satuan }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Stok Minimal</p>
                            <p class="text-sm text-gray-900 mt-1">{{ $storage->stok_minimal }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Harga Satuan</p>
                            <p class="text-sm text-gray-900 mt-1">Rp
                                {{ number_format($storage->harga_satuan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-xs font-medium text-gray-500 uppercase">Total Nilai</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">Rp
                            {{ number_format($storage->total_nilai, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Lokasi dan Tanggal -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Lokasi dan Tanggal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Tanggal Masuk</p>
                            <p class="text-sm text-gray-900 mt-1">{{ $storage->tanggal_masuk->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Tanggal Kadaluarsa</p>
                            @if ($storage->tanggal_kadaluarsa)
                                <p class="text-sm text-gray-900 mt-1">
                                    {{ $storage->tanggal_kadaluarsa->format('d/m/Y') }}
                                    @if ($storage->is_kadaluarsa)
                                        <span
                                            class="ml-2 px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded">KADALUARSA</span>
                                    @endif
                                </p>
                            @else
                                <p class="text-sm text-gray-500 mt-1">-</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Status Barang</p>
                            <p class="mt-1">
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-full
                                    @if ($storage->status === 'Aktif') bg-green-100 text-green-800
                                    @elseif ($storage->status === 'Nonaktif') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $storage->status }}
                                </span>
                            </p>
                        </div>
                        <div class="pt-3 border-t">
                            <p class="text-xs font-medium text-gray-500 uppercase">Status Stok</p>
                            <p class="mt-1">
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-full
                                    @if ($storage->stok_status === 'Normal') bg-green-100 text-green-800
                                    @elseif ($storage->stok_status === 'Rendah') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    ● {{ $storage->stok_status }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Sistem -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sistem</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Dibuat Pada</p>
                            <p class="text-gray-900 mt-1">{{ $storage->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Diperbarui Pada</p>
                            <p class="text-gray-900 mt-1">{{ $storage->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
