<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\View\View;

class PoliController extends Controller
{
    public function index(): View
    {
        $polis = Poli::where('status', 'aktif')->latest()->paginate(15);

        return view('pasien.poli.index', compact('polis'));
    }

    public function show(Poli $poli): View
    {
        return view('pasien.poli.show', compact('poli'));
    }
}
