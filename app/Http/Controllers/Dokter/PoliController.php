<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\View\View;

class PoliController extends Controller
{
    public function index(): View
    {
        $polis = Poli::where('status', 'aktif')->latest()->paginate(15);

        return view('dokter.poli.index', compact('polis'));
    }

    public function show(Poli $poli): View
    {
        return view('dokter.poli.show', compact('poli'));
    }
}
