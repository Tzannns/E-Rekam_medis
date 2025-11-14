<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Data User</h2>
                <p class="mt-1 text-sm text-gray-500">Kelola data user, pasien, petugas, dan dokter</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.user-management.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    + Tambah User
                </a>
                <a href="{{ route('admin.user-management.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
                    class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition text-sm">
                    Export PDF
                </a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <p>{{ $message }}</p>
            </div>
        @endif

        @if ($message = Session::get('warning'))
            <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
                <p>{{ $message }}</p>
            </div>
        @endif

        <!-- Filter dan Search -->
        <div class="mb-6 bg-white rounded-lg shadow p-6">
            <form method="GET" action="{{ route('admin.user-management.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="pencarian" class="block text-sm font-medium text-gray-700 mb-2">Cari Nama /
                            Email</label>
                        <input type="text" name="pencarian" id="pencarian" value="{{ request('pencarian') }}"
                            placeholder="Masukkan nama atau email..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Filter Role</label>
                        <select name="role" id="role"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="semua">Semua Role</option>
                            <option value="Admin" {{ request('role') === 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Dokter" {{ request('role') === 'Dokter' ? 'selected' : '' }}>Dokter</option>
                            <option value="Petugas" {{ request('role') === 'Petugas' ? 'selected' : '' }}>Petugas
                            </option>
                            <option value="Pasien" {{ request('role') === 'Pasien' ? 'selected' : '' }}>Pasien</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Cari
                        </button>
                        <a href="{{ route('admin.user-management.index') }}"
                            class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium text-center">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Info Tambahan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
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
                                        <span class="text-gray-500 text-xs">No role</span>
                                    @endforelse
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    @if ($user->dokter)
                                        <div class="text-xs">NIP: {{ $user->dokter->nip }}</div>
                                        <div class="text-xs">{{ $user->dokter->spesialisasi }}</div>
                                    @elseif ($user->pasien)
                                        <div class="text-xs">NIK: {{ $user->pasien->nik }}</div>
                                        <div class="text-xs">{{ $user->pasien->jenis_kelamin }}</div>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2 flex items-center">
                                    <a href="{{ route('admin.user-management.show', $user) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-xs font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <span>Lihat</span>
                                    </a>
                                    <a href="{{ route('admin.user-management.edit', $user) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition text-xs font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.user-management.destroy', $user) }}"
                                        class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition text-xs font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data user
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="bg-white px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
