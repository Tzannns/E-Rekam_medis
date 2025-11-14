<x-app-layout>
    <div class="max-w-4xl">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Rawat Inap</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap rawat inap pasien</p>
            </div>
            <div class="flex gap-3">
                @can('rawat-inap.edit')
                    <a href="{{ route('admin.rawat-inap.edit', $rawatInap) }}"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('admin.rawat-inap.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
                    Kembali
                </a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informasi Pasien -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Pasien</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama</p>
                        <p class="text-lg font-medium text-gray-900">{{ $rawatInap->pasien->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">NIK</p>
                        <p class="text-lg font-medium text-gray-900">{{ $rawatInap->pasien->nik }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jenis Kelamin</p>
                        <p class="text-lg font-medium text-gray-900">
                            {{ $rawatInap->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Lahir</p>
                        <p class="text-lg font-medium text-gray-900">
                            {{ $rawatInap->pasien->tanggal_lahir->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">No Telepon</p>
                        <p class="text-lg font-medium text-gray-900">{{ $rawatInap->pasien->no_telp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="text-lg font-medium text-gray-900">{{ $rawatInap->pasien->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Rawat Inap -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Rawat Inap</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Dokter</p>
                        <p class="text-lg font-medium text-gray-900">
                            {{ $rawatInap->dokter->user->name ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Masuk</p>
                        <p class="text-lg font-medium text-gray-900">{{ $rawatInap->tanggal_masuk->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Keluar</p>
                        <p class="text-lg font-medium text-gray-900">
                            {{ $rawatInap->tanggal_keluar ? $rawatInap->tanggal_keluar->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Ruang</p>
                        <p class="text-lg font-medium text-gray-900">{{ $rawatInap->ruang }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">No Tempat Tidur</p>
                        <p class="text-lg font-medium text-gray-900">{{ $rawatInap->no_tempat_tidur }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <p>
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if ($rawatInap->status === 'Selesai') bg-green-100 text-green-800
                                @elseif ($rawatInap->status === 'Sedang Dirawat') bg-blue-100 text-blue-800
                                @elseif ($rawatInap->status === 'Dirujuk') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $rawatInap->status }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diagnosa & Catatan -->
        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Diagnosa & Catatan</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Diagnosa</p>
                    <p class="text-gray-900 whitespace-pre-line">{{ $rawatInap->diagnosa }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Catatan Tambahan</p>
                    <p class="text-gray-900 whitespace-pre-line">{{ $rawatInap->catatan ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Timestamps -->
        <div class="mt-6 text-xs text-gray-500 text-center">
            <p>Dibuat: {{ $rawatInap->created_at->format('d/m/Y H:i') }} | Diperbarui:
                {{ $rawatInap->updated_at->format('d/m/Y H:i') }}</p>
        </div>

        @can('rawat-inap.delete')
            <div class="mt-6 border-t pt-6">
                <form action="{{ route('admin.rawat-inap.destroy', $rawatInap) }}" method="POST"
                    class="delete-form inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        Hapus Data
                    </button>
                </form>
            </div>
        @endcan
    </div>

    @include('components.sweet-alert')
</x-app-layout>
