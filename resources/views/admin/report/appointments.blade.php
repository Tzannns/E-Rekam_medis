<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Laporan Antrian Online</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
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
                            @foreach(['Menunggu','Diproses','Selesai','Dibatalkan'] as $s)
                                <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Poli</label>
                        <select name="poli_id" class="w-full border rounded px-2 py-1">
                            <option value="">Semua</option>
                            @foreach($polis as $p)
                                <option value="{{ $p->id }}" {{ (string)request('poli_id')===(string)$p->id?'selected':'' }}>{{ $p->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Dokter</label>
                        <select name="dokter_id" class="w-full border rounded px-2 py-1">
                            <option value="">Semua</option>
                            @foreach($dokters as $d)
                                <option value="{{ $d->id }}" {{ (string)request('dokter_id')===(string)$d->id?'selected':'' }}>{{ $d->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-5 flex items-center gap-2 mt-2">
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
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Tanggal</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Jam</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Poli</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Dokter</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Pasien</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">No</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($appointments as $a)
                            <tr>
                                <td class="px-4 py-2 text-sm">{{ optional($a->tanggal_usulan)->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 text-sm">{{ $a->jam_usulan }}</td>
                                <td class="px-4 py-2 text-sm">{{ optional($a->poli)->nama_poli }}</td>
                                <td class="px-4 py-2 text-sm">{{ optional(optional($a->dokter)->user)->name }}</td>
                                <td class="px-4 py-2 text-sm">{{ optional(optional($a->pasien)->user)->name }}</td>
                                <td class="px-4 py-2 text-sm">{{ $a->nomor_antrian }}</td>
                                <td class="px-4 py-2 text-sm">{{ $a->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-sm text-gray-500 text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-3">{{ $appointments->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>