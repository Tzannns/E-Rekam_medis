<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Data Rawat Jalan</h2>
                <p class="mt-1 text-sm text-gray-500">Kelola data kunjungan pasien rawat jalan</p>
            </div>
            @can('rawat-jalan.create')
                <a href="{{ route('admin.rawat-jalan.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    + Tambah Rawat Jalan
                </a>
            @endcan
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pasien</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dokter</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Poli</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Kunjungan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($rawatJalans as $rawatJalan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $rawatJalan->pasien->user->name ?? '-' }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $rawatJalan->pasien->nik ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $rawatJalan->dokter->user->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $rawatJalan->poli->nama_poli ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $rawatJalan->tanggal_kunjungan->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if ($rawatJalan->status === 'Selesai') bg-green-100 text-green-800
                                        @elseif ($rawatJalan->status === 'Sedang Diperiksa') bg-blue-100 text-blue-800
                                        @elseif ($rawatJalan->status === 'Batal') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $rawatJalan->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-3 flex">
                                    <a href="{{ route('admin.rawat-jalan.show', $rawatJalan) }}" title="Lihat"
                                        class="text-blue-600 hover:text-blue-900 hover:scale-110 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                    @can('rawat-jalan.edit')
                                        <a href="{{ route('admin.rawat-jalan.edit', $rawatJalan) }}" title="Edit"
                                            class="text-yellow-600 hover:text-yellow-900 hover:scale-110 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                    @endcan
                                    @can('rawat-jalan.delete')
                                        <form action="{{ route('admin.rawat-jalan.destroy', $rawatJalan) }}" method="POST"
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
                                    Belum ada data Rawat Jalan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $rawatJalans->links() }}
            </div>
        </div>
    </div>

    @include('components.sweet-alert')
</x-app-layout>

