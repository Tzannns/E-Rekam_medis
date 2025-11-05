<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Lengkapi Profil Pasien</h2>
            <p class="mt-1 text-sm text-gray-500">Isi data berikut untuk mengaktifkan fitur pasien.</p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('pasien.profil.store') }}" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="nik" value="NIK" />
                    <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full" maxlength="16" minlength="16" value="{{ old('nik') }}" required />
                    <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                        <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" value="{{ old('tanggal_lahir') }}" required />
                        <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                        <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Pilih</option>
                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="no_telp" value="No. Telepon" />
                        <x-text-input id="no_telp" name="no_telp" type="text" class="mt-1 block w-full" value="{{ old('no_telp') }}" required />
                        <x-input-error :messages="$errors->get('no_telp')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="alamat" value="Alamat" />
                    <textarea id="alamat" name="alamat" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('alamat') }}</textarea>
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button>Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>


