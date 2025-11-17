<x-app-layout>
    <div>
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.apotik.index') }}" class="text-blue-600 hover:text-blue-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-bold text-gray-900">{{ $apotik->nama_apotik }}</h2>
                <p class="mt-1 text-sm text-gray-500">Kode: {{ $apotik->kode_apotik }}</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="col-span-2 space-y-6">
                <!-- Informasi Apotik -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Apotik</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nama Apotik</label>
                            <p class="text-gray-900 mt-1">{{ $apotik->nama_apotik }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Kode Apotik</label>
                            <p class="text-gray-900 mt-1">{{ $apotik->kode_apotik }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Lokasi</label>
                            <p class="text-gray-900 mt-1">{{ $apotik->lokasi ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Kontak -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kontak</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Telepon</label>
                            <p class="text-gray-900 mt-1">{{ $apotik->telepon ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Email</label>
                            <p class="text-gray-900 mt-1">{{ $apotik->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Status</h3>
                    <span
                        class="px-3 py-1 text-sm font-semibold rounded-full
                        @if ($apotik->status === 'Aktif') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $apotik->status }}
                    </span>
                </div>

                <!-- Informasi Sistem -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Informasi Sistem</h3>
                    <div class="space-y-3 text-xs">
                        <div>
                            <label class="text-gray-500">Dibuat</label>
                            <p class="text-gray-900 mt-1">{{ $apotik->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-gray-500">Terakhir Diperbarui</label>
                            <p class="text-gray-900 mt-1">{{ $apotik->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-2">
                    @can('apotik.edit')
                        <a href="{{ route('admin.apotik.edit', $apotik) }}"
                            class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center font-medium text-sm">
                            Edit
                        </a>
                    @endcan
                    @can('apotik.delete')
                        <form action="{{ route('admin.apotik.destroy', $apotik) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus apotik ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="block w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">
                                Hapus
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
