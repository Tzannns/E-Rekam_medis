<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laundry;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LaundryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Laundry::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('unit', 'like', "%{$search}%")
                    ->orWhere('item', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%");
            });
        }

        if ($request->has('unit') && $request->unit) {
            $query->where('unit', $request->unit);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('jenis') && $request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->has('tanggal_dari') && $request->tanggal_dari) {
            $query->where('tanggal_masuk', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai) {
            $query->where('tanggal_masuk', '<=', $request->tanggal_sampai . ' 23:59:59');
        }

        $laundries = $query->latest('tanggal_masuk')->paginate(15);

        return view('admin.laundry.index', compact('laundries'));
    }

    public function create(): View
    {
        return view('admin.laundry.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'unit' => ['required', 'string', 'max:255'],
            'item' => ['required', 'string', 'max:255'],
            'jenis' => ['nullable', 'string', 'max:255'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'berat_kg' => ['nullable', 'numeric', 'min:0'],
            'tanggal_masuk' => ['required', 'date_format:Y-m-d\TH:i'],
            'tanggal_selesai' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'status' => ['required', 'in:Menunggu,Sedang Diproses,Selesai'],
            'catatan' => ['nullable', 'string'],
        ]);

        $data['tanggal_masuk'] = Carbon::parse($data['tanggal_masuk']);
        if (!empty($data['tanggal_selesai'])) {
            $data['tanggal_selesai'] = Carbon::parse($data['tanggal_selesai']);
        }

        $laundry = Laundry::create($data);

        return redirect()->route('admin.laundry.show', $laundry)->with('success', 'Data laundry berhasil ditambahkan');
    }

    public function show(Laundry $laundry): View
    {
        return view('admin.laundry.show', compact('laundry'));
    }

    public function edit(Laundry $laundry): View
    {
        return view('admin.laundry.edit', compact('laundry'));
    }

    public function update(Request $request, Laundry $laundry): RedirectResponse
    {
        $data = $request->validate([
            'unit' => ['required', 'string', 'max:255'],
            'item' => ['required', 'string', 'max:255'],
            'jenis' => ['nullable', 'string', 'max:255'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'berat_kg' => ['nullable', 'numeric', 'min:0'],
            'tanggal_masuk' => ['required', 'date_format:Y-m-d\TH:i'],
            'tanggal_selesai' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'status' => ['required', 'in:Menunggu,Sedang Diproses,Selesai'],
            'catatan' => ['nullable', 'string'],
        ]);

        $data['tanggal_masuk'] = Carbon::parse($data['tanggal_masuk']);
        if (!empty($data['tanggal_selesai'])) {
            $data['tanggal_selesai'] = Carbon::parse($data['tanggal_selesai']);
        }

        $laundry->update($data);

        return redirect()->route('admin.laundry.show', $laundry)->with('success', 'Data laundry berhasil diperbarui');
    }

    public function destroy(Laundry $laundry): RedirectResponse
    {
        $laundry->delete();

        return redirect()->route('admin.laundry.index')->with('success', 'Data laundry berhasil dihapus');
    }
}
