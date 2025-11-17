<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Log Aktivitas</h2>
                <p class="mt-1 text-sm text-gray-500">Melihat semua aktivitas pengguna sistem</p>
            </div>
            <div class="flex space-x-3">
                <form action="{{ route('admin.manajemen.clear-log') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua log?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        🗑️ Bersihkan Log
                    </button>
                </form>
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

        {{-- Filter Form --}}
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Filter Log</h3>
            </div>
            <form action="{{ route('admin.manajemen.log-aktivitas') }}" method="GET" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="user" class="block text-sm font-medium text-gray-700">User</label>
                        <select name="user" id="user" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="modul" class="block text-sm font-medium text-gray-700">Modul</label>
                        <select name="modul" id="modul" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Modul</option>
                            <option value="pasien" {{ request('modul') == 'pasien' ? 'selected' : '' }}>Pasien</option>
                            <option value="pendaftaran" {{ request('modul') == 'pendaftaran' ? 'selected' : '' }}>Pendaftaran</option>
                            <option value="poli" {{ request('modul') == 'poli' ? 'selected' : '' }}>Poli</option>
                            <option value="gizi" {{ request('modul') == 'gizi' ? 'selected' : '' }}>Gizi</option>
                            <option value="laundry" {{ request('modul') == 'laundry' ? 'selected' : '' }}>Laundry</option>
                            <option value="manajemen" {{ request('modul') == 'manajemen' ? 'selected' : '' }}>Manajemen</option>
                            <option value="auth" {{ request('modul') == 'auth' ? 'selected' : '' }}>Autentikasi</option>
                        </select>
                    </div>
                    <div>
                        <label for="aksi" class="block text-sm font-medium text-gray-700">Aksi</label>
                        <select name="aksi" id="aksi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Aksi</option>
                            <option value="login" {{ request('aksi') == 'login' ? 'selected' : '' }}>Login</option>
                            <option value="logout" {{ request('aksi') == 'logout' ? 'selected' : '' }}>Logout</option>
                            <option value="create" {{ request('aksi') == 'create' ? 'selected' : '' }}>Create</option>
                            <option value="update" {{ request('aksi') == 'update' ? 'selected' : '' }}>Update</option>
                            <option value="delete" {{ request('aksi') == 'delete' ? 'selected' : '' }}>Delete</option>
                            <option value="view" {{ request('aksi') == 'view' ? 'selected' : '' }}>View</option>
                        </select>
                    </div>
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-4">
                    <a href="{{ route('admin.manajemen.log-aktivitas') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Reset</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filter</button>
                </div>
            </form>
        </div>

        {{-- Activity Log Table --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Daftar Aktivitas</h3>
                <p class="text-sm text-gray-500 mt-1">Total: {{ $logs->total() }} aktivitas</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="text-sm font-medium text-gray-900">{{ $log->waktu->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->waktu->format('H:i:s') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $log->user->name ?? 'System' }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->user->email ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <div class="text-sm text-gray-900">{{ $log->aktivitas }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $log->modul }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $actionColors = [
                                            'login' => 'green',
                                            'logout' => 'gray',
                                            'create' => 'blue',
                                            'update' => 'yellow',
                                            'delete' => 'red',
                                            'view' => 'purple'
                                        ];
                                        $color = $actionColors[$log->aksi] ?? 'gray';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                                        {{ $log->aksi }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if($log->detail)
                                        <button onclick="showDetail('{{ $log->id }}')" class="text-blue-600 hover:text-blue-900">
                                            Lihat Detail
                                        </button>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="text-sm text-gray-900">{{ $log->ip_address }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-32">{{ $log->user_agent }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data log aktivitas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Detail Modal --}}
    <div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-[600px] shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Aktivitas</h3>
                <div id="detailContent" class="bg-gray-50 p-4 rounded-md">
                    <p class="text-sm text-gray-600">Memuat detail...</p>
                </div>
                <div class="flex justify-end mt-6">
                    <button onclick="closeModal('detailModal')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Tutup</button>
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

        function showDetail(logId) {
            // Fetch log detail via AJAX
            fetch(`/admin/manajemen/log-aktivitas/${logId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const log = data.log;
                        document.getElementById('detailContent').innerHTML = `
                            <div class="space-y-3">
                                <div>
                                    <strong class="text-sm font-medium text-gray-700">Aktivitas:</strong>
                                    <p class="text-sm text-gray-900 mt-1">${log.aktivitas}</p>
                                </div>
                                <div>
                                    <strong class="text-sm font-medium text-gray-700">Detail:</strong>
                                    <pre class="text-sm text-gray-900 mt-1 bg-white p-3 rounded border overflow-auto max-h-60">${log.detail}</pre>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <strong class="text-sm font-medium text-gray-700">User Agent:</strong>
                                        <p class="text-xs text-gray-600 mt-1">${log.user_agent}</p>
                                    </div>
                                    <div>
                                        <strong class="text-sm font-medium text-gray-700">Waktu:</strong>
                                        <p class="text-sm text-gray-900 mt-1">${new Date(log.waktu).toLocaleString('id-ID')}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        openModal('detailModal');
                    }
                })
                .catch(error => {
                    document.getElementById('detailContent').innerHTML = `
                        <p class="text-sm text-red-600">Gagal memuat detail: ${error.message}</p>
                    `;
                    openModal('detailModal');
                });
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