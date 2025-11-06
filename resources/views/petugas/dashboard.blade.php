<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Dashboard Petugas</h2>
            <p class="mt-1 text-sm text-gray-500">Selamat datang, {{ auth()->user()->name }}</p>
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Quick Menu</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <a href="{{ route('petugas.pendaftaran.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-blue-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Pendaftaran</p>
                        <p class="text-xs text-gray-500">Akses modul pendaftaran</p>
                    </div>
                </a>

                <a href="{{ route('petugas.igd.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-red-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">IGD</p>
                        <p class="text-xs text-gray-500">Instalasi Gawat Darurat</p>
                    </div>
                </a>

                <a href="{{ route('petugas.rawat-jalan.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-green-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Rawat Jalan</p>
                        <p class="text-xs text-gray-500">Pasien rawat jalan</p>
                    </div>
                </a>

                <a href="{{ route('petugas.rawat-inap.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-purple-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Rawat Inap</p>
                        <p class="text-xs text-gray-500">Pasien rawat inap</p>
                    </div>
                </a>

                <a href="{{ route('petugas.kasir.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-yellow-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Kasir</p>
                        <p class="text-xs text-gray-500">Transaksi pembayaran</p>
                    </div>
                </a>

                <a href="{{ route('petugas.storage.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-indigo-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Storage</p>
                        <p class="text-xs text-gray-500">Gudang</p>
                    </div>
                </a>

                <a href="{{ route('petugas.apotik.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-pink-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Apotik</p>
                        <p class="text-xs text-gray-500">Kelola obat</p>
                    </div>
                </a>

                <a href="{{ route('petugas.laboratorium.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-cyan-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Laboratorium</p>
                        <p class="text-xs text-gray-500">Hasil lab</p>
                    </div>
                </a>

                <a href="{{ route('petugas.radiologi.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-orange-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Radiologi</p>
                        <p class="text-xs text-gray-500">Hasil radiologi</p>
                    </div>
                </a>

                <a href="{{ route('petugas.gizi.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-amber-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Gizi</p>
                        <p class="text-xs text-gray-500">Nutrisi pasien</p>
                    </div>
                </a>

                <a href="{{ route('petugas.laundry.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-gray-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Laundry</p>
                        <p class="text-xs text-gray-500">Pencucian</p>
                    </div>
                </a>

                <a href="{{ route('petugas.rekam-medis.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-blue-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Rekam Medis</p>
                        <p class="text-xs text-gray-500">Kelola rekam medis</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Rekam Medis Terbaru</h3>
                    <a href="{{ route('petugas.rekam-medis.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua →</a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosa</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentRekamMedis as $rekam)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $rekam->tanggal_periksa->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $rekam->pasien->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $rekam->dokter->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($rekam->diagnosa, 50) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada rekam medis</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>


