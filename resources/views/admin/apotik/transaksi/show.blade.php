<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Transaksi</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $transaksi->no_transaksi }}</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="window.print()"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Cetak
                </button>
                <a href="{{ route('admin.apotik.transaksi.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Transaksi -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Transaksi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">No Transaksi</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $transaksi->no_transaksi }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal & Waktu</label>
                            <p class="text-gray-900">{{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Apotik</label>
                            <p class="text-gray-900">{{ $transaksi->apotik->nama_apotik }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kasir</label>
                            <p class="text-gray-900">{{ $transaksi->user->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tipe Pembeli</label>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ $transaksi->tipe_pembeli }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Pembeli</label>
                            <p class="text-gray-900">
                                @if ($transaksi->tipe_pembeli === 'Pasien' && $transaksi->pasien)
                                    {{ $transaksi->pasien->nama }}
                                @else
                                    {{ $transaksi->nama_pembeli ?? '-' }}
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Metode Pembayaran</label>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $transaksi->metode_pembayaran }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full
                                @if ($transaksi->status === 'Selesai') bg-green-100 text-green-800
                                @elseif($transaksi->status === 'Pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $transaksi->status }}
                            </span>
                        </div>

                        @if ($transaksi->catatan)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Catatan</label>
                                <p class="text-gray-900">{{ $transaksi->catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Detail Obat -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Obat</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Obat
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Jumlah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($transaksi->details as $detail)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $detail->obat->nama_obat }}</div>
                                                <div class="text-sm text-gray-500">{{ $detail->obat->kode_obat }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $detail->jumlah }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Pembayaran -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pembayaran</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
                    </div>

                    @if ($transaksi->diskon > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Diskon</span>
                            <span class="font-medium text-red-600">- Rp
                                {{ number_format($transaksi->diskon, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    @if ($transaksi->pajak > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Pajak</span>
                            <span class="font-medium">Rp {{ number_format($transaksi->pajak, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="border-t pt-3 flex justify-between">
                        <span class="font-semibold text-lg">Total</span>
                        <span class="font-bold text-xl text-blue-600">Rp
                            {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                    </div>

                    <div class="border-t pt-3 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bayar</span>
                            <span class="font-medium">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kembalian</span>
                            <span class="font-bold text-green-600">Rp
                                {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            button,
            a {
                display: none !important;
            }
        }
    </style>
</x-app-layout>
