<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketNote;
use App\Models\TicketStatusLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // <-- Tambahan untuk log/simulasi email
use Illuminate\View\View;

class TeknisiController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard teknisi (Tiket Saya).
     */
    public function index(Request $request): View
    {
        $technicianId = Auth::id();

        $query = Ticket::with(['unit', 'category', 'priority', 'statusLogs.user', 'creator'])
            ->where('assigned_to', $technicianId);

        // Filter tab
        $tab = $request->query('tab', 'all');
        if ($tab === 'assigned') {
            $query->where('status', 'assigned');
        } elseif ($tab === 'in_progress') {
            $query->where('status', 'in_progress');
        } elseif ($tab === 'resolved') {
            $query->whereIn('status', ['resolved', 'closed']);
        }

        $tickets = $query->latest()->get();

        // Selected ticket for right detail panel
        $selectedTicketId = $request->query('ticket_id');
        $selectedTicket = null;
        if ($selectedTicketId) {
            $selectedTicket = Ticket::with(['unit', 'category', 'priority', 'statusLogs.user', 'notes.user', 'creator'])
                ->where('assigned_to', $technicianId)
                ->find($selectedTicketId);
        }

        if (!$selectedTicket && $tickets->isNotEmpty()) {
            $selectedTicket = $tickets->first();
            $selectedTicket->load(['statusLogs.user', 'notes.user']);
        }

        // Summary Counts
        $assignedCount = Ticket::where('assigned_to', $technicianId)->where('status', 'assigned')->count();
        $inProgressCount = Ticket::where('assigned_to', $technicianId)->where('status', 'in_progress')->count();
        $resolvedThisMonth = Ticket::where('assigned_to', $technicianId)
            ->whereIn('status', ['resolved', 'closed'])
            ->whereMonth('updated_at', now()->month)
            ->count();
        
        $approachingSlaCount = Ticket::where('assigned_to', $technicianId)
            ->whereIn('status', ['assigned', 'in_progress'])
            ->get()
            ->filter(fn($t) => in_array($t->sla_status, ['approaching', 'breached']))
            ->count();

        $totalMyTickets = Ticket::where('assigned_to', $technicianId)->count();

        return view('teknisi.dashboard', compact(
            'tickets',
            'selectedTicket',
            'tab',
            'assignedCount',
            'inProgressCount',
            'resolvedThisMonth',
            'approachingSlaCount',
            'totalMyTickets'
        ));
    }

    /**
     * Update status tiket oleh teknisi (In Progress / Resolved).
     */
    public function updateStatus(Request $request, Ticket $ticket): RedirectResponse
    {
        // Pastikan tiket ini ditugaskan ke teknisi yang sedang login
        if ($ticket->assigned_to !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk tiket ini.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:assigned,in_progress,resolved'],
            'resolution_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $status = $validated['status'];
        $resolutionNote = $validated['resolution_notes'] ?? null;
        
        $updateData = ['status' => $status];

        if ($status === 'resolved') {
            // Cek apakah tiket ini software/SIMRS yang butuh review
            if ($ticket->requiresReview()) {
                $status = 'pending_review';
                $updateData['status'] = 'pending_review';
            } else {
                // Jika hardware / jaringan, langsung dinyatakan selesai
                $updateData['resolved_at'] = now();
            }
}

        // Jika ada catatan solusi teknis, kita simpan juga ke kolom resolution_notes
        if (!empty($resolutionNote)) {
            $updateData['resolution_notes'] = $resolutionNote;
        }

        $ticket->update($updateData);

        // Tentukan teks log status
        $noteText = $resolutionNote ?: match ($status) {
            'in_progress' => 'Teknisi memulai pengerjaan penanganan kendala di lokasi.',
            'pending_review' => 'Perbaikan software selesai dikerjakan dan diajukan untuk review Supervisor.',
            'resolved' => 'Kendala teknis telah berhasil diselesaikan oleh Teknisi.',
            default => 'Status tiket diperbarui oleh Teknisi.',
        };

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => $status,
            'changed_by' => Auth::id(),
            'note' => $noteText,
        ]);

        // Kirim Simulasi Email Log saat Status Diperbarui/Resolved oleh Teknisi
        try {
            Mail::raw(
                "Halo Admin & Pelapor,\n\nStatus tiket {$ticket->ticket_number} telah diperbarui oleh Teknisi.\n" .
                "- Status Terbaru: " . strtoupper($status) . "\n" .
                "- Catatan/Solusi: " . ($resolutionNote ?? $noteText) . "\n\n" .
                "Silakan cek sistem Helpdesk RSUD untuk detail lebih lanjut.",
                function ($message) use ($ticket, $status) {
                    $message->to('admin.helpdesk@rsud.co.id')
                            ->subject("Update Status Tiket {$ticket->ticket_number}: " . strtoupper($status));
                }
            );
        } catch (\Exception $e) {
            // Lewati jika ada kendala log email
        }

        return redirect()->route('teknisi.dashboard', ['ticket_id' => $ticket->id])
            ->with('success', "Status tiket {$ticket->ticket_number} berhasil diperbarui.");
    }

    /**
     * Tambah catatan progres pengerjaan oleh teknisi.
     */
    public function addNote(Request $request, Ticket $ticket): RedirectResponse
    {
        if ($ticket->assigned_to !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk tiket ini.');
        }

        $validated = $request->validate([
            'note' => ['required', 'string', 'min:3', 'max:1000'],
        ]);

        TicketNote::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'note' => $validated['note'],
        ]);

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => $ticket->status,
            'changed_by' => Auth::id(),
            'note' => 'Catatan Progres Teknisi: ' . $validated['note'],
        ]);

        // Kirim Simulasi Email Log saat Teknisi Menambah Catatan Progres
        try {
            Mail::raw(
                "Halo Admin,\n\nAda catatan progres baru dari teknisi untuk tiket {$ticket->ticket_number}:\n" .
                "\"{$validated['note']}\"\n\n" .
                "Silakan cek dashboard untuk memantaunya.",
                function ($message) use ($ticket) {
                    $message->to('admin.helpdesk@rsud.co.id')
                            ->subject("Progres Baru Tiket: " . $ticket->ticket_number);
                }
            );
        } catch (\Exception $e) {
            // Lewati jika ada kendala log
        }

        return redirect()->route('teknisi.dashboard', ['ticket_id' => $ticket->id])
            ->with('success', 'Catatan penanganan berhasil disimpan.');
    }

    /**
     * Halaman Riwayat Penanganan Selesai.
     */
    public function riwayat(Request $request): View
    {
        $technicianId = Auth::id();

        $query = Ticket::with(['unit', 'category', 'priority'])
            ->where('assigned_to', $technicianId)
            ->whereIn('status', ['resolved', 'closed']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhereHas('unit', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $tickets = $query->latest()->paginate(15)->withQueryString();

        return view('teknisi.riwayat', compact('tickets'));
    }
}