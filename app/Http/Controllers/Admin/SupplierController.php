<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        try {
            $search = request('search');
            $status = request('status');

            $suppliers = Supplier::query()
                ->when($search, function ($query, $search) {
                    return $query->where('nama_supplier', 'like', "%{$search}%")
                        ->orWhere('kode_supplier', 'like', "%{$search}%");
                })
                ->when($status && $status !== 'semua', function ($query) use ($status) {
                    return $query->where('status', $status);
                })
                ->latest()
                ->paginate(15);

            return view('admin.apotik.supplier.index', compact('suppliers'));
        } catch (\Exception $e) {
            \Log::error('Supplier Index Error: ' . $e->getMessage());
            return response('Error: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        return view('admin.apotik.supplier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_supplier' => 'required|string|max:50|unique:suppliers',
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'contact_person' => 'nullable|string|max:255',
        ]);

        $validated['status'] = 'Aktif';

        Supplier::create($validated);

        return redirect()->route('admin.apotik.supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load('obats');
        return view('admin.apotik.supplier.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.apotik.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'contact_person' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $supplier->update($validated);

        return redirect()->route('admin.apotik.supplier.show', $supplier)
            ->with('success', 'Data supplier berhasil diperbarui');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('admin.apotik.supplier.index')
            ->with('success', 'Data supplier berhasil dihapus');
    }
}
