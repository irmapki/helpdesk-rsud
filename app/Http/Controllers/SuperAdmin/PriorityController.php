<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PriorityController extends Controller
{
    public function index(): View
    {
        $priorities = Priority::withCount('tickets')->orderBy('sla_hours', 'asc')->get();

        return view('superadmin.priorities.index', compact('priorities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:priorities,name'],
            'sla_hours' => ['required', 'integer', 'min:1', 'max:720'],
            'color' => ['required', 'string', 'in:red,yellow,green,blue,gray,purple'],
            'description' => ['nullable', 'string'],
        ]);

        Priority::create($validated);

        return redirect()->route('superadmin.priorities.index')
            ->with('success', 'Tingkat prioritas & konfigurasi SLA berhasil ditambahkan.');
    }

    public function update(Request $request, Priority $priority): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:priorities,name,' . $priority->id],
            'sla_hours' => ['required', 'integer', 'min:1', 'max:720'],
            'color' => ['required', 'string', 'in:red,yellow,green,blue,gray,purple'],
            'description' => ['nullable', 'string'],
        ]);

        $priority->update($validated);

        return redirect()->route('superadmin.priorities.index')
            ->with('success', 'Konfigurasi prioritas & SLA berhasil diperbarui.');
    }

    public function destroy(Priority $priority): RedirectResponse
    {
        if ($priority->tickets()->count() > 0) {
            return redirect()->route('superadmin.priorities.index')
                ->with('error', 'Prioritas ini tidak dapat dihapus karena masih digunakan pada tiket.');
        }

        $priority->delete();

        return redirect()->route('superadmin.priorities.index')
            ->with('success', 'Prioritas berhasil dihapus.');
    }
}
