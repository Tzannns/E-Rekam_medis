<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Permohonan Periksa</h2>
                <p class="mt-1 text-sm text-gray-500">Tinjau dan proses permohonan</p>
            </div>
            <a href="{{ route('admin.appointment.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">Kembali</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Permohonan</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Pasien</dt>
                        <dd class="text-lg text-gray-900">{{ $appointment->pasien->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Dokter</dt>
                        <dd class="text-lg text-gray-900">{{ $appointment->dokter->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Tanggal/Jam Usulan</dt>
                        <dd class="text-lg text-gray-900">{{ optional($appointment->tanggal_usulan)->format('d/m/Y') }} {{ $appointment->jam_usulan }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Keluhan</dt>
                        <dd class="text-lg text-gray-900 whitespace-pre-line">{{ $appointment->keluhan ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Status</dt>
                        <dd class="text-lg">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if ($appointment->status === 'Disetujui') bg-green-100 text-green-800
                                @elseif ($appointment->status === 'Diproses') bg-blue-100 text-blue-800
                                @elseif ($appointment->status === 'Menunggu') bg-gray-100 text-gray-800
                                @elseif ($appointment->status === 'Dibatalkan') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $appointment->status }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Catatan Admin/Petugas</dt>
                        <dd class="text-lg text-gray-900 whitespace-pre-line">{{ $appointment->catatan_admin ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Proses Permohonan</h3>
                <form method="POST" action="{{ route('admin.appointment.update', $appointment) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @foreach (['Disetujui','Diproses','Dibatalkan'] as $s)
                                <option value="{{ $s }}" {{ old('status', $appointment->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('status')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jadwal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('tanggal')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                            <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('jam_mulai')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                            <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('jam_selesai')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Admin/Petugas</label>
                        <textarea name="catatan_admin" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('catatan_admin', $appointment->catatan_admin) }}</textarea>
                        @error('catatan_admin')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">Simpan</button>
                        <a href="{{ route('admin.appointment.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.sweet-alert')
</x-app-layout>