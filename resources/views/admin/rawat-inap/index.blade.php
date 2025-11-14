<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Data Rawat Inap</h2>
                <p class="mt-1 text-sm text-gray-500">Kelola data pasien rawat inap di rumah sakit</p>
            </div>
            @can('rawat-inap.create')
                <a href="{{ route('admin.rawat-inap.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    + Tambah Rawat Inap
                </a>
            @endcan
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <p>{{ $message }}</p>
            </div>
        @endif

        <!-- Search and Filter -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-6 p-6">
            <form method="GET" action="{{ route('admin.rawat-inap.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, diagnosa, ruang..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pasien</label>
                        <select name="pasien_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border">
                            <option value="">Semua Pasien</option>
                            @foreach ($pasienList as $pasien)
                                <option value="{{ $pasien->id }}"
                                    {{ request('pasien_id') == $pasien->id ? 'selected' : '' }}>
                                    {{ $pasien->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dokter</label>
                        <select name="dokter_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border">
                            <option value="">Semua Dokter</option>
                            @foreach ($dokterList as $dokter)
                                <option value="{{ $dokter->id }}"
                                    {{ request('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                    {{ $dokter->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ruang</label>
                        <select name="ruang"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border">
                            <option value="">Semua Ruang</option>
                            <option value="ICU" {{ request('ruang') == 'ICU' ? 'selected' : '' }}>ICU</option>
                            <option value="Bersalin" {{ request('ruang') == 'Bersalin' ? 'selected' : '' }}>Bersalin
                            </option>
                            <option value="Anak" {{ request('ruang') == 'Anak' ? 'selected' : '' }}>Anak</option>
                            <option value="Bedah" {{ request('ruang') == 'Bedah' ? 'selected' : '' }}>Bedah</option>
                            <option value="Penyakit Dalam"
                                {{ request('ruang') == 'Penyakit Dalam' ? 'selected' : '' }}>Penyakit Dalam</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border">
                            <option value="">Semua Status</option>
                            <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="Sedang Dirawat"
                                {{ request('status') == 'Sedang Dirawat' ? 'selected' : '' }}>Sedang Dirawat</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="Dirujuk" {{ request('status') == 'Dirujuk' ? 'selected' : '' }}>Dirujuk
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dari</label>
                        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sampai</label>
                        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border">
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Filter
                    </button>
                    <a href="{{ route('admin.rawat-inap.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Reset
                    </a>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dokter</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ruang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($rawatInaps as $rawatInap)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $rawatInap->pasien->user->name ?? '-' }}
                                </div>
                                <div class="text-sm text-gray-500">{{ $rawatInap->pasien->nik ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $rawatInap->dokter->user->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $rawatInap->ruang }} / {{ $rawatInap->no_tempat_tidur }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $rawatInap->tanggal_masuk->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if ($rawatInap->status === 'Selesai') bg-green-100 text-green-800
                                        @elseif ($rawatInap->status === 'Sedang Dirawat') bg-blue-100 text-blue-800
                                        @elseif ($rawatInap->status === 'Dirujuk') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                    {{ $rawatInap->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-3 flex">
                                <a href="{{ route('admin.rawat-inap.show', $rawatInap) }}" title="Lihat"
                                    class="text-blue-600 hover:text-blue-900 hover:scale-110 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </a>
                                @can('rawat-inap.edit')
                                    <a href="{{ route('admin.rawat-inap.edit', $rawatInap) }}" title="Edit"
                                        class="text-yellow-600 hover:text-yellow-900 hover:scale-110 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                @endcan
                                @can('rawat-inap.delete')
                                    <form action="{{ route('admin.rawat-inap.destroy', $rawatInap) }}" method="POST"
                                        class="delete-form inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus"
                                            class="text-red-600 hover:text-red-900 hover:scale-110 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data Rawat Inap
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $rawatInaps->links() }}
        </div>
    </div>
    </div>

    @include('components.sweet-alert')
</x-app-layout>
