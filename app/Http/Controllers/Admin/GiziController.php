<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gizi;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GiziController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $tanggalDari = $request->get('tanggal_dari');
        $tanggalSampai = $request->get('tanggal_sampai');

        $gizi = Gizi::with('pasien')
            ->when($search, function ($query, $search) {
                return $query->whereHas('pasien', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })
                    ->orWhere('jenis_makanan', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($tanggalDari, function ($query, $tanggalDari) {
                return $query->whereDate('tanggal', '>=', $tanggalDari);
            })
            ->when($tanggalSampai, function ($query, $tanggalSampai) {
                return $query->whereDate('tanggal', '<=', $tanggalSampai);
            })
            ->latest()
            ->paginate(15);

        return view('admin.gizi.index', compact('gizi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasien = Pasien::with('user')->get();

        return view('admin.gizi.create', compact('pasien'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'tanggal' => 'required|date',
            'jenis_makanan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,diberikan,ditolak',
        ]);

        DB::beginTransaction();
        try {
            Gizi::create($validated);
            DB::commit();

            return redirect()->route('admin.gizi.index')->with('success', 'Data gizi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Gizi $gizi)
    {
        $gizi->load('pasien');

        return view('admin.gizi.show', compact('gizi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gizi $gizi)
    {
        $pasien = Pasien::with('user')->get();

        return view('admin.gizi.edit', compact('gizi', 'pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gizi $gizi)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'tanggal' => 'required|date',
            'jenis_makanan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,diberikan,ditolak',
        ]);

        DB::beginTransaction();
        try {
            $gizi->update($validated);
            DB::commit();

            return redirect()->route('admin.gizi.index')->with('success', 'Data gizi berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->withInput()->with('error', 'Terjadi kesalahan saat update data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gizi $gizi)
    {
        DB::beginTransaction();
        try {
            $gizi->delete();
            DB::commit();

            return redirect()->route('admin.gizi.index')->with('success', 'Data gizi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }
}
