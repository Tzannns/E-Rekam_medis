<x-app-layout>
    <div>
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Edit Data Petugas</h2>
            <p class="mt-1 text-sm text-gray-500">Update data petugas</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.petugas.update', $petuga) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" required
                            value="{{ old('name', $petuga->name) }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" />
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" required
                            value="{{ old('email', $petuga->email) }}"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror" />
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru
                            <span class="text-gray-500 text-xs">(Kosongkan jika tidak ingin mengubah)</span></label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 @enderror" />
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                            Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password_confirmation') border-red-500 @enderror" />
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-6 border-t">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Perbarui
                    </button>
                    <a href="{{ route('admin.petugas.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

