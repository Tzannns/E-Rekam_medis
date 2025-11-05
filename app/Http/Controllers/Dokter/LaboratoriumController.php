<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LaboratoriumController extends Controller
{
    public function index(): View
    {
        return view('dokter.laboratorium.index');
    }
}
