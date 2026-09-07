<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Ticket;
use App\Models\TicketNote;
use App\Models\TicketStatusLog;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(Request $request): View
    {
        $query = Ticket::with(['category', 'priority', 'unit', 'technician', 'creator']);

        // Filter status tab
        if ($request->filled('tab')) {
            $tab = $request->tab;
            if ($tab === 'pending') {
                $query->where('status', 'open');
            } elseif ($tab === 'assigned') {
                $query->where('status', 'assigned');
            } elseif ($tab === 'in_progress') {
                $query->where('status', 'in_progress');
            } elseif ($tab === 'resolved') {
                $query->where('status', 'resolved');
            } elseif ($tab === 'closed') {
                $query->where('status', 'closed');
            } elseif ($tab === 'rejected') {
                $query->where('status', 'rejected');
            }
        }

        // Filter Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter Priority
        if ($request->filled('priority_id')) {
            $query->where('priority_id', $request->priority_id);
        }

        // Filter Unit
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhereHas('creator', function ($qc) use ($search) {
                      $qc->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $tickets = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::all();
        $priorities = Priority::all();
        $units = Unit::all();
        $technicians = User::technicians()->active()->get();

        // Counts for tabs
        $counts = [
            'all' => Ticket::count(),
            'pending' => Ticket::where('status', 'open')->count(),
            'assigned' => Ticket::where('status', 'assigned')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
            'rejected' => Ticket::where('status', 'rejected')->count(),
        ];

        return view('admin.tickets.index', compact(
            'tickets',
            'categories',
            'priorities',
            'units',
            'technicians',
            'counts'
        ));
    }

    public function show(Ticket $ticket): View
    {
        $ticket->load(['category', 'priority', 'unit', 'technician', 'creator', 'statusLogs.user', 'notes.user']);
        $categories = Category::all();
        $priorities = Priority::all();
        $technicians = User::technicians()->active()->with(['assignedTickets' => function ($q) {
            $q->whereIn('status', ['assigned', 'in_progress']);
        }])->get();

        return view('admin.tickets.show', compact('ticket', 'categories', 'priorities', 'technicians'));
    }

    public function validateTicket(Request $request, Ticket $ticket): RedirectResponse
    {
        $mode = $request->input('assign_mode', 'open_pool'); // 'open_pool' atau 'direct_assign'
        $assignedTo = $request->input('assigned_to');

        if ($mode === 'direct_assign' && $assignedTo) {
            $technician = User::findOrFail($assignedTo);
            $ticket->update([
                'validation_status' => 'validated',
                'assigned_to' => $technician->id,
                'assigned_at' => now(),
                'status' => 'assigned',
                'admin_notes' => $request->admin_notes,
            ]);

            TicketStatusLog::create([
                'ticket_id' => $ticket->id,
                'status' => 'assigned',
                'changed_by' => Auth::id(),
                'note' => "Tiket divalidasi dan langsung ditugaskan oleh Admin kepada Teknisi {$technician->name}." . ($request->admin_notes ? " (Catatan: {$request->admin_notes})" : ""),
            ]);

            return redirect()->back()->with('success', "Tiket {$ticket->ticket_number} divalidasi dan ditugaskan ke {$technician->name}.");
        }

        // Default: Masukkan ke Antrean Terbuka (Open Pool untuk diambil mandiri oleh teknisi)
        $ticket->update([
            'validation_status' => 'validated',
            'assigned_to' => null,
            'status' => 'open',
            'admin_notes' => $request->admin_notes,
        ]);

        $groupLabel = $ticket->category ? (strtoupper($ticket->category->group_type) . ' - ' . $ticket->category->name) : 'Tim IT';

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => 'validated',
            'changed_by' => Auth::id(),
            'note' => "Tiket divalidasi oleh Admin dan dimasukkan ke Antrean Terbuka ({$groupLabel}) untuk diambil oleh Teknisi.",
        ]);

        return redirect()->back()->with('success', "Tiket {$ticket->ticket_number} berhasil divalidasi dan dibuka ke Antrean Terbuka Tim.");
    }

    /**
     * Lepas penugasan dan kembalikan tiket ke antrean terbuka tim teknisi.
     */
    public function releaseToPool(Ticket $ticket): RedirectResponse
    {
        $oldTechName = $ticket->technician->name ?? 'Teknisi';
        $ticket->update([
            'assigned_to' => null,
            'assigned_at' => null,
            'status' => 'open',
        ]);

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => 'open',
            'changed_by' => Auth::id(),
            'note' => "Penugasan dari {$oldTechName} telah dilepas oleh Admin dan dikembalikan ke Antrean Terbuka Tim.",
        ]);

        return redirect()->back()->with('success', "Tiket {$ticket->ticket_number} berhasil dikembalikan ke Antrean Terbuka.");
    }

    public function rejectTicket(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:5'],
        ]);

        $ticket->update([
            'status' => 'rejected',
            'validation_status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => 'rejected',
            'changed_by' => Auth::id(),
            'note' => 'Penolakan Tiket: ' . $validated['rejection_reason'],
        ]);

        return redirect()->back()->with('success', "Tiket {$ticket->ticket_number} telah ditolak.");
    }

    public function updateTriage(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'priority_id' => ['required', 'exists:priorities,id'],
        ]);

        $oldCategory = $ticket->category->name ?? '-';
        $oldPriority = $ticket->priority->name ?? '-';

        $ticket->update($validated);
        $ticket->load(['category', 'priority']);

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => 'triage_updated',
            'changed_by' => Auth::id(),
            'note' => "Penyesuaian Kategori ({$oldCategory} -> {$ticket->category->name}) & Prioritas ({$oldPriority} -> {$ticket->priority->name}) oleh Admin.",
        ]);

        return redirect()->back()->with('success', 'Kategori dan Prioritas tiket berhasil diperbarui.');
    }

    public function assignTechnician(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
            'assignment_note' => ['nullable', 'string'],
        ]);

        $technician = User::findOrFail($validated['assigned_to']);

        $ticket->update([
            'assigned_to' => $technician->id,
            'assigned_at' => now(),
            'status' => 'assigned',
            'validation_status' => 'validated',
        ]);

        $note = "Ditugaskan kepada Teknisi: {$technician->name}";
        if (!empty($validated['assignment_note'])) {
            $note .= " - Catatan: " . $validated['assignment_note'];
        }

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => 'assigned',
            'changed_by' => Auth::id(),
            'note' => $note,
        ]);

        return redirect()->back()->with('success', "Tiket {$ticket->ticket_number} berhasil ditugaskan ke {$technician->name}.");
    }

    public function addNote(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'note' => ['required', 'string', 'min:3'],
        ]);

        TicketNote::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'note' => $validated['note'],
        ]);

        return redirect()->back()->with('success', 'Catatan internal berhasil ditambahkan.');
    }

    public function closeTicket(Request $request, Ticket $ticket): RedirectResponse
    {
        $ticket->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => 'closed',
            'changed_by' => Auth::id(),
            'note' => 'Tiket resmi ditutup oleh Admin Helpdesk.',
        ]);

        return redirect()->back()->with('success', "Tiket {$ticket->ticket_number} telah ditutup.");
    }

    /**
     * API Polling untuk Notifikasi Suara & Real-time Live Check Tiket Baru.
     */
    public function checkNewTickets(Request $request): \Illuminate\Http\JsonResponse
    {
        $latest = Ticket::with(['unit', 'priority'])->latest()->first();
        $totalOpen = Ticket::where('status', 'open')->count();
        $totalAssigned = Ticket::where('status', 'assigned')->count();
        $totalReview = Ticket::where('status', 'pending_review')->count();

        return response()->json([
            'latest_id' => $latest?->id,
            'latest_number' => $latest?->ticket_number,
            'latest_title' => $latest?->title,
            'latest_unit' => $latest?->unit?->name,
            'latest_priority' => $latest?->priority?->name,
            'total_open' => $totalOpen,
            'total_assigned' => $totalAssigned,
            'total_review' => $totalReview,
            'url' => $latest ? route('admin.tickets.show', $latest->id) : '#',
        ]);
    }
}
