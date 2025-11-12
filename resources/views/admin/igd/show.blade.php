<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Data IGD</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap kunjungan pasien IGD</p>
            </div>
            <div class="space-x-2">
                @can('igd.edit')
                    <a href="{{ route('admin.igd.edit', $igd) }}"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 inline-block">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('admin.igd.index') }}"
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
                        <dd class="text-lg text-gray-900">{{ $igd->pasien->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">NIK</dt>
                        <dd class="text-lg text-gray-900">{{ $igd->pasien->nik }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Tanggal Lahir</dt>
                        <dd class="text-lg text-gray-900">{{ $igd->pasien->tanggal_lahir->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Jenis Kelamin</dt>
                        <dd class="text-lg text-gray-900">{{ ucfirst($igd->pasien->jenis_kelamin) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Alamat</dt>
                        <dd class="text-lg text-gray-900">{{ $igd->pasien->alamat }}</dd>
                    </div>
                    @if ($igd->pasien->no_telp)
                        <div>
                            <dt class="text-sm font-medium text-gray-600">No. Telepon</dt>
                            <dd class="text-lg text-gray-900">{{ $igd->pasien->no_telp }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Informasi IGD -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi IGD</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Dokter</dt>
                        <dd class="text-lg text-gray-900">{{ $igd->dokter->user->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Tanggal Masuk</dt>
                        <dd class="text-lg text-gray-900">{{ $igd->tanggal_masuk->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Tanggal Keluar</dt>
                        <dd class="text-lg text-gray-900">
                            @if ($igd->tanggal_keluar)
                                {{ $igd->tanggal_keluar->format('d/m/Y H:i') }}
                            @else
                                <span class="text-gray-500">Belum keluar</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Level Triase</dt>
                        <dd>
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if ($igd->triase_level === 'Merah') bg-red-100 text-red-800
                                @elseif ($igd->triase_level === 'Kuning') bg-yellow-100 text-yellow-800
                                @elseif ($igd->triase_level === 'Hitam') bg-gray-100 text-gray-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ $igd->triase_level }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Status</dt>
                        <dd>
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if ($igd->status === 'Selesai') bg-green-100 text-green-800
                                @elseif ($igd->status === 'Sedang Ditangani') bg-blue-100 text-blue-800
                                @elseif ($igd->status === 'Dirujuk') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $igd->status }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Keluhan dan Catatan -->
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Keluhan Utama</h3>
            <p class="text-gray-700 whitespace-pre-line">{{ $igd->keluhan_utama }}</p>
        </div>

        @if ($igd->catatan)
            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h3>
                <p class="text-gray-700 whitespace-pre-line">{{ $igd->catatan }}</p>
            </div>
        @endif

        <!-- Timestamps -->
        <div class="mt-6 text-sm text-gray-500 space-y-1">
            <p>Dibuat: {{ $igd->created_at->format('d/m/Y H:i:s') }}</p>
            <p>Diperbarui: {{ $igd->updated_at->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</x-app-layout>
