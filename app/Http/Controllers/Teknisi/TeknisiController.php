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
     * Menampilkan halaman utama dashboard teknisi (Model 1: 1 Orang 1 Akun).
     */
    public function index(Request $request): View
    {
        $myId = Auth::id();
        $scope = $request->query('scope', 'my'); // 'my' (Tiket Saya), 'available' (Tiket Belum Diambil), 'all' (Semua Tiket Tim)
        $tab = $request->query('tab', 'all');

        $query = Ticket::with(['unit', 'category', 'priority', 'statusLogs.user', 'creator', 'technician']);

        if ($scope === 'available') {
            // Tiket yang belum diambil / belum ditugaskan ke siapa pun
            $query->whereNull('assigned_to')->whereIn('status', ['open', 'assigned']);
        } elseif ($scope === 'all') {
            // Tiket tim teknisi lain
            $query->whereNotNull('assigned_to')->where('assigned_to', '!=', $myId);
        } else {
            // Default: Tiket yang ditugaskan / diambil oleh teknisi yang sedang login
            $query->where('assigned_to', $myId);

            if ($tab === 'assigned') {
                $query->where('status', 'assigned');
            } elseif ($tab === 'in_progress') {
                $query->where('status', 'in_progress');
            } elseif ($tab === 'resolved') {
                $query->whereIn('status', ['resolved', 'closed', 'pending_review']);
            }
        }

        $tickets = $query->latest()->get();

        // Selected ticket for right detail panel
        $selectedTicketId = $request->query('ticket_id');
        $selectedTicket = null;
        if ($selectedTicketId) {
            $selectedTicket = Ticket::with(['unit', 'category', 'priority', 'statusLogs.user', 'notes.user', 'creator', 'technician'])
                ->find($selectedTicketId);
        }

        if (!$selectedTicket && $tickets->isNotEmpty()) {
            $selectedTicket = $tickets->first();
            $selectedTicket->load(['statusLogs.user', 'notes.user']);
        }

        // Summary Counts Khusus Teknisi Login
        $myActiveCount = Ticket::where('assigned_to', $myId)->whereIn('status', ['assigned', 'in_progress'])->count();
        $myAssignedCount = Ticket::where('assigned_to', $myId)->where('status', 'assigned')->count();
        $myInProgressCount = Ticket::where('assigned_to', $myId)->where('status', 'in_progress')->count();
        $availableCount = Ticket::whereNull('assigned_to')->whereIn('status', ['open', 'assigned'])->count();
        $teamTicketsCount = Ticket::whereNotNull('assigned_to')->where('assigned_to', '!=', $myId)->whereIn('status', ['assigned', 'in_progress'])->count();
        
        $resolvedThisMonth = Ticket::where('assigned_to', $myId)
            ->whereIn('status', ['resolved', 'closed', 'pending_review'])
            ->whereMonth('updated_at', now()->month)
            ->count();
        
        $approachingSlaCount = Ticket::where('assigned_to', $myId)
            ->whereIn('status', ['assigned', 'in_progress'])
            ->get()
            ->filter(fn($t) => in_array($t->sla_status, ['approaching', 'breached']))
            ->count();

        $totalMyTickets = Ticket::where('assigned_to', $myId)->count();

        return view('teknisi.dashboard', compact(
            'tickets',
            'selectedTicket',
            'scope',
            'tab',
            'myActiveCount',
            'myAssignedCount',
            'myInProgressCount',
            'availableCount',
            'teamTicketsCount',
            'resolvedThisMonth',
            'approachingSlaCount',
            'totalMyTickets'
        ));
    }

    /**
     * Fitur Ambil Tiket Secara Mandiri (Self-Claim Ticket).
     */
    public function claimTicket(Request $request, Ticket $ticket): RedirectResponse
    {
        $ticket->update([
            'assigned_to' => Auth::id(),
            'status' => 'assigned',
            'validation_status' => 'validated',
        ]);

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => 'assigned',
            'changed_by' => Auth::id(),
            'note' => 'Tiket diambil secara mandiri oleh Teknisi ' . Auth::user()->name,
        ]);

        return redirect()->route('teknisi.dashboard', ['scope' => 'my', 'ticket_id' => $ticket->id])
            ->with('success', "Tiket {$ticket->ticket_number} berhasil Anda ambil dan masuk ke daftar Tiket Saya.");
    }

    /**
     * Update status tiket oleh teknisi (In Progress / Resolved).
     */
    public function updateStatus(Request $request, Ticket $ticket): RedirectResponse
    {
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

        // Kirim Simulasi Email Log saat status berubah
        try {
            Mail::raw(
                "Halo Tim Admin & Supervisor,\n\nStatus tiket {$ticket->ticket_number} telah diupdate oleh Teknisi:\n" .
                "- Status Baru: {$ticket->status_label}\n" .
                "- Catatan Solusi: " . ($resolutionNote ?? '-') . "\n\n" .
                "Silakan cek dashboard untuk detailnya.", 
                function ($message) use ($ticket) {
                    $message->to('admin.helpdesk@rsud.co.id')
                            ->subject("Update Status Tiket: " . $ticket->ticket_number);
                }
            );
        } catch (\Exception $e) {
            // Lewati jika ada kendala log
        }

        return redirect()->route('teknisi.dashboard', ['ticket_id' => $ticket->id])
            ->with('success', 'Status penanganan tiket berhasil diperbarui.');
    }

    /**
     * Tambah catatan progres / tindak lanjut oleh teknisi.
     */
    public function addNote(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'note' => ['required', 'string', 'max:1000'],
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
     * Halaman Riwayat Penanganan Selesai Pribadi Teknisi.
     */
    public function riwayat(Request $request): View
    {
        $query = Ticket::with(['unit', 'category', 'priority', 'technician'])
            ->where('assigned_to', Auth::id())
            ->whereIn('status', ['resolved', 'closed', 'pending_review']);

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