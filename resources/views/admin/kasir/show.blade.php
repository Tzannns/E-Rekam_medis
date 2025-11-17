<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">Detail Transaksi</h2>
                <p class="text-sm text-gray-500">Invoice {{ $kasir->nomor_invoice }}</p>
            </div>
            <a href="{{ route('admin.kasir.index') }}" class="text-indigo-600">Kembali</a>
        </div>

        <div class="bg-white shadow rounded p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="text-sm text-gray-500">Pasien</div>
                    <div class="font-medium">{{ $kasir->pasien?->user?->name }} (NIK {{ $kasir->pasien?->nik }})</div>
                    <div class="text-sm text-gray-500">Tanggal</div>
                    <div>{{ optional($kasir->tanggal)->format('Y-m-d H:i') }}</div>
                </div>
                <div class="text-right">
                    <div>Subtotal: Rp {{ number_format($kasir->subtotal,2,',','.') }}</div>
                    <div>Diskon: Rp {{ number_format($kasir->diskon,2,',','.') }}</div>
                    <div class="font-bold">Total: Rp {{ number_format($kasir->total,2,',','.') }}</div>
                    <div class="mt-2">Dibayar: Rp {{ number_format($dibayar,2,',','.') }}</div>
                    <div class="mt-1">Sisa: Rp {{ number_format($sisa,2,',','.') }}</div>
                    <div class="mt-1">Status: <span class="font-medium">{{ $kasir->status }}</span></div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded p-6 mb-6">
            <h3 class="font-medium mb-3">Item</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="px-3 py-2 text-left">Deskripsi</th>
                            <th class="px-3 py-2 text-right">Qty</th>
                            <th class="px-3 py-2 text-right">Harga</th>
                            <th class="px-3 py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kasir->items as $it)
                            <tr class="border-b">
                                <td class="px-3 py-2">{{ $it->deskripsi }}</td>
                                <td class="px-3 py-2 text-right">{{ $it->qty }}</td>
                                <td class="px-3 py-2 text-right">Rp {{ number_format($it->harga,2,',','.') }}</td>
                                <td class="px-3 py-2 text-right">Rp {{ number_format($it->total,2,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h3 class="font-medium mb-3">Pembayaran</h3>
            <div class="overflow-x-auto mb-4">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="px-3 py-2 text-left">Tanggal</th>
                            <th class="px-3 py-2 text-left">Metode</th>
                            <th class="px-3 py-2 text-right">Jumlah</th>
                            <th class="px-3 py-2 text-left">Referensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kasir->pembayaran as $pb)
                            <tr class="border-b">
                                <td class="px-3 py-2">{{ optional($pb->tanggal)->format('Y-m-d H:i') }}</td>
                                <td class="px-3 py-2">{{ $pb->metode }}</td>
                                <td class="px-3 py-2 text-right">Rp {{ number_format($pb->jumlah,2,',','.') }}</td>
                                <td class="px-3 py-2">{{ $pb->referensi }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-gray-500">Belum ada pembayaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($sisa > 0)
                <form method="POST" action="{{ route('admin.kasir.pembayaran.store', $kasir) }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    @csrf
                    <div>
                        <label class="block text-sm">Tanggal</label>
                        <input type="datetime-local" name="tanggal" class="border rounded w-full px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm">Metode</label>
                        <select name="metode" class="border rounded w-full px-3 py-2" required>
                            @foreach(['Tunai','Kartu','Transfer','BPJS'] as $mt)
                                <option value="{{ $mt }}">{{ $mt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm">Jumlah</label>
                        <input type="number" step="0.01" min="0.01" name="jumlah" class="border rounded w-full px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm">Referensi</label>
                        <input type="text" name="referensi" class="border rounded w-full px-3 py-2">
                    </div>
                    <div class="md:col-span-4">
                        <button type="submit" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded">Tambah Pembayaran</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>