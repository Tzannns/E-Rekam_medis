<x-app-layout>
    <div>
        @php($prefix = \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'petugas.') ? 'petugas' : 'admin')
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Edit Hasil Radiologi</h2>
                <p class="mt-1 text-sm text-gray-500">Perbarui hasil pemeriksaan radiologi</p>
            </div>
            <div class="space-x-2">
                <a href="{{ route($prefix . '.radiologi.show', $item) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Detail</a>
                <a href="{{ route($prefix . '.radiologi.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">Kembali</a>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route($prefix . '.radiologi.update', $item) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pasien</label>
                        <select name="pasien_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @foreach ($pasienList as $p)
                                <option value="{{ $p->id }}" {{ old('pasien_id', $item->pasien_id) == $p->id ? 'selected' : '' }}>{{ $p->user->name }}</option>
                            @endforeach
                        </select>
                        @error('pasien_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dokter</label>
                        <select name="dokter_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @foreach ($dokterList as $d)
                                <option value="{{ $d->id }}" {{ old('dokter_id', $item->dokter_id) == $d->id ? 'selected' : '' }}>{{ $d->user->name }}</option>
                            @endforeach
                        </select>
                        @error('dokter_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pemeriksaan</label>
                        <input type="text" name="jenis_pemeriksaan" value="{{ old('jenis_pemeriksaan', $item->jenis_pemeriksaan) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @error('jenis_pemeriksaan')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hasil</label>
                        <textarea name="hasil" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('hasil', $item->hasil) }}</textarea>
                        @error('hasil')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Periksa</label>
                        <input type="datetime-local" name="tanggal_periksa" value="{{ old('tanggal_periksa', optional($item->tanggal_periksa)->format('Y-m-d\TH:i')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @error('tanggal_periksa')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="Diajukan" {{ old('status', $item->status) === 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="Diproses" {{ old('status', $item->status) === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ old('status', $item->status) === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <textarea name="catatan" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('catatan', $item->catatan) }}</textarea>
                        @error('catatan')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">Simpan Perubahan</button>
                    <a href="{{ route($prefix . '.radiologi.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                </div>
            </form>
        </div>
    </div>

    @include('components.sweet-alert')
</x-app-layout>