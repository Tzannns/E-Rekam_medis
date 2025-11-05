<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class RawatInapController extends Controller
{
    public function index(): View
    {
        return view('admin.rawat-inap.index');
    }
}
