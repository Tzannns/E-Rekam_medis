<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Edit User</h2>
                <p class="mt-1 text-sm text-gray-500">Perbarui data pengguna dan role.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:text-blue-800">&larr; Kembali</a>
        </div>

        <div class="bg-white shadow rounded-lg p-6 max-w-2xl">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="name" value="Nama" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $user->name) }}" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $user->email) }}" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label value="Role" />
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-2">
                        @foreach($roles as $roleName)
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" name="roles[]" value="{{ $roleName }}" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" {{ in_array($roleName, old('roles', $userRoleNames)) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">{{ $roleName }}</span>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">Batal</a>
                    <x-primary-button>Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>


