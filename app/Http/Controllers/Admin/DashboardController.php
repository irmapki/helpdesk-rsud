<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pendingValidationCount = Ticket::where('status', 'open')
            ->where(function ($q) {
                $q->whereNull('assigned_to')->orWhere('validation_status', 'pending');
            })->count();

        $assignedCount = Ticket::where('status', 'assigned')->count();
        $inProgressCount = Ticket::where('status', 'in_progress')->count();
        $resolvedCount = Ticket::where('status', 'resolved')->count();
        $totalTicketsCount = Ticket::count();

        // Recent incoming tickets needing triage
        $recentTickets = Ticket::with(['category', 'priority', 'unit', 'technician', 'creator'])
            ->latest()
            ->take(8)
            ->get();

        // Active technicians with their current ticket workload
        $technicians = User::technicians()->active()->with(['assignedTickets' => function ($q) {
            $q->whereIn('status', ['assigned', 'in_progress']);
        }])->get();

        return view('admin.dashboard', compact(
            'pendingValidationCount',
            'assignedCount',
            'inProgressCount',
            'resolvedCount',
            'totalTicketsCount',
            'recentTickets',
            'technicians'
        ));
    }
}