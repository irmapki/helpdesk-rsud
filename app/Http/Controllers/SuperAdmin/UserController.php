<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::with(['roles', 'role', 'unit']);

        // Tab filter (Semua, Admin, Teknisi, Supervisor)
        $tab = $request->query('tab', 'semua');
        if ($tab !== 'semua') {
            $query->where(function ($sub) use ($tab) {
                $sub->whereHas('roles', function ($q) use ($tab) {
                    $q->where('name', $tab);
                })->orWhereHas('role', function ($q) use ($tab) {
                    $q->where('name', $tab);
                });
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $roles = Role::all();
        $units = Unit::all();

        // Summary Stats
        $totalUsers = User::count();
        $totalTechnicians = User::technicians()->active()->count();
        $activeTicketsCount = Ticket::whereIn('status', ['open', 'assigned', 'in_progress'])->count();
        $approachingSlaCount = Ticket::whereIn('status', ['open', 'assigned', 'in_progress'])->count();
        
        // SLA Compliance calculation
        $totalResolved = Ticket::whereIn('status', ['resolved', 'closed'])->count();
        $onTimeResolved = Ticket::whereIn('status', ['resolved', 'closed'])->whereNull('rejection_reason')->count();
        $slaCompliance = $totalResolved > 0 ? round(($onTimeResolved / $totalResolved) * 100) : 96;

        // Master Data Counts
        $categoriesCount = Category::count();
        $prioritiesCount = Priority::count();
        $unitsCount = Unit::count();
        $priorities = Priority::orderBy('sla_hours', 'asc')->get();

        return view('superadmin.users.index', compact(
            'users',
            'roles',
            'units',
            'tab',
            'totalUsers',
            'totalTechnicians',
            'activeTicketsCount',
            'approachingSlaCount',
            'slaCompliance',
            'categoriesCount',
            'prioritiesCount',
            'unitsCount',
            'priorities'
        ));
    }

    public function create(): View
    {
        $roles = Role::all();
        $units = Unit::all();

        return view('superadmin.users.create', compact('roles', 'units'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', Password::defaults()],
            'roles' => ['nullable', 'array', 'min:1'],
            'roles.*' => ['string', 'exists:roles,name'],
            'role_id' => ['nullable', 'exists:roles,id'],
            'unit_id' => ['nullable', 'exists:units,id'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        $roleNames = $request->input('roles', []);
        if (empty($roleNames) && $request->filled('role_id')) {
            $roleObj = Role::find($request->role_id);
            if ($roleObj) $roleNames = [$roleObj->name];
        }
        if (empty($roleNames)) {
            return back()->withErrors(['roles' => 'Minimal pilih satu role / hak akses akun.'])->withInput();
        }

        $primaryRole = Role::where('name', $roleNames[0])->first();
        $validated['role_id'] = $primaryRole ? $primaryRole->id : null;
        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');
        unset($validated['roles']);

        $user = User::create($validated);
        $user->syncRoles($roleNames);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User dan hak akses multi-role berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        $units = Unit::all();
        $user->load('roles');

        return view('superadmin.users.edit', compact('user', 'roles', 'units'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', Password::defaults()],
            'roles' => ['nullable', 'array', 'min:1'],
            'roles.*' => ['string', 'exists:roles,name'],
            'role_id' => ['nullable', 'exists:roles,id'],
            'unit_id' => ['nullable', 'exists:units,id'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        $roleNames = $request->input('roles', []);
        if (empty($roleNames) && $request->filled('role_id')) {
            $roleObj = Role::find($request->role_id);
            if ($roleObj) $roleNames = [$roleObj->name];
        }
        if (empty($roleNames)) {
            return back()->withErrors(['roles' => 'Minimal pilih satu role / hak akses akun.'])->withInput();
        }

        $primaryRole = Role::where('name', $roleNames[0])->first();
        $validated['role_id'] = $primaryRole ? $primaryRole->id : $user->role_id;

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active');
        unset($validated['roles']);

        $user->update($validated);
        $user->syncRoles($roleNames);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Data user dan hak akses multi-role berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('superadmin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('superadmin.users.index')
                ->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Akun {$user->name} berhasil {$statusText}.");
    }
}
