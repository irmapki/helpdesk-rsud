<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UnitController extends Controller
{
    public function index(): View
    {
        $units = Unit::withCount(['users', 'tickets'])->latest()->get();

        return view('superadmin.units.index', compact('units'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:units,name'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Unit::create($validated);

        return redirect()->route('superadmin.units.index')
            ->with('success', 'Unit / Bagian RSUD berhasil ditambahkan.');
    }

    public function update(Request $request, Unit $unit): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:units,name,' . $unit->id],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $unit->update($validated);

        return redirect()->route('superadmin.units.index')
            ->with('success', 'Unit / Bagian RSUD berhasil diperbarui.');
    }

    public function destroy(Unit $unit): RedirectResponse
    {
        if ($unit->tickets()->count() > 0 || $unit->users()->count() > 0) {
            return redirect()->route('superadmin.units.index')
                ->with('error', 'Unit tidak dapat dihapus karena masih memiliki user atau riwayat tiket terkait.');
        }

        $unit->delete();

        return redirect()->route('superadmin.units.index')
            ->with('success', 'Unit / Bagian RSUD berhasil dihapus.');
    }
}
