<x-app-layout>
    <div>
        @php($prefix = \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'petugas.') ? 'petugas' : 'admin')
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Data Gizi</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi makanan dan nutrisi pasien</p>
            </div>
            <div class="space-x-2">
                <a href="{{ route($prefix . '.gizi.edit', $gizi) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 inline-block">Edit</a>
                <a href="{{ route($prefix . '.gizi.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-600 inline-block">Kembali</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Gizi</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Pasien</dt>
                        <dd class="text-lg text-gray-900">{{ $gizi->pasien->nama ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Tanggal</dt>
                        <dd class="text-lg text-gray-900">{{ optional($gizi->tanggal)->format('d/m/Y') ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Jenis Makanan</dt>
                        <dd class="text-lg text-gray-900">{{ $gizi->jenis_makanan ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Jumlah</dt>
                        <dd class="text-lg text-gray-900">{{ $gizi->jumlah ?? '-' }} porsi</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Status</dt>
                        <dd class="text-lg text-gray-900">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if (($gizi->status ?? '') === 'diberikan') bg-green-100 text-green-800
                                @elseif (($gizi->status ?? '') === 'pending') bg-yellow-100 text-yellow-800
                                @elseif (($gizi->status ?? '') === 'ditolak') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($gizi->status ?? '-') }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Catatan</dt>
                        <dd class="text-lg text-gray-900">{{ $gizi->catatan ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                <form action="{{ route($prefix . '.gizi.destroy', $gizi) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>