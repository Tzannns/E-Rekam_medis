<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Appointment;
use App\Models\RawatJalan;
use App\Models\TransaksiApotik;
use App\Models\Laundry;
use App\Models\Poli;
use App\Models\Dokter;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('admin.report.index');
    }

    public function appointments(Request $request)
    {
        $query = Appointment::with(['pasien.user', 'poli', 'dokter.user', 'jadwal']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('poli_id')) {
            $query->where('poli_id', (int) $request->input('poli_id'));
        }
        if ($request->filled('dokter_id')) {
            $query->where('dokter_id', (int) $request->input('dokter_id'));
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_usulan', '>=', $request->date('tanggal_dari'));
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_usulan', '<=', $request->date('tanggal_sampai'));
        }

        $appointments = $query->orderBy('tanggal_usulan', 'desc')->orderBy('jam_usulan')->paginate(20)->appends($request->query());

        if ($request->get('format') === 'csv') {
            return $this->streamCsv('laporan_appointment.csv', function ($out) use ($appointments) {
                fputcsv($out, ['Tanggal', 'Jam', 'Poli', 'Dokter', 'Pasien', 'Nomor Antrian', 'Status']);
                foreach ($appointments->items() as $a) {
                    fputcsv($out, [
                        optional($a->tanggal_usulan)->format('Y-m-d'),
                        $a->jam_usulan,
                        optional($a->poli)->nama_poli,
                        optional(optional($a->dokter)->user)->name,
                        optional(optional($a->pasien)->user)->name,
                        $a->nomor_antrian,
                        $a->status,
                    ]);
                }
            });
        }
        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('admin.report.pdf.appointments', [
                'items' => $appointments->items(),
                'filters' => $request->all(),
            ]);
            return $pdf->download('laporan_appointment_'.now()->format('Ymd_His').'.pdf');
        }

        $polis = Poli::orderBy('nama_poli')->get();
        $dokters = Dokter::with('user')->orderBy('id')->get();

        return view('admin.report.appointments', compact('appointments', 'polis', 'dokters'));
    }

    public function rawatJalan(Request $request)
    {
        $query = RawatJalan::with(['pasien.user', 'poli', 'dokter.user']);
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('poli_id')) {
            $query->where('poli_id', (int) $request->input('poli_id'));
        }
        if ($request->filled('dokter_id')) {
            $query->where('dokter_id', (int) $request->input('dokter_id'));
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_kunjungan', '>=', $request->date('tanggal_dari'));
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_kunjungan', '<=', $request->date('tanggal_sampai'));
        }
        $records = $query->orderBy('tanggal_kunjungan', 'desc')->paginate(20)->appends($request->query());

        if ($request->get('format') === 'csv') {
            return $this->streamCsv('laporan_rawat_jalan.csv', function ($out) use ($records) {
                fputcsv($out, ['Tanggal', 'Poli', 'Dokter', 'Pasien', 'Status']);
                foreach ($records->items() as $r) {
                    fputcsv($out, [
                        optional($r->tanggal_kunjungan)->format('Y-m-d'),
                        optional($r->poli)->nama_poli,
                        optional(optional($r->dokter)->user)->name,
                        optional(optional($r->pasien)->user)->name,
                        $r->status,
                    ]);
                }
            });
        }
        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('admin.report.pdf.rawat-jalan', [
                'items' => $records->items(),
                'filters' => $request->all(),
            ]);
            return $pdf->download('laporan_rawat_jalan_'.now()->format('Ymd_His').'.pdf');
        }

        $polis = Poli::orderBy('nama_poli')->get();
        $dokters = Dokter::with('user')->orderBy('id')->get();

        return view('admin.report.rawat-jalan', compact('records', 'polis', 'dokters'));
    }

    public function apotik(Request $request)
    {
        $query = TransaksiApotik::with(['pasien.user', 'user']);
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->date('tanggal_dari'));
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->date('tanggal_sampai'));
        }
        $transactions = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->query());

        if ($request->get('format') === 'csv') {
            return $this->streamCsv('laporan_apotik.csv', function ($out) use ($transactions) {
                fputcsv($out, ['Tanggal', 'No Transaksi', 'Pembeli', 'Total', 'Status']);
                foreach ($transactions->items() as $t) {
                    fputcsv($out, [
                        optional($t->created_at)->format('Y-m-d H:i'),
                        $t->no_transaksi,
                        $t->nama_pembeli ?: optional(optional($t->pasien)->user)->name,
                        $t->total,
                        $t->status,
                    ]);
                }
            });
        }
        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('admin.report.pdf.apotik', [
                'items' => $transactions->items(),
                'filters' => $request->all(),
            ]);
            return $pdf->download('laporan_apotik_'.now()->format('Ymd_His').'.pdf');
        }

        return view('admin.report.apotik', compact('transactions'));
    }

    public function laundry(Request $request)
    {
        $query = Laundry::query();
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_masuk', '>=', $request->date('tanggal_dari'));
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_masuk', '<=', $request->date('tanggal_sampai'));
        }
        $items = $query->orderBy('tanggal_masuk', 'desc')->paginate(20)->appends($request->query());

        if ($request->get('format') === 'csv') {
            return $this->streamCsv('laporan_laundry.csv', function ($out) use ($items) {
                fputcsv($out, ['Tanggal Masuk', 'Unit', 'Item', 'Jenis', 'Jumlah', 'Berat (kg)', 'Status']);
                foreach ($items->items() as $i) {
                    fputcsv($out, [
                        optional($i->tanggal_masuk)->format('Y-m-d H:i'),
                        $i->unit,
                        $i->item,
                        $i->jenis,
                        $i->jumlah,
                        $i->berat_kg,
                        $i->status,
                    ]);
                }
            });
        }
        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('admin.report.pdf.laundry', [
                'items' => $items->items(),
                'filters' => $request->all(),
            ]);
            return $pdf->download('laporan_laundry_'.now()->format('Ymd_His').'.pdf');
        }

        return view('admin.report.laundry', compact('items'));
    }

    protected function streamCsv(string $filename, \Closure $writer): StreamedResponse
    {
        return response()->streamDownload(function () use ($writer) {
            $out = fopen('php://output', 'w');
            $writer($out);
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}