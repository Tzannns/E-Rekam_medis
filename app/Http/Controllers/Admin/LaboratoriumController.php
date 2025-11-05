<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LaboratoriumController extends Controller
{
    public function index(): View
    {
        return view('admin.laboratorium.index');
    }
}
