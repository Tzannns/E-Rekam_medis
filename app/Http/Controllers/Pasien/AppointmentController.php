<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Dokter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(): View
    {
        $pasien = Auth::user()->pasien;
        $appointments = Appointment::where('pasien_id', $pasien->id)
            ->with('dokter.user')
            ->latest()
            ->paginate(15);

        return view('pasien.appointment.index', compact('appointments'));
    }

    public function create(): View
    {
        $dokterList = Dokter::with('user')->get();

        return view('pasien.appointment.create', compact('dokterList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $pasien = Auth::user()->pasien;
        $data = $request->validate([
            'dokter_id' => ['required', 'exists:dokter,id'],
            'tanggal_usulan' => ['required', 'date'],
            'jam_usulan' => ['required', 'string'],
            'keluhan' => ['nullable', 'string'],
        ]);

        $data['pasien_id'] = $pasien->id;
        $data['status'] = 'Menunggu';

        Appointment::create($data);

        return redirect()->route('pasien.appointment.index')->with('success', 'Permohonan periksa berhasil dikirim. Menunggu konfirmasi.');
    }
}
