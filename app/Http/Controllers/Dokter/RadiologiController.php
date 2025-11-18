<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Radiologi;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RadiologiController extends Controller
{
    public function index(): View
    {
        $dokter = Auth::user()->dokter;
        
        $labs = Radiologi::with(['pasien.user', 'dokter.user'])
            ->where('dokter_id', $dokter->id)
            ->latest()
            ->paginate(15);

        return view('dokter.radiologi.index', compact('labs'));
    }
}
