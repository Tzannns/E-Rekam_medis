<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class RawatInapController extends Controller
{
    public function index(): View
    {
        return view('dokter.rawat-inap.index');
    }
}
