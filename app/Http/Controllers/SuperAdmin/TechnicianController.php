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
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:6'],
            'phone' => ['required', 'string', 'max:30'],
            'specialization' => ['required', 'string', 'max:255'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'specialization' => $validated['specialization'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password'] ?: 'password'),
            'role_id' => 3, // Role Teknisi
            'is_active' => true,
        ]);

        return redirect()->route('superadmin.technicians.index')
            ->with('success', "Akun teknisi {$validated['name']} ({$validated['email']}) berhasil didaftarkan.");
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
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $technician->id],
            'password' => ['nullable', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:30'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'specialization_group' => ['required', 'in:hardware,software'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'specialization' => $validated['specialization'],
            'is_active' => $request->has('is_active'),
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $technician->update($updateData);

        return redirect()->route('superadmin.technicians.index')
            ->with('success', "Data akun teknisi {$technician->name} berhasil diperbarui.");
    }

    public function destroy(User $technician): RedirectResponse
    {
        if (!$technician->hasRole('teknisi')) {
            abort(404, 'User bukan teknisi.');
        }

        $name = $technician->name;
        // Hapus penugasan tiket atau lepas penugasan
        \App\Models\Ticket::where('assigned_to', $technician->id)->update(['assigned_to' => null, 'status' => 'open']);

        $technician->delete();

        return redirect()->route('superadmin.technicians.index')
            ->with('success', "Data teknisi {$name} berhasil dihapus.");
    }
}
