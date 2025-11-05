<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(auth()->user()->hasRole('Pasien'))
                @php($pasien = auth()->user()->pasien)

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-3xl">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Data Profil Pasien</h3>

                        @if(!$pasien)
                            <div class="flex items-start justify-between">
                                <p class="text-gray-600">Anda belum melengkapi data profil pasien.</p>
                                <a href="{{ route('pasien.profil.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">Lengkapi Profil</a>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <div class="text-sm text-gray-500">NIK</div>
                                    <div class="mt-1 text-gray-900 font-medium">{{ $pasien->nik }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Tanggal Lahir</div>
                                    <div class="mt-1 text-gray-900 font-medium">{{ $pasien->tanggal_lahir?->format('d M Y') }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Jenis Kelamin</div>
                                    <div class="mt-1 text-gray-900 font-medium">{{ $pasien->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">No. Telepon</div>
                                    <div class="mt-1 text-gray-900 font-medium">{{ $pasien->no_telp }}</div>
                                </div>
                                <div class="md:col-span-2">
                                    <div class="text-sm text-gray-500">Alamat</div>
                                    <div class="mt-1 text-gray-900 font-medium">{{ $pasien->alamat }}</div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('pasien.profil.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">Ubah Profil Pasien</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
