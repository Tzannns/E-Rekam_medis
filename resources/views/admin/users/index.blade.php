<x-app-layout>
    <div>
        <div class="mb-6">
            <div class="rounded-xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 text-white shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">Kelola Users</h2>
                        <p class="text-sm opacity-90">Pengelolaan akun pengguna sistem</p>
                    </div>
                    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white/20 hover:bg-white/30 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah User</span>
                    </a>
                </div>
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

        <!-- Table -->
        <div class="bg-white shadow rounded-xl">
            <div class="px-6 py-4 border-b border-gray-200 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Users</h3>
                <div class="flex flex-col gap-3 md:flex-row md:items-center">
                    <div class="relative">
                        <input id="global-search" type="text" placeholder="Cari nama atau email" class="pl-10 pr-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
                    </div>
                    <div>
                        <select id="role-filter" class="px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Role</option>
                            @isset($roles)
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table id="users-table" class="min-w-full divide-y divide-gray-200 w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" />
<style>
    .dt-buttons .dt-button { display:inline-flex; align-items:center; padding:6px 10px; font-size:12px; font-weight:600; border-radius:8px; margin-right:8px; border:0; background:transparent }
    .dt-buttons .dt-button.btn-copy { background:#374151; color:#fff }
    .dt-buttons .dt-button.btn-copy:hover { background:#1f2937 }
    .dt-buttons .dt-button.btn-csv { background:#059669; color:#fff }
    .dt-buttons .dt-button.btn-csv:hover { background:#047857 }
    .dt-buttons .dt-button.btn-excel { background:#16a34a; color:#fff }
    .dt-buttons .dt-button.btn-excel:hover { background:#15803d }
    .dt-buttons .dt-button.btn-pdf { background:#dc2626; color:#fff }
    .dt-buttons .dt-button.btn-pdf:hover { background:#b91c1c }
    .dt-buttons .dt-button.btn-print { background:#2563eb; color:#fff }
    .dt-buttons .dt-button.btn-print:hover { background:#1d4ed8 }
    .dt-buttons .dt-button svg { width:14px; height:14px; margin-right:6px }
    .badge { display:inline-flex; align-items:center; font-size:11px; font-weight:600; padding:4px 8px; border-radius:9999px; margin-right:6px }
    .badge.admin { background:#1d4ed8; color:#fff }
    .badge.dokter { background:#0ea5e9; color:#fff }
    .badge.petugas { background:#10b981; color:#fff }
    .badge.pasien { background:#f59e0b; color:#1f2937 }
    .avatar { width:36px; height:36px; border-radius:9999px; display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff }
    .avatar.blue { background:#3b82f6 }
    .avatar.indigo { background:#6366f1 }
    .avatar.purple { background:#8b5cf6 }
    .avatar.emerald { background:#10b981 }
</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const palette = ['blue','indigo','purple','emerald']
        const table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.users.data') }}',
                type: 'GET'
            },
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copy', className: 'btn-copy', text: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2M8 16h8a2 2 0 002-2v-4M8 16l-2 2m2-2l2 2"/></svg>Copy' },
                { extend: 'csv', className: 'btn-csv', text: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>CSV' },
                { extend: 'excel', className: 'btn-excel', text: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4zM8 8l8 8M16 8l-8 8"/></svg>Excel' },
                { extend: 'pdf', className: 'btn-pdf', text: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/></svg>PDF' },
                { extend: 'print', className: 'btn-print', text: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 18h12v4H6zM6 14h12a2 2 0 002-2v-1a2 2 0 00-2-2H6a2 2 0 00-2 2v1a2 2 0 002 2z"/></svg>Print' },
            ],
            order: [[3, 'desc']],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
            },
            columns: [
                { data: 'name', name: 'name', render: function (data) {
                    const initial = (data||'').trim().charAt(0).toUpperCase()
                    const color = palette[Math.floor(Math.random()*palette.length)]
                    return '<div class="flex items-center gap-3"><div class="avatar '+color+'">'+initial+'</div><div class="font-semibold text-gray-900">'+data+'</div></div>'
                } },
                { data: 'email', name: 'email' },
                { data: 'roles', name: 'roles', orderable: false, searchable: true, render: function (data) {
                    const items = (data||'').split(',').map(function(x){ return x.trim() }).filter(Boolean)
                    return items.map(function(r){
                        const key = r.toLowerCase()
                        return '<span class="badge '+key+'">'+r+'</span>'
                    }).join(' ')
                } },
                { data: 'created_at', name: 'created_at', render: function (data) {
                    try { return new Date(data).toLocaleDateString('id-ID') } catch(e) { return data }
                } },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
            ]
        });

        // SweetAlert delete handler (delegation)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('[data-delete]');
            if (!btn) return;
            e.preventDefault();
            const form = btn.closest('form');

            Swal.fire({
                title: 'Hapus user ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });

        window.__usersDT = table;
        $('#global-search').on('input', function(){ table.search(this.value).draw() })
        $('#role-filter').on('change', function(){
            const v = this.value
            if (!v) { table.column(2).search('').draw(); return }
            table.column(2).search('^'+v+'$', true, false).draw()
        })
    });

    // Auto-reload after flash message actions
    window.addEventListener('load', function() {
        if (typeof Swal !== 'undefined' && @json(session('success') || session('error') || session('warning') || session('info'))) {
            setTimeout(() => {
                if (window.__usersDT) window.__usersDT.ajax.reload();
            }, 1200);
        }
    });
</script>
