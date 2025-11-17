<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Backup Database</h2>
                <p class="mt-1 text-sm text-gray-500">Mengelola backup dan restore database</p>
            </div>
            <div class="flex space-x-3">
                <form action="{{ route('admin.manajemen.backup.create') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        📦 Buat Backup Baru
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
                <span class="block sm-inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Backup Statistics --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-semibold">📊</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Backup</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $backups->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 font-semibold">💾</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Ukuran Total</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($backups->sum('size') / 1024 / 1024, 2) }} MB</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <span class="text-purple-600 font-semibold">🕐</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Backup Terakhir</p>
                        <p class="text-lg font-semibold text-gray-900">
                            @if($backups->isNotEmpty())
                                {{ $backups->first()->created_at->diffForHumans() }}
                            @else
                                Belum ada
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Backup Files Table --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Daftar File Backup</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Oleh</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($backups as $backup)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $backup->filename }}</div>
                                    <div class="text-xs text-gray-500">{{ $backup->type ?? 'SQL' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($backup->size / 1024 / 1024, 2) }} MB
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="text-sm text-gray-900">{{ $backup->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $backup->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $backup->created_by ?? 'System' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($backup->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    @elseif($backup->status === 'failed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Gagal
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Proses
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.manajemen.backup.download', $backup->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">Download</a>
                                    <button onclick="confirmDelete('{{ $backup->id }}', '{{ $backup->filename }}')" 
                                            class="text-red-600 hover:text-red-900">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada file backup</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($backups->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $backups->links() }}
                </div>
            @endif
        </div>

        {{-- Backup Instructions --}}
        <div class="bg-white shadow rounded-lg overflow-hidden mt-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Petunjuk Backup</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4 text-sm text-gray-600">
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">🔄 Proses Backup Otomatis</h4>
                        <p>Backup akan dilakukan secara otomatis setiap hari pada pukul 02:00 WIB. File backup akan disimpan selama 30 hari terakhir.</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">⚠️ Penting</h4>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Pastikan storage memiliki cukup ruang untuk menyimpan file backup</li>
                            <li>Download file backup secara berkala ke lokasi yang aman</li>
                            <li>Test restore secara berkala untuk memastikan backup valid</li>
                            <li>Jangan menyimpan backup hanya di server yang sama</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">📋 Informasi File</h4>
                        <p>File backup berformat SQL yang berisi struktur dan data dari semua tabel database. Ukuran file tergantung pada jumlah data yang tersimpan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Hapus Backup</h3>
                <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menghapus file backup <span id="deleteFileName" class="font-semibold"></span>?</p>
                <div class="flex justify-center space-x-3">
                    <button onclick="closeModal('deleteModal')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Batal</button>
                    <form id="deleteForm" method="POST" class="inline">
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

        function confirmDelete(id, filename) {
            document.getElementById('deleteFileName').textContent = filename;
            document.getElementById('deleteForm').action = `/admin/manajemen/backup/${id}`;
            openModal('deleteModal');
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