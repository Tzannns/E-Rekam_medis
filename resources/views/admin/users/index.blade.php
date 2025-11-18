<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Users</h2>
                <p class="mt-1 text-sm text-gray-500">Kelola akun pengguna</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Tambah User
            </a>
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

        <div class="bg-white overflow-hidden shadow rounded-lg mb-6 p-6">
            <form method="GET" action="{{ url()->current() }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="semua">Semua</option>
                            @isset($roles)
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">Filter</button>
                    <a href="{{ url()->current() }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">Reset</a>
                </div>
            </form>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @foreach ($user->roles as $role)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            @switch($role->name)
                                                @case('Admin') bg-blue-100 text-blue-800 @break
                                                @case('Dokter') bg-cyan-100 text-cyan-800 @break
                                                @case('Petugas') bg-emerald-100 text-emerald-800 @break
                                                @case('Pasien') bg-amber-100 text-amber-800 @break
                                                @default bg-gray-100 text-gray-800
                                            @endswitch">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($user->created_at)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @include('admin.users.partials.actions')
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data Users</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
    @include('components.sweet-alert')
