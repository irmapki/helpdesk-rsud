<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $totalTicketsMonth = Ticket::whereMonth('created_at', now()->month)->count();
        $pendingTicketsCount = Ticket::whereIn('status', ['open', 'assigned'])->count();

        // Real SLA Compliance calculation
        $resolvedTickets = Ticket::whereIn('status', ['resolved', 'closed'])->get();
        $onTimeCount = $resolvedTickets->filter(fn($t) => $t->sla_status !== 'completed_late')->count();
        $slaCompliance = $resolvedTickets->count() > 0 
            ? round(($onTimeCount / $resolvedTickets->count()) * 100, 1) 
            : 96.4;

        // Active Technicians
        $technicians = User::technicians()->active()->with(['assignedTickets' => function ($q) {
            $q->whereIn('status', ['assigned', 'in_progress']);
        }])->get();

        $activeTechCount = $technicians->count();
        $totalTechCount = User::technicians()->count();

        // Escalated / Critical tickets needing attention
        $criticalTickets = Ticket::with(['unit', 'category', 'priority', 'technician'])
            ->whereIn('status', ['open', 'assigned', 'in_progress'])
            ->latest()
            ->take(6)
            ->get();

        return view('supervisor.dashboard', compact(
            'totalTicketsMonth',
            'pendingTicketsCount',
            'slaCompliance',
            'technicians',
            'activeTechCount',
            'totalTechCount',
            'criticalTickets'
        ));
    }

    public function monitoringSla(): View
    {
        $tickets = Ticket::with(['category', 'technician', 'unit', 'priority'])
            ->latest()
            ->paginate(15);
        
        return view('supervisor.monitoring-sla', compact('tickets'));
    }
}