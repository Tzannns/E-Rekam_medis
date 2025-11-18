<x-app-layout>
    <div>
        @php($prefix = \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'petugas.') ? 'petugas' : 'admin')
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Hasil Lab</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi pemeriksaan laboratorium</p>
            </div>
            <div class="space-x-2">
                <a href="{{ route($prefix . '.laboratorium.edit', $lab) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 inline-block">Edit</a>
                <a href="{{ route($prefix . '.laboratorium.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-600 inline-block">Kembali</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">            
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Data</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Tanggal Periksa</dt>
                        <dd class="text-lg text-gray-900">{{ optional($lab->tanggal_periksa)->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Pasien</dt>
                        <dd class="text-lg text-gray-900">{{ $lab->pasien->user->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Dokter</dt>
                        <dd class="text-lg text-gray-900">{{ $lab->dokter->user->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Jenis Pemeriksaan</dt>
                        <dd class="text-lg text-gray-900">{{ $lab->jenis_pemeriksaan }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Nilai Rujukan</dt>
                        <dd class="text-lg text-gray-900">{{ $lab->nilai_rujukan ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Satuan</dt>
                        <dd class="text-lg text-gray-900">{{ $lab->satuan ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Status</dt>
                        <dd class="text-lg text-gray-900">{{ $lab->status }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Hasil</dt>
                        <dd class="text-lg text-gray-900 whitespace-pre-line">{{ $lab->hasil ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Catatan</dt>
                        <dd class="text-lg text-gray-900">{{ $lab->catatan ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                <form action="{{ route($prefix . '.laboratorium.destroy', $lab) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    @include('components.sweet-alert')
</x-app-layout>