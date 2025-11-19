<x-app-layout>
    <div>
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Detail Rawat Inap</h2>
                    <p class="mt-1 text-sm text-gray-500">Informasi lengkap pasien rawat inap</p>
                </div>
                <a href="{{ route('dokter.rawat-inap.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informasi Pasien -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Pasien</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">NIK</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $rawatInap->pasien->nik }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama Pasien</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $rawatInap->pasien->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Tanggal Lahir</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $rawatInap->pasien->tanggal_lahir->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $rawatInap->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Alamat</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $rawatInap->pasien->alamat }}</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Rawat Inap -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Rawat Inap</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Ruang</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $rawatInap->ruang }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">No. Tempat Tidur</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $rawatInap->no_tempat_tidur }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Tanggal Masuk</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $rawatInap->tanggal_masuk->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Tanggal Keluar</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $rawatInap->tanggal_keluar ? $rawatInap->tanggal_keluar->format('d M Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        <p class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($rawatInap->status == 'dirawat') bg-blue-100 text-blue-800
                                @elseif($rawatInap->status == 'pulang') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($rawatInap->status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Diagnosa -->
            <div class="bg-white shadow rounded-lg lg:col-span-2">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Diagnosa</h3>
                </div>
                <div class="px-6 py-4">
                    <p class="text-sm text-gray-900">{{ $rawatInap->diagnosa }}</p>
                </div>
            </div>

            <!-- Catatan -->
            @if($rawatInap->catatan)
            <div class="bg-white shadow rounded-lg lg:col-span-2">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Catatan</h3>
                </div>
                <div class="px-6 py-4">
                    <p class="text-sm text-gray-900">{{ $rawatInap->catatan }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
