<x-app-layout>
    <div class="min-h-[50vh] flex items-center justify-center">
        <div class="text-center">
            <div class="mb-4">
                <svg class="mx-auto h-16 w-16 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10 21h4a2 2 0 002-2V7a2 2 0 00-2-2h-1l-1-2H9L8 5H7a2 2 0 00-2 2v12a2 2 0 002 2h3z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">403 - Akses Ditolak</h1>
            <p class="mt-2 text-gray-600">User tidak memiliki izin yang tepat untuk mengakses halaman ini.</p>
            <div class="mt-6 flex items-center justify-center gap-3">
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Kembali</a>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Dashboard</a>
            </div>
        </div>
    </div>
</x-app-layout>