<x-app-layout>
    <div>
        @php($prefix = \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'petugas.') ? 'petugas' : 'admin')
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">{{ $obat->nama_obat }}</h2>
                <p class="mt-1 text-sm text-gray-500">Kode: {{ $obat->kode_obat }}</p>
            </div>
            <div class="flex space-x-3">
                @can('obat.edit')
                    <a href="{{ route($prefix . '.apotik.obat.edit', $obat) }}"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                        Edit
                    </a>
                @endcan
                @can('obat.delete')
                    <form action="{{ route($prefix . '.apotik.obat.destroy', $obat) }}" method="POST" class="delete-form"
                        style="display:inline;" data-name="{{ $obat->nama_obat }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Hapus
                        </button>
                    </form>
                @endcan
                <a href="{{ route($prefix . '.apotik.obat.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Kembali
                </a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Utama -->
            <div class="lg:col-span-2 bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Obat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kode Obat</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $obat->kode_obat }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nama Obat</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $obat->nama_obat }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kategori</label>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ $obat->kategori }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Satuan</label>
                            <p class="text-gray-900">{{ $obat->satuan }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Apotik</label>
                            <p class="text-gray-900">{{ $obat->apotik->nama_apotik }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Supplier</label>
                            <p class="text-gray-900">{{ $obat->supplier->nama_supplier ?? '-' }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi</label>
                            <p class="text-gray-900">{{ $obat->deskripsi ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Stok -->
            <div class="space-y-6">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status & Stok</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full
                                @if ($obat->status === 'Tersedia') bg-green-100 text-green-800
                                @elseif($obat->status === 'Habis') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $obat->status }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Stok Saat Ini</label>
                            <p class="text-2xl font-bold text-gray-900">{{ $obat->stok }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Stok Minimum</label>
                            <p class="text-gray-900">{{ $obat->stok_minimum }}</p>
                            @if ($obat->stok <= $obat->stok_minimum)
                                <p class="mt-1 text-sm text-red-600 font-medium">⚠️ Stok Rendah!</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Harga</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Harga Beli</label>
                            <p class="text-lg font-semibold text-gray-900">Rp
                                {{ number_format($obat->harga_beli, 0, ',', '.') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Harga Jual</label>
                            <p class="text-lg font-semibold text-green-600">Rp
                                {{ number_format($obat->harga_jual, 0, ',', '.') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Margin</label>
                            <p class="text-gray-900">Rp
                                {{ number_format($obat->harga_jual - $obat->harga_beli, 0, ',', '.') }}
                                ({{ number_format((($obat->harga_jual - $obat->harga_beli) / $obat->harga_beli) * 100, 1) }}%)
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Tambahan -->
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tambahan</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">No Batch</label>
                    <p class="text-gray-900">{{ $obat->no_batch ?? '-' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Kadaluarsa</label>
                    <p class="text-gray-900">
                        {{ $obat->tanggal_kadaluarsa ? $obat->tanggal_kadaluarsa->format('d/m/Y') : '-' }}
                    </p>
                    @if ($obat->tanggal_kadaluarsa && $obat->tanggal_kadaluarsa->isPast())
                        <p class="mt-1 text-sm text-red-600 font-medium">⚠️ Sudah Kadaluarsa!</p>
                    @elseif($obat->tanggal_kadaluarsa && $obat->tanggal_kadaluarsa->diffInDays(now()) <= 30)
                        <p class="mt-1 text-sm text-yellow-600 font-medium">⚠️ Akan Kadaluarsa</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Dibuat</label>
                    <p class="text-gray-900">{{ $obat->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Terakhir Update</label>
                    <p class="text-gray-900">{{ $obat->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Riwayat Stok -->
        @if ($obat->stokObats->isNotEmpty())
            <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Stok (10 Terakhir)</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok
                                        Akhir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($obat->stokObats->take(10) as $stok)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $stok->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full
                                                @if ($stok->tipe === 'Masuk') bg-green-100 text-green-800
                                                @elseif($stok->tipe === 'Keluar') bg-red-100 text-red-800
                                                @else bg-blue-100 text-blue-800 @endif">
                                                {{ $stok->tipe }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium
                                            @if (in_array($stok->tipe, ['Masuk', 'Retur'])) text-green-600
                                            @else text-red-600 @endif">
                                            {{ in_array($stok->tipe, ['Masuk', 'Retur']) ? '+' : '-' }}{{ $stok->jumlah }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $stok->stok_sesudah }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $stok->keterangan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
