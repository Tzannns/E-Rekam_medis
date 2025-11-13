<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\View\View;

class PoliController extends Controller
{
    public function index(): View
    {
        $polis = Poli::where('status', 'aktif')->latest()->paginate(15);

        return view('petugas.poli.index', compact('polis'));
    }

    public function show(Poli $poli): View
    {
        return view('petugas.poli.show', compact('poli'));
    }
}
