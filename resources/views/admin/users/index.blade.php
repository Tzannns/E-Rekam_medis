<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Data Users</h2>
                <p class="mt-1 text-sm text-gray-500">Kelola data pengguna sistem</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
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

        <!-- Table -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Daftar Users</h3>
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
    /* Harmonize DataTables Buttons with Tailwind */
    .dt-buttons .dt-button {
        @apply inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded mr-2 border-0 !important;
        background: transparent;
    }
    .dt-buttons .dt-button.btn-copy { @apply bg-gray-700 text-white hover:bg-gray-800 !important; }
    .dt-buttons .dt-button.btn-csv { @apply bg-emerald-600 text-white hover:bg-emerald-700 !important; }
    .dt-buttons .dt-button.btn-excel { @apply bg-green-600 text-white hover:bg-green-700 !important; }
    .dt-buttons .dt-button.btn-pdf { @apply bg-red-600 text-white hover:bg-red-700 !important; }
    .dt-buttons .dt-button.btn-print { @apply bg-blue-600 text-white hover:bg-blue-700 !important; }
    .dt-buttons .dt-button svg { width: 14px; height: 14px; margin-right: 6px; }
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
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'roles', name: 'roles', orderable: false, searchable: false },
                { data: 'created_at', name: 'created_at', render: function (data) { return new Date(data).toLocaleDateString('id-ID'); } },
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

        // expose for reload on flash (optional)
        window.__usersDT = table;
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
