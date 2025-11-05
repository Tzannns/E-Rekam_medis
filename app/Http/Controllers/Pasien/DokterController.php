<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use Illuminate\View\View;

class DokterController extends Controller
{
    public function index(): View
    {
        $dokter = Dokter::with('user')->latest()->paginate(15);
        return view('pasien.dokter.index', compact('dokter'));
    }
}
