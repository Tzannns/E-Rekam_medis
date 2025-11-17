<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apotik;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApotikController extends Controller
{
    public function index(): View
    {
        $search = request('search');
        $status = request('status');

        $apotiks = Apotik::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_apotik', 'like', "%{$search}%")
                    ->orWhere('kode_apotik', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
            })
            ->when($status && $status !== 'semua', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        $totalApotik = Apotik::count();
        $apotikAktif = Apotik::where('status', 'Aktif')->count();

        return view('admin.apotik.index', compact('apotiks', 'totalApotik', 'apotikAktif'));
    }

    public function create(): View
    {
        return view('admin.apotik.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_apotik' => 'required|string|max:50|unique:apotiks',
            'nama_apotik' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $validated['status'] = 'Aktif';

        Apotik::create($validated);

        return redirect()->route('admin.apotik.index')
            ->with('success', 'Apotik berhasil ditambahkan');
    }

    public function show(Apotik $apotik): View
    {
        return view('admin.apotik.show', compact('apotik'));
    }

    public function edit(Apotik $apotik): View
    {
        return view('admin.apotik.edit', compact('apotik'));
    }

    public function update(Request $request, Apotik $apotik)
    {
        $validated = $request->validate([
            'nama_apotik' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $apotik->update($validated);

        return redirect()->route('admin.apotik.show', $apotik)
            ->with('success', 'Data apotik berhasil diperbarui');
    }

    public function destroy(Apotik $apotik)
    {
        $apotik->delete();

        return redirect()->route('admin.apotik.index')
            ->with('success', 'Data apotik berhasil dihapus');
    }
}
