<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class RawatJalanController extends Controller
{
    public function index(): View
    {
        return view('admin.rawat-jalan.index');
    }
}
