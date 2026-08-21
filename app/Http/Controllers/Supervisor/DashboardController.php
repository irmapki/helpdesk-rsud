<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        return view('supervisor.dashboard');
    }

    public function monitoringSla()
    {
        // Ambil data tiket beserta relasinya untuk halaman Monitoring SLA
        $tickets = Ticket::with(['category', 'technician', 'unit'])->latest()->paginate(10);
        
        return view('supervisor.monitoring-sla', compact('tickets'));
    }
}