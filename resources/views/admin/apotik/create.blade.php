<x-app-layout>
    <div>
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.apotik.index') }}" class="text-blue-600 hover:text-blue-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Tambah Apotik</h2>
                <p class="mt-1 text-sm text-gray-500">Tambahkan data apotik baru</p>
            </div>
        </div>

        <form action="{{ route('admin.apotik.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode Apotik -->
                    <div>
                        <label for="kode_apotik" class="block text-sm font-medium text-gray-700 mb-1">Kode Apotik
                            <span class="text-red-500">*</span></label>
                        <input type="text" id="kode_apotik" name="kode_apotik" value="{{ old('kode_apotik') }}"
                            placeholder="Contoh: APT0001"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                        @error('kode_apotik')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Apotik -->
                    <div>
                        <label for="nama_apotik" class="block text-sm font-medium text-gray-700 mb-1">Nama Apotik
                            <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_apotik" name="nama_apotik" value="{{ old('nama_apotik') }}"
                            placeholder="Nama apotik"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                        @error('nama_apotik')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
                            placeholder="Alamat apotik"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('lokasi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}"
                            placeholder="08xx-xxxx-xxxx"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('telepon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="email@apotik.com"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Simpan
                </button>
                <a href="{{ route('admin.apotik.index') }}"
                    class="px-6 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
