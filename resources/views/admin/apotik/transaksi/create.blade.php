<x-app-layout>
    <div x-data="kasirApp()">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Transaksi Baru</h2>
            <p class="mt-1 text-sm text-gray-500">Kasir Apotik</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.apotik.transaksi.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Input -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informasi Pembeli -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembeli</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="apotik_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Apotik <span class="text-red-500">*</span>
                                </label>
                                <select name="apotik_id" id="apotik_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                    @foreach ($apotiks as $apotik)
                                        <option value="{{ $apotik->id }}">{{ $apotik->nama_apotik }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="tipe_pembeli" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tipe Pembeli <span class="text-red-500">*</span>
                                </label>
                                <select name="tipe_pembeli" id="tipe_pembeli" x-model="tipePembeli"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                    <option value="Umum">Umum</option>
                                    <option value="Pasien">Pasien</option>
                                </select>
                            </div>

                            <div x-show="tipePembeli === 'Pasien'">
                                <label for="pasien_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pasien
                                </label>
                                <select name="pasien_id" id="pasien_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih Pasien</option>
                                    @foreach ($pasiens as $pasien)
                                        <option value="{{ $pasien->id }}">{{ $pasien->nama }} - {{ $pasien->nik }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="tipePembeli === 'Umum'">
                                <label for="nama_pembeli" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Pembeli
                                </label>
                                <input type="text" name="nama_pembeli" id="nama_pembeli"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Pilih Obat -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Obat</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Obat</label>
                                <select @change="tambahObat($event)"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih Obat</option>
                                    @foreach ($obats as $obat)
                                        <option value="{{ $obat->id }}" data-nama="{{ $obat->nama_obat }}"
                                            data-harga="{{ $obat->harga_jual }}" data-stok="{{ $obat->stok }}">
                                            {{ $obat->nama_obat }} - Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}
                                            (Stok: {{ $obat->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Daftar Obat Terpilih -->
                            <div x-show="items.length > 0">
                                <div class="border rounded-lg overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Obat
                                                </th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Harga
                                                </th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Jumlah
                                                </th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">
                                                    Subtotal</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <template x-for="(item, index) in items" :key="index">
                                                <tr>
                                                    <td class="px-4 py-2 text-sm text-gray-900" x-text="item.nama"></td>
                                                    <td class="px-4 py-2 text-sm text-gray-900"
                                                        x-text="formatRupiah(item.harga)"></td>
                                                    <td class="px-4 py-2">
                                                        <input type="number" x-model="item.jumlah"
                                                            @input="hitungTotal()" min="1" :max="item.stok"
                                                            class="w-20 px-2 py-1 border border-gray-300 rounded">
                                                        <input type="hidden" :name="'obat_id[]'" :value="item.id">
                                                        <input type="hidden" :name="'jumlah[]'" :value="item.jumlah">
                                                    </td>
                                                    <td class="px-4 py-2 text-sm font-medium text-gray-900"
                                                        x-text="formatRupiah(item.harga * item.jumlah)"></td>
                                                    <td class="px-4 py-2">
                                                        <button type="button" @click="hapusObat(index)"
                                                            class="text-red-600 hover:text-red-900">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div x-show="items.length === 0" class="text-center py-8 text-gray-500">
                                Belum ada obat dipilih
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary & Pembayaran -->
                <div class="space-y-6">
                    <div class="bg-white shadow rounded-lg p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan</h3>

                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium" x-text="formatRupiah(subtotal)"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Diskon</span>
                                <span class="font-medium">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Pajak</span>
                                <span class="font-medium">Rp 0</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between">
                                <span class="font-semibold text-lg">Total</span>
                                <span class="font-bold text-xl text-blue-600" x-text="formatRupiah(total)"></span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="metode_pembayaran"
                                    class="block text-sm font-medium text-gray-700 mb-2">
                                    Metode Pembayaran <span class="text-red-500">*</span>
                                </label>
                                <select name="metode_pembayaran" id="metode_pembayaran"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                    <option value="Tunai">Tunai</option>
                                    <option value="Debit">Debit</option>
                                    <option value="Kredit">Kredit</option>
                                    <option value="Transfer">Transfer</option>
                                    <option value="BPJS">BPJS</option>
                                </select>
                            </div>

                            <div>
                                <label for="bayar" class="block text-sm font-medium text-gray-700 mb-2">
                                    Bayar <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="bayar" id="bayar" x-model="bayar" @input="hitungKembalian()"
                                    min="0" step="1000"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">Kembalian</span>
                                    <span class="text-2xl font-bold"
                                        :class="kembalian >= 0 ? 'text-green-600' : 'text-red-600'"
                                        x-text="formatRupiah(kembalian)"></span>
                                </div>
                                <p x-show="kembalian < 0" class="text-xs text-red-600 mt-1">Pembayaran kurang!</p>
                            </div>

                            <div>
                                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Catatan
                                </label>
                                <textarea name="catatan" id="catatan" rows="2"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3">
                            <button type="submit" :disabled="items.length === 0 || kembalian < 0"
                                class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:bg-gray-400 disabled:cursor-not-allowed font-semibold">
                                Proses Transaksi
                            </button>
                            <a href="{{ route('admin.apotik.transaksi.index') }}"
                                class="block w-full px-4 py-2 border border-gray-300 rounded-lg text-center text-gray-700 hover:bg-gray-50 transition">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function kasirApp() {
            return {
                tipePembeli: 'Umum',
                items: [],
                subtotal: 0,
                total: 0,
                bayar: 0,
                kembalian: 0,

                tambahObat(event) {
                    const select = event.target;
                    const option = select.options[select.selectedIndex];

                    if (!option.value) return;

                    const id = option.value;
                    const nama = option.dataset.nama;
                    const harga = parseFloat(option.dataset.harga);
                    const stok = parseInt(option.dataset.stok);

                    // Cek apakah obat sudah ada
                    const existing = this.items.find(item => item.id === id);
                    if (existing) {
                        if (existing.jumlah < stok) {
                            existing.jumlah++;
                        } else {
                            alert('Stok tidak mencukupi!');
                        }
                    } else {
                        this.items.push({
                            id,
                            nama,
                            harga,
                            stok,
                            jumlah: 1
                        });
                    }

                    select.value = '';
                    this.hitungTotal();
                },

                hapusObat(index) {
                    this.items.splice(index, 1);
                    this.hitungTotal();
                },

                hitungTotal() {
                    this.subtotal = this.items.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
                    this.total = this.subtotal;
                    this.hitungKembalian();
                },

                hitungKembalian() {
                    this.kembalian = this.bayar - this.total;
                },

                formatRupiah(angka) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
                }
            }
        }
    </script>
</x-app-layout>
