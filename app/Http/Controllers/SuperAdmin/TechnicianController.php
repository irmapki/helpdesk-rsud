<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TechnicianController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::technicians()->with(['unit', 'assignedTickets']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $technicians = $query->get()->map(function ($tech) {
            $tech->active_tickets = $tech->assignedTickets
                ->whereIn('status', ['open', 'assigned', 'in_progress'])
                ->count();
            $tech->resolved_tickets = $tech->assignedTickets
                ->whereIn('status', ['resolved', 'closed'])
                ->count();
            return $tech;
        });

        return view('superadmin.technicians.index', compact('technicians'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'specialization' => ['required', 'string', 'max:255'],
        ]);

        // Generate email dummy otomatis di backend agar SuperAdmin tidak perlu input email
        $slug = \Illuminate\Support\Str::slug($validated['name']);
        $dummyEmail = $slug . '_' . time() . '@teknisi.rsud.local';

        User::create([
            'name' => $validated['name'],
            'email' => $dummyEmail,
            'phone' => $validated['phone'],
            'specialization' => $validated['specialization'],
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role_id' => 3, // Role Teknisi
            'is_active' => true,
        ]);

        return redirect()->route('superadmin.technicians.index')
            ->with('success', "Teknisi {$validated['name']} berhasil didaftarkan ke sistem.");
    }

    public function edit(User $technician): View
    {
        if (!$technician->hasRole('teknisi')) {
            abort(404, 'User bukan teknisi.');
        }

        return view('superadmin.technicians.edit', compact('technician'));
    }

    public function update(Request $request, User $technician): RedirectResponse
    {
        if (!$technician->hasRole('teknisi')) {
            abort(404, 'User bukan teknisi.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $technician->update($validated);

        return redirect()->route('superadmin.technicians.index')
            ->with('success', "Data teknisi {$technician->name} berhasil diperbarui.");
    }

    public function destroy(User $technician): RedirectResponse
    {
        if (!$technician->hasRole('teknisi')) {
            abort(404, 'User bukan teknisi.');
        }

        // Jangan hapus akun master teknisi posko jika itu teknisi@rsud.test
        if ($technician->email === 'teknisi@rsud.test') {
            return redirect()->route('superadmin.technicians.index')
                ->with('error', 'Akun master Teknisi IT RSUD tidak dapat dihapus.');
        }

        $name = $technician->name;
        // Pindahkan tiket aktif ke master akun teknisi jika ada
        $masterTech = User::where('email', 'teknisi@rsud.test')->first();
        if ($masterTech) {
            \App\Models\Ticket::where('assigned_to', $technician->id)->update(['assigned_to' => $masterTech->id]);
        }

        $technician->delete();

        return redirect()->route('superadmin.technicians.index')
            ->with('success', "Data teknisi {$name} berhasil dihapus.");
    }
}
