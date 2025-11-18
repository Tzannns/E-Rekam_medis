<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Laboratorium;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LaboratoriumController extends Controller
{
    public function index(Request $request): View
    {
        $dokter = Auth::user()->dokter;

        $query = Laboratorium::where('dokter_id', $dokter->id)
            ->with(['pasien.user']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('jenis_pemeriksaan', 'like', "%{$search}%")
                    ->orWhere('hasil', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%");
            });
        }

        if ($request->has('pasien_id') && $request->pasien_id) {
            $query->where('pasien_id', $request->pasien_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->where('tanggal_periksa', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->where('tanggal_periksa', '<=', $request->tanggal_sampai.' 23:59:59');
        }

        $labs = $query->latest('tanggal_periksa')->paginate(15);
        $pasienList = Pasien::with('user')->get();

        return view('dokter.laboratorium.index', compact('labs', 'pasienList'));
    }
}
