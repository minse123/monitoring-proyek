<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliersQuery = Supplier::query();

        if ($search = trim((string) $request->input('search'))) {
            $suppliersQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('npwp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('rating')) {
            $minRating = max(min($request->integer('rating', 0), 5), 0);
            $suppliersQuery->where('rating', '>=', $minRating);
        }

        $perPage = $request->integer('per_page', 10) ?: 10;
        $perPage = max(min($perPage, 100), 1);

        $suppliers = $suppliersQuery
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();

        return view('master.suppliers.index', [
            'suppliers' => $suppliers,
            'title' => 'Master Supplier',
            'user' => Auth::user(),
        ]);
    }

    public function create()
    {
        return view('master.suppliers.create', [
            'title' => 'Tambah Supplier',
            'user' => Auth::user(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateSupplier($request);

        $validated['rating'] = $validated['rating'] ?? 0;

        $supplier = Supplier::create($validated);

        return redirect()
            ->route('suppliers.show', $supplier)
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier)
    {
        return view('master.suppliers.show', [
            'supplier' => $supplier,
            'title' => 'Detail Supplier',
            'user' => Auth::user(),
        ]);
    }

    public function edit(Supplier $supplier)
    {
        return view('master.suppliers.edit', [
            'supplier' => $supplier,
            'title' => 'Ubah Supplier',
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $this->validateSupplier($request, $supplier);

        $validated['rating'] = $validated['rating'] ?? 0;

        $supplier->update($validated);

        return redirect()
            ->route('suppliers.show', $supplier)
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }

    protected function validateSupplier(Request $request, ?Supplier $supplier = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'npwp' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'rating' => ['nullable', 'integer', 'min:0', 'max:5'],
        ]);
    }
}
