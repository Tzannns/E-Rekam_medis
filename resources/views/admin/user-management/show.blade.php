<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Data User</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi lengkap user</p>
            </div>
            <div class="space-x-2">
                <a href="{{ route('admin.user-management.edit', $user) }}"
                    class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 inline-block">
                    Edit
                </a>
                <a href="{{ route('admin.user-management.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 inline-block">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="md:col-span-2 bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Umum</h3>
                <dl class="space-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Nama</dt>
                        <dd class="text-lg text-gray-900">{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Email</dt>
                        <dd class="text-lg text-gray-900">{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Role</dt>
                        <dd class="text-lg">
                            @forelse ($user->roles as $role)
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-xs font-medium
                                    {{ $role->name === 'Admin' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $role->name === 'Dokter' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $role->name === 'Petugas' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $role->name === 'Pasien' ? 'bg-purple-100 text-purple-800' : '' }}
                                ">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="text-gray-500">No role</span>
                            @endforelse
                        </dd>
                    </div>
                </dl>

                <!-- Dokter Information -->
                @if ($user->dokter)
                    <div class="mt-8 pt-8 border-t">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Dokter</h3>
                        <dl class="space-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-600">NIP</dt>
                                <dd class="text-lg text-gray-900">{{ $user->dokter->nip }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Spesialisasi</dt>
                                <dd class="text-lg text-gray-900">{{ $user->dokter->spesialisasi }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">No. Telepon</dt>
                                <dd class="text-lg text-gray-900">{{ $user->dokter->no_telp }}</dd>
                            </div>
                        </dl>
                    </div>
                @endif

                <!-- Pasien Information -->
                @if ($user->pasien)
                    <div class="mt-8 pt-8 border-t">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pasien</h3>
                        <dl class="space-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-600">NIK</dt>
                                <dd class="text-lg text-gray-900">{{ $user->pasien->nik }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Tanggal Lahir</dt>
                                <dd class="text-lg text-gray-900">{{ $user->pasien->tanggal_lahir->format('d/m/Y') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Jenis Kelamin</dt>
                                <dd class="text-lg text-gray-900">{{ $user->pasien->jenis_kelamin }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">No. Telepon</dt>
                                <dd class="text-lg text-gray-900">{{ $user->pasien->no_telp }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Alamat</dt>
                                <dd class="text-lg text-gray-900">{{ $user->pasien->alamat }}</dd>
                            </div>
                        </dl>
                    </div>
                @endif
            </div>

            <!-- Sidebar - Metadata -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Metadata</h3>
                <dl class="space-y-4 text-sm">
                    <div>
                        <dt class="font-medium text-gray-600">User ID</dt>
                        <dd class="text-gray-900">{{ $user->id }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-600">Dibuat</dt>
                        <dd class="text-gray-900">{{ $user->created_at->format('d/m/Y H:i:s') }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-600">Diperbarui</dt>
                        <dd class="text-gray-900">{{ $user->updated_at->format('d/m/Y H:i:s') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
