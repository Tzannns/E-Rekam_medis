<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Antrian Online</h2>
                <p class="mt-1 text-sm text-gray-500">Daftar antrian online yang Anda ambil</p>
            </div>
            <a href="{{ route('pasien.appointment.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">+ Ambil Antrian</a>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium text-green-800">{{ $message }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-sm font-semibold text-red-800">Terjadi Kesalahan</h3>
                </div>
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poli / Dokter</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Antrian</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($appointments as $a)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ optional($a->poli)->nama_poli ?? '-' }}<br>
                                    <span class="text-xs text-gray-500">{{ $a->dokter ? $a->dokter->user->name : 'Ditentukan otomatis oleh sistem' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($a->tanggal_usulan)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $a->jam_usulan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $a->nomor_antrian ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if ($a->status === 'Disetujui') bg-green-100 text-green-800
                                        @elseif ($a->status === 'Diproses') bg-blue-100 text-blue-800
                                        @elseif ($a->status === 'Menunggu') bg-gray-100 text-gray-800
                                        @elseif ($a->status === 'Dibatalkan') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $a->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $a->catatan_admin ?? '-' }}
                                    @if(in_array($a->status, ['Menunggu', 'Diproses']))
                                        <form action="{{ route('pasien.appointment.cancel', $a) }}" method="POST" class="inline-block mt-1" onsubmit="return confirm('Yakin ingin membatalkan antrian ini?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Batalkan</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada antrian</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">{{ $appointments->links() }}</div>
        </div>
    </div>

    @include('components.sweet-alert')
</x-app-layout>