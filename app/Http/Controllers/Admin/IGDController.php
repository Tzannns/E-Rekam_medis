<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class IGDController extends Controller
{
    public function index(): View
    {
        return view('admin.igd.index');
    }
}
