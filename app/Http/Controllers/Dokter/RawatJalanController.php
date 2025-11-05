<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class RawatJalanController extends Controller
{
    public function index(): View
    {
        return view('dokter.rawat-jalan.index');
    }
}
