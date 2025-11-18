<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Ambil Antrian Online</h2>
                <p class="mt-1 text-sm text-gray-500">Pilih poli, tanggal, dan jadwal yang tersedia</p>
            </div>
            <a href="{{ route('pasien.appointment.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">Kembali</a>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('pasien.appointment.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Poli Tujuan</label>
                        <select name="poli_id" id="poli_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Pilih Poli</option>
                            @foreach ($poliList as $p)
                                <option value="{{ $p->id }}" {{ (old('poli_id', $poliId ?? '') == $p->id) ? 'selected' : '' }}>{{ $p->nama_poli }}</option>
                            @endforeach
                        </select>
                        @error('poli_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Daftar</label>
                        <input type="date" name="tanggal_usulan" id="tanggal_usulan" value="{{ old('tanggal_usulan', $tanggal ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @error('tanggal_usulan')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Jadwal (Dokter & Jam)</label>
                        <select name="jadwal_id" id="jadwal_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ (isset($jadwalOptions) && $jadwalOptions->count()) ? '' : 'disabled' }} required>
                            @if(isset($jadwalOptions) && $jadwalOptions->count())
                                <option value="">Pilih Jadwal</option>
                                @foreach ($jadwalOptions as $j)
                                    <option value="{{ $j->id }}" {{ (request('jadwal_id') == $j->id) ? 'selected' : '' }}>{{ $j->dokter->user->name }} — {{ $j->jam_mulai }} s/d {{ $j->jam_selesai }}</option>
                                @endforeach
                            @else
                                <option value="">Pilih Poli dan Tanggal untuk melihat jadwal</option>
                            @endif
                        </select>
                        @error('jadwal_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    @if(isset($selectedJadwalId) && $selectedJadwalId && isset($selectedJadwal) && $selectedJadwal)
                        <div class="md:col-span-2">
                            <div class="bg-yellow-50 border border-yellow-200 rounded p-4 mb-3">
                                <p class="text-sm text-yellow-800">Total antrian untuk jadwal ini: <strong>{{ $currentQueueCount }}</strong></p>
                                <p class="text-sm text-yellow-800">Nomor Anda jika mengambil: <strong>{{ $currentQueueCount + 1 }}</strong> dari <strong>{{ $currentQueueCount + 1 }}</strong></p>
                            </div>
                            <div class="overflow-x-auto bg-white border rounded">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($queueAppointments as $qa)
                                            <tr>
                                                <td class="px-6 py-2 text-sm text-gray-900">{{ $qa->nomor_antrian }}</td>
                                                <td class="px-6 py-2 text-sm text-gray-900">{{ $qa->pasien->user->name }}</td>
                                                <td class="px-6 py-2 text-sm text-gray-900">{{ $qa->status }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-6 py-3 text-sm text-gray-500 text-center">Belum ada antrian</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan</label>
                        <textarea name="keluhan" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('keluhan') }}</textarea>
                        @error('keluhan')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">Ambil Antrian</button>
                    <a href="{{ route('pasien.appointment.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                </div>
            </form>
            <script>
                (function(){
                    const poli = document.getElementById('poli_id');
                    const tanggal = document.getElementById('tanggal_usulan');
                    const jadwal = document.getElementById('jadwal_id');
                    function refreshOptions(){
                        const p = poli.value; const t = tanggal.value;
                        if (!p || !t) return;
                        const url = new URL(window.location.href);
                        url.searchParams.set('poli_id', p);
                        url.searchParams.set('tanggal_usulan', t);
                        window.location.href = url.toString();
                    }
                    function selectJadwal(){
                        const p = poli.value; const t = tanggal.value; const j = jadwal.value;
                        if (!p || !t || !j) return;
                        const url = new URL(window.location.href);
                        url.searchParams.set('poli_id', p);
                        url.searchParams.set('tanggal_usulan', t);
                        url.searchParams.set('jadwal_id', j);
                        window.location.href = url.toString();
                    }
                    poli && poli.addEventListener('change', refreshOptions);
                    tanggal && tanggal.addEventListener('change', refreshOptions);
                    jadwal && jadwal.addEventListener('change', selectJadwal);
                })();
            </script>
        </div>
    </div>

    @include('components.sweet-alert')
</x-app-layout>