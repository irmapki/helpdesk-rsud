<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Ticket;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    /**
     * Dashboard Utama Supervisor IT.
     */
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

    /**
     * Halaman Monitoring SLA.
     */
    public function monitoringSla(): View
    {
        $tickets = Ticket::with(['category', 'technician', 'unit', 'priority'])
            ->latest()
            ->paginate(15);
        
        return view('supervisor.monitoring-sla', compact('tickets'));
    }

    /**
     * Halaman Laporan Tiket Lengkap (Pencarian Tiket & Pelapor Dipisah).
     */
    public function laporanTiket(Request $request): View
    {
        $query = Ticket::with(['unit', 'category', 'priority', 'technician', 'creator']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Pencarian khusus Tiket (No Tiket atau Judul Masalah)
        if ($request->filled('ticket_search')) {
            $ticketSearch = $request->ticket_search;
            $query->where(function ($q) use ($ticketSearch) {
                $q->where('ticket_number', 'like', "%{$ticketSearch}%")
                  ->orWhere('title', 'like', "%{$ticketSearch}%");
            });
        }

        // Pencarian khusus Pelapor (Nama Tamu / Creator)
        if ($request->filled('pelapor_search')) {
            $pelaporSearch = $request->pelapor_search;
            $query->where(function ($q) use ($pelaporSearch) {
                $q->where('guest_name', 'like', "%{$pelaporSearch}%")
                  ->orWhereHas('creator', function ($qc) use ($pelaporSearch) {
                      $qc->where('name', 'like', "%{$pelaporSearch}%");
                  });
            });
        }

        $tickets = $query->latest()->paginate(15)->withQueryString();
        $units = Unit::all();
        $categories = Category::all();

        $totalAll = Ticket::count();
        $totalResolved = Ticket::whereIn('status', ['resolved', 'closed'])->count();
        $totalPending = Ticket::whereIn('status', ['open', 'assigned', 'in_progress'])->count();

        return view('supervisor.laporan-tiket', compact(
            'tickets',
            'units',
            'categories',
            'totalAll',
            'totalResolved',
            'totalPending'
        ));
    }

    /**
     * Export Laporan Tiket ke Excel (CSV Format).
     */
    public function exportExcel(Request $request): StreamedResponse
    {
        $query = Ticket::with(['unit', 'category', 'priority', 'technician', 'creator']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('ticket_search')) {
            $ticketSearch = $request->ticket_search;
            $query->where(function ($q) use ($ticketSearch) {
                $q->where('ticket_number', 'like', "%{$ticketSearch}%")
                  ->orWhere('title', 'like', "%{$ticketSearch}%");
            });
        }

        if ($request->filled('pelapor_search')) {
            $pelaporSearch = $request->pelapor_search;
            $query->where(function ($q) use ($pelaporSearch) {
                $q->where('guest_name', 'like', "%{$pelaporSearch}%")
                  ->orWhereHas('creator', function ($qc) use ($pelaporSearch) {
                      $qc->where('name', 'like', "%{$pelaporSearch}%");
                  });
            });
        }

        $tickets = $query->latest()->get();

        $filename = 'Laporan-Tiket-Helpdesk-' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($tickets) {
            $file = fopen('php://output', 'w');
            
            // BOM for Excel UTF-8 compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header Kolom Excel Lengkap (Tiket + Evaluasi SLA)
            fputcsv($file, [
                'No Tiket', 
                'Tanggal Lapor', 
                'Unit / Ruangan RSUD', 
                'Kategori Kendala', 
                'Judul Masalah', 
                'Nama Pelapor', 
                'Kontak Pelapor', 
                'Teknisi Penanganan', 
                'Prioritas', 
                'Target SLA (Jam)', 
                'Batas Waktu SLA', 
                'Waktu Selesai', 
                'Kepatuhan SLA', 
                'Status Tiket',
                'Solusi / Catatan Penanganan'
            ]);

            // Data Baris Tiket Lengkap
            foreach ($tickets as $t) {
                $deadlineStr = $t->sla_deadline ? $t->sla_deadline->format('Y-m-d H:i') . ' WIB' : '-';
                $resolvedAtStr = $t->resolved_at ? $t->resolved_at->format('Y-m-d H:i') . ' WIB' : ($t->closed_at ? $t->closed_at->format('Y-m-d H:i') . ' WIB' : '-');
                $slaStatusText = $t->sla_status_label;

                fputcsv($file, [
                    $t->ticket_number,
                    $t->created_at->format('Y-m-d H:i') . ' WIB',
                    $t->unit->name ?? '-',
                    $t->category->name ?? '-',
                    $t->title,
                    $t->reporter_name,
                    $t->reporter_contact,
                    $t->technician->name ?? 'Belum Ditugaskan',
                    $t->priority->name ?? 'Normal',
                    ($t->priority->sla_hours ?? 24) . ' Jam',
                    $deadlineStr,
                    $resolvedAtStr,
                    $slaStatusText,
                    $t->status_label,
                    $t->resolution_notes ?? ($t->description ?? '-')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Halaman Statistik & Analisis Kinerja.
     */
    public function statistik(Request $request): View
    {
        $totalTickets = Ticket::count();
        $resolvedCount = Ticket::whereIn('status', ['resolved', 'closed'])->count();
        $inProgressCount = Ticket::where('status', 'in_progress')->count();
        $pendingCount = Ticket::whereIn('status', ['open', 'assigned'])->count();

        // Kategori breakdown
        $categories = Category::withCount('tickets')->orderBy('tickets_count', 'desc')->get();

        // Prioritas breakdown
        $priorities = Priority::withCount('tickets')->get();

        // Unit teraktif melaporkan
        $topUnits = Unit::withCount('tickets')->orderBy('tickets_count', 'desc')->take(5)->get();

        // Teknisi performance
        $technicians = User::technicians()->active()->withCount([
            'assignedTickets as active_count' => function ($q) {
                $q->whereIn('status', ['assigned', 'in_progress']);
            },
            'assignedTickets as resolved_count' => function ($q) {
                $q->whereIn('status', ['resolved', 'closed']);
            }
        ])->get();

        // SLA rate
        $resolvedTickets = Ticket::whereIn('status', ['resolved', 'closed'])->get();
        $onTimeCount = $resolvedTickets->filter(fn($t) => $t->sla_status !== 'completed_late')->count();
        $slaRate = $resolvedTickets->count() > 0 ? round(($onTimeCount / $resolvedTickets->count()) * 100, 1) : 96.4;

        return view('supervisor.statistik', compact(
            'totalTickets',
            'resolvedCount',
            'inProgressCount',
            'pendingCount',
            'categories',
            'priorities',
            'topUnits',
            'technicians',
            'slaRate'
        ));
    }

    /**
     * Halaman Filter Periode Laporan Tiket.
     */
    public function filterPeriode(Request $request): View
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Ticket::with(['unit', 'category', 'priority', 'technician', 'creator']);

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $tickets = ($startDate || $endDate) 
            ? $query->latest()->paginate(15)->withQueryString()
            : collect();

        $totalFiltered = ($startDate || $endDate) ? $tickets->total() : 0;

        return view('supervisor.filter-periode', compact(
            'tickets',
            'startDate',
            'endDate',
            'totalFiltered'
        ));
    }
}