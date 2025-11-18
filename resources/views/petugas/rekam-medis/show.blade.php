<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Rekam Medis</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap rekam medis</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('petugas.rekam-medis.edit', $rekamMedi) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit
                </a>
                <a href="{{ route('petugas.rekam-medis.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Kembali
                </a>
            </div>
        </div>

        <div class="max-w-4xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Tanggal Periksa</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $rekamMedi->tanggal_periksa->format('d M Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Pasien</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $rekamMedi->pasien->user->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Dokter</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $rekamMedi->dokter->user->name }}</p>
                        </div>
                    </div>

                    @if ($rekamMedi->keluhan)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Keluhan</h3>
                            <p class="mt-1 text-gray-900">{{ $rekamMedi->keluhan }}</p>
                        </div>
                    @endif

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Diagnosa</h3>
                        <p class="mt-1 text-gray-900">{{ $rekamMedi->diagnosa }}</p>
                    </div>

                    @if ($rekamMedi->tindakan)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Tindakan</h3>
                            <p class="mt-1 text-gray-900">{{ $rekamMedi->tindakan }}</p>
                        </div>
                    @endif

                    @if ($rekamMedi->resep_obat)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Resep Obat</h3>
                            <p class="mt-1 text-gray-900">{{ $rekamMedi->resep_obat }}</p>
                        </div>
                    @endif

                    @if ($rekamMedi->catatan)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Catatan</h3>
                            <p class="mt-1 text-gray-900">{{ $rekamMedi->catatan }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
