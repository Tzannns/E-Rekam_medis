<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Tambah Rekam Medis</h2>
            <p class="mt-1 text-sm text-gray-500">Input rekam medis baru untuk pasien</p>
        </div>

        <div class="max-w-4xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.rekam-medis.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="pasien_id" :value="__('Pasien')" />
                            <select name="pasien_id" id="pasien_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih Pasien</option>
                                @foreach($pasienList as $pasien)
                                    <option value="{{ $pasien->id }}">{{ $pasien->user->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('pasien_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="dokter_id" :value="__('Dokter')" />
                            <select name="dokter_id" id="dokter_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Pilih Dokter</option>
                                @foreach($dokterList as $dokter)
                                    <option value="{{ $dokter->id }}">{{ $dokter->user->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('dokter_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tanggal_periksa" :value="__('Tanggal Periksa')" />
                            <x-text-input id="tanggal_periksa" class="block mt-1 w-full" type="date" name="tanggal_periksa" :value="old('tanggal_periksa')" required />
                            <x-input-error :messages="$errors->get('tanggal_periksa')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="keluhan" :value="__('Keluhan')" />
                            <textarea id="keluhan" name="keluhan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('keluhan') }}</textarea>
                            <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="diagnosa" :value="__('Diagnosa')" />
                            <textarea id="diagnosa" name="diagnosa" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('diagnosa') }}</textarea>
                            <x-input-error :messages="$errors->get('diagnosa')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="tindakan" :value="__('Tindakan')" />
                            <textarea id="tindakan" name="tindakan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('tindakan') }}</textarea>
                            <x-input-error :messages="$errors->get('tindakan')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="resep_obat" :value="__('Resep Obat')" />
                            <textarea id="resep_obat" name="resep_obat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('resep_obat') }}</textarea>
                            <x-input-error :messages="$errors->get('resep_obat')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <textarea id="catatan" name="catatan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('catatan') }}</textarea>
                            <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.rekam-medis.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                            Batal
                        </a>
                        <x-primary-button>
                            {{ __('Simpan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

