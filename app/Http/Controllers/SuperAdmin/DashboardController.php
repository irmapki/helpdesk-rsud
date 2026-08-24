<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\Unit;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::count();
        $totalTechnicians = User::technicians()->count();
        $totalActiveTechnicians = User::technicians()->active()->count();
        $totalUnits = Unit::count();
        $totalCategories = Category::count();
        $totalPriorities = Priority::count();
        
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status', 'open')->count();
        $assignedTickets = Ticket::where('status', 'assigned')->count();
        $inProgressTickets = Ticket::where('status', 'in_progress')->count();
        $resolvedTickets = Ticket::whereIn('status', ['resolved', 'closed'])->count();

        // Recent users
        $recentUsers = User::with(['role', 'unit'])->latest()->take(5)->get();

        // Priorities with SLA details
        $priorities = Priority::withCount('tickets')->get();

        return view('superadmin.dashboard', compact(
            'totalUsers',
            'totalTechnicians',
            'totalActiveTechnicians',
            'totalUnits',
            'totalCategories',
            'totalPriorities',
            'totalTickets',
            'openTickets',
            'assignedTickets',
            'inProgressTickets',
            'resolvedTickets',
            'recentUsers',
            'priorities'
        ));
    }
}