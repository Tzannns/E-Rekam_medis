<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePoliRequest;
use App\Http\Requests\Admin\UpdatePoliRequest;
use App\Models\Poli;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PoliController extends Controller
{
    public function index(): View
    {
        $polis = Poli::latest()->paginate(15);

        return view('admin.poli.index', compact('polis'));
    }

    public function create(): View
    {
        return view('admin.poli.create');
    }

    public function store(StorePoliRequest $request): RedirectResponse
    {
        Poli::create($request->validated());

        return redirect()
            ->route('admin.poli.index')
            ->with('success', 'Data poli berhasil ditambahkan');
    }

    public function show(Poli $poli): View
    {
        return view('admin.poli.show', compact('poli'));
    }

    public function edit(Poli $poli): View
    {
        return view('admin.poli.edit', compact('poli'));
    }

    public function update(UpdatePoliRequest $request, Poli $poli): RedirectResponse
    {
        $poli->update($request->validated());

        return redirect()
            ->route('admin.poli.show', $poli)
            ->with('success', 'Data poli berhasil diperbarui');
    }

    public function destroy(Poli $poli): RedirectResponse
    {
        $poli->delete();

        return redirect()
            ->route('admin.poli.index')
            ->with('success', 'Data poli berhasil dihapus');
    }
}
