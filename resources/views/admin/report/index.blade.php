<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Laporan</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.report.appointments') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition border">
                    <p class="text-sm font-medium text-gray-900">Antrian Online</p>
                    <p class="text-xs text-gray-500">Laporan Appointment</p>
                </a>
                <a href="{{ route('admin.report.rawat-jalan') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition border">
                    <p class="text-sm font-medium text-gray-900">Rawat Jalan</p>
                    <p class="text-xs text-gray-500">Laporan Kunjungan RJ</p>
                </a>
                <a href="{{ route('admin.report.apotik') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition border">
                    <p class="text-sm font-medium text-gray-900">Apotik</p>
                    <p class="text-xs text-gray-500">Laporan Transaksi</p>
                </a>
                <a href="{{ route('admin.report.laundry') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition border">
                    <p class="text-sm font-medium text-gray-900">Laundry</p>
                    <p class="text-xs text-gray-500">Laporan Item Laundry</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>