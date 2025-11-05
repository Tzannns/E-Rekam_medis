@if (session('success'))
    <script>
        window.addEventListener('load', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#2563eb',
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        });
    </script>
@endif

@if (session('error'))
    <script>
        window.addEventListener('load', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc2626'
                });
            }
        });
    </script>
@endif

@if (session('warning'))
    <script>
        window.addEventListener('load', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: '{{ session('warning') }}',
                    confirmButtonColor: '#f59e0b'
                });
            }
        });
    </script>
@endif

@if (session('info'))
    <script>
        window.addEventListener('load', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'info',
                    title: 'Info',
                    text: '{{ session('info') }}',
                    confirmButtonColor: '#3b82f6'
                });
            }
        });
    </script>
@endif
