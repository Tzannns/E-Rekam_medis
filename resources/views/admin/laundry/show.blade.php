<x-app-layout>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detail Laundry</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi pencucian/linen</p>
            </div>
            <div class="space-x-2">
                <a href="{{ route('admin.laundry.edit', $laundry) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 inline-block">Edit</a>
                <a href="{{ route('admin.laundry.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-600 inline-block">Kembali</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Data</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Unit</dt>
                        <dd class="text-lg text-gray-900">{{ $laundry->unit }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Item</dt>
                        <dd class="text-lg text-gray-900">{{ $laundry->item }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Jenis</dt>
                        <dd class="text-lg text-gray-900">{{ $laundry->jenis ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Jumlah</dt>
                        <dd class="text-lg text-gray-900">{{ $laundry->jumlah }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Berat (kg)</dt>
                        <dd class="text-lg text-gray-900">{{ $laundry->berat_kg ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Tanggal Masuk</dt>
                        <dd class="text-lg text-gray-900">{{ optional($laundry->tanggal_masuk)->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Tanggal Selesai</dt>
                        <dd class="text-lg text-gray-900">{{ optional($laundry->tanggal_selesai)->format('d/m/Y H:i') ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Status</dt>
                        <dd class="text-lg text-gray-900">{{ $laundry->status }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Catatan</dt>
                        <dd class="text-lg text-gray-900">{{ $laundry->catatan ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                <form action="{{ route('admin.laundry.destroy', $laundry) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    @include('components.sweet-alert')
</x-app-layout>
