<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
                <p class="mt-1 text-sm text-gray-500">Selamat datang, {{ auth()->user()->name }}</p>
            </div>
        </div>

        <!-- Alur Permohonan Periksa -->
        <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Alur Permohonan Periksa
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold mr-2">1</div>
                        <h4 class="font-semibold text-gray-900">Ajukan Permohonan</h4>
                    </div>
                    <p class="text-xs text-gray-600">Pilih poli tujuan, tanggal & jam yang diinginkan, serta keluhan Anda</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 font-bold mr-2">2</div>
                        <h4 class="font-semibold text-gray-900">Menunggu Konfirmasi</h4>
                    </div>
                    <p class="text-xs text-gray-600">Admin/Petugas akan menentukan dokter dan jadwal periksa Anda</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-2">3</div>
                        <h4 class="font-semibold text-gray-900">Disetujui</h4>
                    </div>
                    <p class="text-xs text-gray-600">Permohonan disetujui dan jadwal periksa telah dibuat</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold mr-2">4</div>
                        <h4 class="font-semibold text-gray-900">Datang Periksa</h4>
                    </div>
                    <p class="text-xs text-gray-600">Datang sesuai jadwal yang telah ditentukan</p>
                </div>
            </div>
        </div>

        @if(isset($pendingAppointment) && $pendingAppointment)
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-yellow-900">Permohonan Sedang Diproses</p>
                            <p class="text-xs text-yellow-700">Poli: <strong>{{ $pendingAppointment->poli->nama_poli }}</strong> | Tanggal usulan: <strong>{{ optional($pendingAppointment->tanggal_usulan)->format('d/m/Y') }} {{ $pendingAppointment->jam_usulan }}</strong></p>
                        </div>
                    </div>
                    <a href="{{ route('pasien.appointment.index') }}" class="text-sm font-semibold text-yellow-700 hover:text-yellow-900 flex items-center">
                        Lihat Detail
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @endif

        @if(isset($upcomingJadwal) && $upcomingJadwal)
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-green-800">Jadwal periksa berikutnya: <strong>{{ optional($upcomingJadwal->tanggal)->format('d/m/Y') }}</strong> pukul <strong>{{ $upcomingJadwal->jam_mulai }}</strong> dengan dokter <strong>{{ $upcomingJadwal->dokter->user->name }}</strong>.</p>
                    </div>
                    <a href="{{ route('pasien.jadwal.index') }}" class="text-sm font-semibold text-green-700 hover:text-green-900">Lihat Jadwal →</a>
                </div>
            </div>
        @endif

        <!-- Quick Menu -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Quick Menu</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <!-- Riwayat Medis -->
                <a href="{{ route('pasien.rekam-medis.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-blue-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Riwayat Medis</p>
                        <p class="text-xs text-gray-500">Lihat riwayat medis</p>
                    </div>
                </a>

                <!-- Jadwal -->
                <a href="{{ route('pasien.jadwal.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-orange-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Jadwal</p>
                        <p class="text-xs text-gray-500">Jadwal periksa</p>
                    </div>
                </a>

                <!-- Permohonan Periksa -->
                <a href="{{ route('pasien.appointment.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-yellow-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Permohonan Periksa</p>
                        <p class="text-xs text-gray-500">Ajukan dan lihat status</p>
                    </div>
                </a>

                <!-- Dokter -->
                <a href="{{ route('pasien.dokter.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-green-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Dokter</p>
                        <p class="text-xs text-gray-500">Daftar dokter</p>
                    </div>
                </a>

                <!-- Profil -->
                <a href="{{ route('profile.edit') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-purple-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Profil</p>
                        <p class="text-xs text-gray-500">Kelola profil</p>
                    </div>
                </a>

                <!-- Poli -->
                <a href="{{ route('pasien.poli.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200 flex items-center cursor-pointer border border-gray-200 hover:border-teal-300">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Poli</p>
                        <p class="text-xs text-gray-500">Daftar poli</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Statistik</h3>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Riwayat Medis</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $totalRekamMedis }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Rekam Medis -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Riwayat Medis Terbaru</h3>
                    <a href="{{ route('pasien.rekam-medis.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Lihat Semua →
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosa</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentRekamMedis as $rekam)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $rekam->tanggal_periksa->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $rekam->dokter->user->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ Str::limit($rekam->diagnosa, 50) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada riwayat medis
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
