@if (session('success'))
    <script>
        (function() {
            let attempts = 0;
            const maxAttempts = 20;
            
            function showSuccessAlert() {
                if (typeof Swal !== 'undefined' && typeof Swal.fire === 'function') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#2563eb',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: true,
                        allowOutsideClick: true
                    });
                } else if (attempts < maxAttempts) {
                    attempts++;
                    setTimeout(showSuccessAlert, 100);
                } else {
                    console.error('SweetAlert2 tidak dapat dimuat');
                    alert('{{ session('success') }}');
                }
            }
            
            // Wait for both DOM and SweetAlert2 to be ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(showSuccessAlert, 100);
                });
            } else {
                setTimeout(showSuccessAlert, 100);
            }
        })();
    </script>
@endif

@if (session('error'))
    <script>
        (function() {
            let attempts = 0;
            const maxAttempts = 20;
            
            function showErrorAlert() {
                if (typeof Swal !== 'undefined' && typeof Swal.fire === 'function') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        confirmButtonColor: '#dc2626',
                        showConfirmButton: true,
                        allowOutsideClick: true
                    });
                } else if (attempts < maxAttempts) {
                    attempts++;
                    setTimeout(showErrorAlert, 100);
                } else {
                    console.error('SweetAlert2 tidak dapat dimuat');
                    alert('Error: {{ session('error') }}');
                }
            }
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(showErrorAlert, 100);
                });
            } else {
                setTimeout(showErrorAlert, 100);
            }
        })();
    </script>
@endif

@if (session('warning'))
    <script>
        (function() {
            let attempts = 0;
            const maxAttempts = 20;
            
            function showWarningAlert() {
                if (typeof Swal !== 'undefined' && typeof Swal.fire === 'function') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan!',
                        text: '{{ session('warning') }}',
                        confirmButtonColor: '#f59e0b',
                        showConfirmButton: true,
                        allowOutsideClick: true
                    });
                } else if (attempts < maxAttempts) {
                    attempts++;
                    setTimeout(showWarningAlert, 100);
                } else {
                    console.error('SweetAlert2 tidak dapat dimuat');
                    alert('Peringatan: {{ session('warning') }}');
                }
            }
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(showWarningAlert, 100);
                });
            } else {
                setTimeout(showWarningAlert, 100);
            }
        })();
    </script>
@endif

@if (session('info'))
    <script>
        (function() {
            let attempts = 0;
            const maxAttempts = 20;
            
            function showInfoAlert() {
                if (typeof Swal !== 'undefined' && typeof Swal.fire === 'function') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: '{{ session('info') }}',
                        confirmButtonColor: '#3b82f6',
                        showConfirmButton: true,
                        allowOutsideClick: true
                    });
                } else if (attempts < maxAttempts) {
                    attempts++;
                    setTimeout(showInfoAlert, 100);
                } else {
                    console.error('SweetAlert2 tidak dapat dimuat');
                    alert('Info: {{ session('info') }}');
                }
            }
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(showInfoAlert, 100);
                });
            } else {
                setTimeout(showInfoAlert, 100);
            }
        })();
    </script>
@endif
