<x-app-layout>
    <div>
        @php($prefix = \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'petugas.') ? 'petugas' : 'admin')
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Manajemen Apotik</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola data apotik dan informasi farmasi</p>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route($prefix . '.apotik.index') }}"
                    class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 font-medium text-sm">
                    Data Apotik
                </a>
                <a href="{{ route($prefix . '.apotik.supplier.index') }}"
                    class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 font-medium text-sm">
                    Supplier
                </a>
                <a href="{{ route($prefix . '.apotik.obat.index') }}"
                    class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 font-medium text-sm">
                    Data Obat
                </a>
                <a href="{{ route($prefix . '.apotik.stok.index') }}"
                    class="border-b-2 border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 font-medium text-sm">
                    Stok Obat
                </a>
                <a href="{{ route($prefix . '.apotik.transaksi.index') }}"
                    class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 font-medium text-sm">
                    Transaksi
                </a>
            </nav>
        </div>

        <div class="mb-6 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Riwayat Stok Obat</h3>
            </div>
            <a href="{{ route($prefix . '.apotik.stok.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Kelola Stok
            </a>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <p>{{ $message }}</p>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <p>{{ $message }}</p>
            </div>
        @endif

        <!-- Search and Filter -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6 p-6">
            <form method="GET" action="{{ route($prefix . '.apotik.stok.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama obat..."
                            class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                        <select name="tipe"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="semua">Semua Tipe</option>
                            <option value="Masuk" {{ request('tipe') === 'Masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="Keluar" {{ request('tipe') === 'Keluar' ? 'selected' : '' }}>Keluar</option>
                            <option value="Retur" {{ request('tipe') === 'Retur' ? 'selected' : '' }}>Retur</option>
                            <option value="Adjustment" {{ request('tipe') === 'Adjustment' ? 'selected' : '' }}>
                                Adjustment</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Filter
                    </button>
                    <a href="{{ route($prefix . '.apotik.stok.index') }}"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Obat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stok Sebelum</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stok Sesudah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($stokObats as $stok)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $stok->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $stok->obat->nama_obat }}</div>
                                    <div class="text-sm text-gray-500">{{ $stok->obat->kode_obat }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if ($stok->tipe === 'Masuk') bg-green-100 text-green-800
                                        @elseif($stok->tipe === 'Keluar') bg-red-100 text-red-800
                                        @elseif($stok->tipe === 'Retur') bg-yellow-100 text-yellow-800
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
                                    {{ $stok->stok_sebelum }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $stok->stok_sesudah }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $stok->user->name }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                    Tidak ada riwayat stok
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $stokObats->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>
