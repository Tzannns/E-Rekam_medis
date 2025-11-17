<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Manajemen Role & Permission</h2>
                <p class="mt-1 text-sm text-gray-500">Kelola hak akses dan peran pengguna</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="openModal('addRoleModal')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    + Tambah Role
                </button>
                <a href="{{ route('admin.manajemen.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    ← Kembali
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Roles Table --}}
        <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Daftar Role</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guard</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($roles as $index => $role)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $role->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $role->guard_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $role->users_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($role->permissions->take(3) as $permission)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                        @if($role->permissions->count() > 3)
                                            <span class="text-xs text-gray-500">+{{ $role->permissions->count() - 3 }} lainnya</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $role->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <button onclick="editRole({{ $role->id }}, '{{ $role->name }}', {{ $role->permissions->pluck('id') }})" 
                                            class="text-blue-600 hover:text-blue-900">Edit</button>
                                    @if(!in_array($role->name, ['admin', 'super-admin']))
                                        <button onclick="confirmDeleteRole('{{ $role->id }}', '{{ $role->name }}')" 
                                                class="text-red-600 hover:text-red-900">Hapus</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data role</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($roles->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $roles->links() }}
                </div>
            @endif
        </div>

        {{-- Permissions List --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Daftar Permission</h3>
                <p class="text-sm text-gray-500 mt-1">Semua permissions yang tersedia dalam sistem</p>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($permissions->groupBy(function($permission) {
                        return explode('-', $permission->name)[0] ?? 'other';
                    }) as $group => $groupPermissions)
                        <div class="border rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-2 capitalize">{{ $group }} Module</h4>
                            <div class="space-y-2">
                                @foreach($groupPermissions as $permission)
                                    <div class="flex items-center">
                                        <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" disabled checked>
                                        <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Add Role Modal --}}
    <div id="addRoleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-[500px] shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Role Baru</h3>
                <form action="{{ route('admin.manajemen.store-role') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="add_role_name" class="block text-sm font-medium text-gray-700">Nama Role</label>
                            <input type="text" name="name" id="add_role_name" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                            <div class="max-h-60 overflow-y-auto border rounded-md p-3">
                                @foreach($permissions->groupBy(function($permission) {
                                    return explode('-', $permission->name)[0] ?? 'other';
                                }) as $group => $groupPermissions)
                                    <div class="mb-3">
                                        <h5 class="font-medium text-sm text-gray-900 mb-2 capitalize">{{ $group }} Module</h5>
                                        <div class="space-y-2 ml-3">
                                            @foreach($groupPermissions as $permission)
                                                <div class="flex items-center">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                                           id="add_perm_{{ $permission->id }}"
                                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <label for="add_perm_{{ $permission->id }}" class="ml-2 text-sm text-gray-700">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal('addRoleModal')" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Role Modal --}}
    <div id="editRoleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-[500px] shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Role</h3>
                <form id="editRoleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label for="edit_role_name" class="block text-sm font-medium text-gray-700">Nama Role</label>
                            <input type="text" name="name" id="edit_role_name" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                            <div class="max-h-60 overflow-y-auto border rounded-md p-3">
                                @foreach($permissions->groupBy(function($permission) {
                                    return explode('-', $permission->name)[0] ?? 'other';
                                }) as $group => $groupPermissions)
                                    <div class="mb-3">
                                        <h5 class="font-medium text-sm text-gray-900 mb-2 capitalize">{{ $group }} Module</h5>
                                        <div class="space-y-2 ml-3">
                                            @foreach($groupPermissions as $permission)
                                                <div class="flex items-center">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                                           id="edit_perm_{{ $permission->id }}"
                                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <label for="edit_perm_{{ $permission->id }}" class="ml-2 text-sm text-gray-700">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal('editRoleModal')" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Role Confirmation Modal --}}
    <div id="deleteRoleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Hapus Role</h3>
                <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menghapus role <span id="deleteRoleName" class="font-semibold"></span>?</p>
                <p class="text-xs text-red-600 mb-4">Peringatan: User dengan role ini akan kehilangan akses!</p>
                <div class="flex justify-center space-x-3">
                    <button onclick="closeModal('deleteRoleModal')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Batal</button>
                    <form id="deleteRoleForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function editRole(id, name, permissions) {
            document.getElementById('edit_role_name').value = name;
            document.getElementById('editRoleForm').action = `/admin/manajemen/roles/${id}`;
            
            // Reset all checkboxes
            document.querySelectorAll('#editRoleModal input[type="checkbox"]').forEach(cb => cb.checked = false);
            
            // Set selected permissions
            permissions.forEach(permId => {
                const checkbox = document.getElementById(`edit_perm_${permId}`);
                if (checkbox) checkbox.checked = true;
            });
            
            openModal('editRoleModal');
        }

        function confirmDeleteRole(id, name) {
            document.getElementById('deleteRoleName').textContent = name;
            document.getElementById('deleteRoleForm').action = `/admin/manajemen/roles/${id}`;
            openModal('deleteRoleModal');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-opacity-50')) {
                event.target.classList.add('hidden');
            }
        }
    </script>
    @endpush
</x-app-layout>