<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Data Dokter</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap dokter</p>
            </div>
            <div class="space-x-2">
                <a href="{{ route('admin.dokter.edit', $dokter) }}"
                    class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 inline-block">
                    Edit
                </a>
                <a href="{{ route('admin.dokter.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 inline-block">
                    Kembali
                </a>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-600">Nama</dt>
                    <dd class="text-lg text-gray-900">{{ $dokter->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Email</dt>
                    <dd class="text-lg text-gray-900">{{ $dokter->user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">NIP</dt>
                    <dd class="text-lg text-gray-900">{{ $dokter->nip }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Spesialisasi</dt>
                    <dd class="text-lg text-gray-900">{{ $dokter->spesialisasi }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">No. Telepon</dt>
                    <dd class="text-lg text-gray-900">{{ $dokter->no_telp }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-600">Role</dt>
                    <dd class="text-lg text-gray-900">
                        @foreach ($dokter->user->roles as $role)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Timestamps -->
        <div class="mt-6 text-sm text-gray-500 space-y-1">
            <p>Dibuat: {{ $dokter->created_at->format('d/m/Y H:i:s') }}</p>
            <p>Diperbarui: {{ $dokter->updated_at->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</x-app-layout>

