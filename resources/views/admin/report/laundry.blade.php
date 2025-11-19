<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Laporan Laundry</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="text-xs text-gray-600">Tanggal Dari</label>
                        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full border rounded px-2 py-1">
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Tanggal Sampai</label>
                        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full border rounded px-2 py-1">
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Status</label>
                        <select name="status" class="w-full border rounded px-2 py-1">
                            <option value="">Semua</option>
                            @foreach(['Draf','Diproses','Selesai','Dibatalkan'] as $s)
                                <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-1 flex items-end gap-2">
                        <button class="px-3 py-2 bg-blue-600 text-white rounded">Terapkan</button>
                        <a href="{{ request()->fullUrlWithQuery(['format'=>'csv']) }}" class="px-3 py-2 bg-green-600 text-white rounded">Export CSV</a>
                        <a href="{{ request()->fullUrlWithQuery(['format'=>'pdf']) }}" class="px-3 py-2 bg-red-600 text-white rounded">Export PDF</a>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded shadow overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Tanggal Masuk</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Unit</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Item</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Jenis</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Jumlah</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Berat (kg)</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($items as $i)
                            <tr>
                                <td class="px-4 py-2 text-sm">{{ optional($i->tanggal_masuk)->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2 text-sm">{{ $i->unit }}</td>
                                <td class="px-4 py-2 text-sm">{{ $i->item }}</td>
                                <td class="px-4 py-2 text-sm">{{ $i->jenis }}</td>
                                <td class="px-4 py-2 text-sm">{{ $i->jumlah }}</td>
                                <td class="px-4 py-2 text-sm">{{ $i->berat_kg }}</td>
                                <td class="px-4 py-2 text-sm">{{ $i->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-sm text-gray-500 text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-3">{{ $items->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>