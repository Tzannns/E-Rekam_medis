<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Isi Riwayat Medis</h2>
            <p class="mt-1 text-sm text-gray-500">Lengkapi informasi riwayat kesehatan Anda</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('pasien.rekam-medis.store') }}" method="POST" class="p-6">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="tanggal_periksa" class="block text-sm font-medium text-gray-700">
                            Tanggal Periksa <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="tanggal_periksa" 
                               id="tanggal_periksa"
                               value="{{ old('tanggal_periksa', date('Y-m-d')) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                        @error('tanggal_periksa')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="keluhan" class="block text-sm font-medium text-gray-700">
                            Keluhan Saat Ini
                        </label>
                        <textarea name="keluhan" 
                                  id="keluhan" 
                                  rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Jelaskan keluhan yang Anda rasakan saat ini...">{{ old('keluhan') }}</textarea>
                        @error('keluhan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="riwayat_penyakit" class="block text-sm font-medium text-gray-700">
                            Riwayat Penyakit
                        </label>
                        <textarea name="riwayat_penyakit" 
                                  id="riwayat_penyakit" 
                                  rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Contoh: Diabetes, Hipertensi, Asma, dll...">{{ old('riwayat_penyakit') }}</textarea>
                        @error('riwayat_penyakit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="alergi_obat" class="block text-sm font-medium text-gray-700">
                            Alergi Obat
                        </label>
                        <textarea name="alergi_obat" 
                                  id="alergi_obat" 
                                  rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Sebutkan obat-obat yang menyebabkan alergi (jika ada)...">{{ old('alergi_obat') }}</textarea>
                        @error('alergi_obat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700">
                            Catatan Tambahan
                        </label>
                        <textarea name="catatan" 
                                  id="catatan" 
                                  rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Informasi tambahan yang perlu dokter ketahui...">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <a href="{{ route('pasien.jadwal.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
                        Simpan Riwayat Medis
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
