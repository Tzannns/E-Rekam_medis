<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\View\View;

class PasienController extends Controller
{
    public function index(): View
    {
        $pasien = Pasien::with('user')->latest()->paginate(15);

        return view('admin.pasien.index', compact('pasien'));
    }
}
