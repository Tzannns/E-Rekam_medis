<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class KasirController extends Controller
{
    public function index(): View
    {
        return view('admin.kasir.index');
    }
}
