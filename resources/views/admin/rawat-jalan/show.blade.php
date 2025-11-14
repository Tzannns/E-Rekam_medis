<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Data Rawat Jalan</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap kunjungan pasien rawat jalan</p>
            </div>
            <div class="space-x-2">
                @can('rawat-jalan.edit')
                    <a href="{{ route('admin.rawat-jalan.edit', $rawatJalan) }}"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 inline-block">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('admin.rawat-jalan.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 inline-block">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informasi Pasien -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pasien</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Nama Pasien</dt>
                        <dd class="text-lg text-gray-900">{{ $rawatJalan->pasien->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">NIK</dt>
                        <dd class="text-lg text-gray-900">{{ $rawatJalan->pasien->nik }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Tanggal Lahir</dt>
                        <dd class="text-lg text-gray-900">{{ $rawatJalan->pasien->tanggal_lahir->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Jenis Kelamin</dt>
                        <dd class="text-lg text-gray-900">{{ ucfirst($rawatJalan->pasien->jenis_kelamin) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Alamat</dt>
                        <dd class="text-lg text-gray-900">{{ $rawatJalan->pasien->alamat }}</dd>
                    </div>
                    @if ($rawatJalan->pasien->no_telp)
                        <div>
                            <dt class="text-sm font-medium text-gray-600">No. Telepon</dt>
                            <dd class="text-lg text-gray-900">{{ $rawatJalan->pasien->no_telp }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Informasi Rawat Jalan -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Rawat Jalan</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Dokter</dt>
                        <dd class="text-lg text-gray-900">{{ $rawatJalan->dokter->user->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Poli</dt>
                        <dd class="text-lg text-gray-900">{{ $rawatJalan->poli->nama_poli ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Tanggal Kunjungan</dt>
                        <dd class="text-lg text-gray-900">{{ $rawatJalan->tanggal_kunjungan->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Status</dt>
                        <dd>
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if ($rawatJalan->status === 'Selesai') bg-green-100 text-green-800
                                @elseif ($rawatJalan->status === 'Sedang Diperiksa') bg-blue-100 text-blue-800
                                @elseif ($rawatJalan->status === 'Batal') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $rawatJalan->status }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Keluhan -->
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Keluhan</h3>
            <p class="text-gray-700 whitespace-pre-line">{{ $rawatJalan->keluhan }}</p>
        </div>

        @if ($rawatJalan->diagnosa)
            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Diagnosa</h3>
                <p class="text-gray-700 whitespace-pre-line">{{ $rawatJalan->diagnosa }}</p>
            </div>
        @endif

        @if ($rawatJalan->tindakan)
            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan</h3>
                <p class="text-gray-700 whitespace-pre-line">{{ $rawatJalan->tindakan }}</p>
            </div>
        @endif

        @if ($rawatJalan->resep_obat)
            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resep Obat</h3>
                <p class="text-gray-700 whitespace-pre-line">{{ $rawatJalan->resep_obat }}</p>
            </div>
        @endif

        @if ($rawatJalan->catatan)
            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h3>
                <p class="text-gray-700 whitespace-pre-line">{{ $rawatJalan->catatan }}</p>
            </div>
        @endif

        <!-- Timestamps -->
        <div class="mt-6 text-sm text-gray-500 space-y-1">
            <p>Dibuat: {{ $rawatJalan->created_at->format('d/m/Y H:i:s') }}</p>
            <p>Diperbarui: {{ $rawatJalan->updated_at->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</x-app-layout>

