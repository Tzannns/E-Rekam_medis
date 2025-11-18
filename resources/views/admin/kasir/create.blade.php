<x-app-layout>
    <div>
        @php($prefix = \Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'petugas.') ? 'petugas' : 'admin')
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">Buat Transaksi Kasir</h2>
                <p class="text-sm text-gray-500">Input item layanan dan pembayaran</p>
            </div>
            <a href="{{ route($prefix . '.kasir.index') }}" class="text-indigo-600">Kembali</a>
        </div>

        <form method="POST" action="{{ route($prefix . '.kasir.store') }}" x-data="kasirForm()"
            class="bg-white shadow rounded p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm">Pasien</label>
                    <select name="pasien_id" class="border rounded w-full px-3 py-2" required>
                        <option value="">Pilih Pasien</option>
                        @foreach ($pasienList as $p)
                            <option value="{{ $p->id }}">{{ $p->user?->name }} - {{ $p->nik }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm">Tanggal</label>
                    <input type="datetime-local" name="tanggal" class="border rounded w-full px-3 py-2" required>
                </div>
            </div>

            <div class="mt-6">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-medium">Item</h3>
                    <button type="button" @click="addItem()" class="px-3 py-1 bg-indigo-600 text-white rounded">Tambah
                        Item</button>
                </div>
                <template x-for="(item, idx) in items" :key="idx">
                    <div class="grid grid-cols-12 gap-2 mb-2">
                        <div class="col-span-5">
                            <input type="text" :name="`items[${idx}][deskripsi]`" x-model="item.deskripsi"
                                placeholder="Deskripsi" class="border rounded w-full px-3 py-2" required>
                        </div>
                        <div class="col-span-2">
                            <input type="number" min="1" :name="`items[${idx}][qty]`" x-model.number="item.qty"
                                class="border rounded w-full px-3 py-2" required>
                        </div>
                        <div class="col-span-3">
                            <input type="number" step="0.01" min="0" :name="`items[${idx}][harga]`"
                                x-model.number="item.harga" class="border rounded w-full px-3 py-2" required>
                        </div>
                        <div class="col-span-2 text-right flex items-center justify-end">
                            <span class="px-2">Rp <span x-text="formatCurrency(item.qty * item.harga)"></span></span>
                            <button type="button" @click="removeItem(idx)" class="ml-2 text-red-600">Hapus</button>
                        </div>
                    </div>
                </template>

                <input type="hidden" name="items_count" :value="items.length">
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm">Diskon</label>
                    <input type="number" step="0.01" min="0" name="diskon" x-model.number="diskon"
                        class="border rounded w-full px-3 py-2">
                </div>
                <div class="md:col-span-2 text-right">
                    <div class="space-y-1">
                        <div>Subtotal: Rp <span x-text="formatCurrency(subtotal())"></span></div>
                        <div>Diskon: Rp <span x-text="formatCurrency(diskon)"></span></div>
                        <div class="font-bold">Total: Rp <span x-text="formatCurrency(total())"></span></div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm">Catatan</label>
                <textarea name="catatan" class="border rounded w-full px-3 py-2" rows="3"></textarea>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        function kasirForm() {
            return {
                items: [{
                    deskripsi: '',
                    qty: 1,
                    harga: 0
                }],
                diskon: 0,
                addItem() {
                    this.items.push({
                        deskripsi: '',
                        qty: 1,
                        harga: 0
                    });
                },
                removeItem(i) {
                    this.items.splice(i, 1);
                },
                subtotal() {
                    return this.items.reduce((s, it) => s + (Number(it.qty) * Number(it.harga)), 0);
                },
                total() {
                    return Math.max(this.subtotal() - Number(this.diskon || 0), 0);
                },
                formatCurrency(n) {
                    return Number(n).toLocaleString('id-ID', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            }
        }
    </script>
</x-app-layout>
