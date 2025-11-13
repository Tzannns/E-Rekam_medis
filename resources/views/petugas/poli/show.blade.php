<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Poli</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap poli/poliklinik</p>
            </div>
            <a href="{{ route('petugas.poli.index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 inline-block">
                Kembali
            </a>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-600">Kode Poli</dt>
                    <dd class="text-lg text-gray-900">{{ $poli->kode_poli }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Nama Poli</dt>
                    <dd class="text-lg text-gray-900">{{ $poli->nama_poli }}</dd>
                </div>
                @if ($poli->lokasi)
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Lokasi</dt>
                        <dd class="text-lg text-gray-900">{{ $poli->lokasi }}</dd>
                    </div>
                @endif
                @if ($poli->deskripsi)
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Deskripsi</dt>
                        <dd class="text-lg text-gray-900 whitespace-pre-line">{{ $poli->deskripsi }}</dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</x-app-layout>

