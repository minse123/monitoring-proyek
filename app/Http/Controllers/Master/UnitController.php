<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $unitsQuery = Unit::query();

        if ($search = trim((string) $request->input('search'))) {
            $unitsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('symbol', 'like', "%{$search}%");
            });
        }

        $perPage = $request->integer('per_page', 10) ?: 10;
        $perPage = max(min($perPage, 100), 1);

        $units = $unitsQuery
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();

        return view('master.units.index', [
            'units' => $units,
            'title' => 'Master Satuan',
            'user' => Auth::user(),
        ]);
    }

    public function create()
    {
        return view('master.units.create', [
            'title' => 'Tambah Satuan',
            'user' => Auth::user(),
        ]);
    }

    public function store(Request $request)
    {
        $unit = Unit::create($this->validateUnit($request));

        return redirect()
            ->route('units.show', $unit)
            ->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function show(Unit $unit)
    {
        return view('master.units.show', [
            'unit' => $unit,
            'title' => 'Detail Satuan',
            'user' => Auth::user(),
        ]);
    }

    public function edit(Unit $unit)
    {
        return view('master.units.edit', [
            'unit' => $unit,
            'title' => 'Ubah Satuan',
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request, Unit $unit)
    {
        $unit->update($this->validateUnit($request, $unit));

        return redirect()
            ->route('units.show', $unit)
            ->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        if ($unit->materials()->exists()) {
            return redirect()
                ->route('units.index')
                ->with('error', 'Satuan ini tidak dapat dihapus karena masih digunakan oleh material aktif.');
        }

        $unit->materials()->onlyTrashed()->forceDelete();

        $unit->delete();

        return redirect()
            ->route('units.index')
            ->with('success', 'Satuan berhasil dihapus.');
    }

    protected function validateUnit(Request $request, ?Unit $unit = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units', 'name')->ignore($unit?->getKey()),
            ],
            'symbol' => [
                'required',
                'string',
                'max:20',
                Rule::unique('units', 'symbol')->ignore($unit?->getKey()),
            ],
        ]);
    }
}
