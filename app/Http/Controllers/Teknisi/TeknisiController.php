<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketNote;
use App\Models\TicketStatusLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TeknisiController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard teknisi (Mendukung Self-Assign & Tim).
     */
    public function index(Request $request): View
    {
        $myId = Auth::id();
        $scope = $request->query('scope', 'my'); // 'my' (Tiket Saya), 'available' (Tersedia / Belum Diambil), 'team' (Tiket Tim)
        $tab = $request->query('tab', 'all');

        // Pastikan relasi technicians (pivot tim) dan technician (individu) dimuat agar fleksibel[cite: 6]
        $query = Ticket::with(['unit', 'category', 'priority', 'statusLogs.user', 'creator', 'technician', 'technicians']);

        if ($scope === 'available') {
            // Tiket yang belum diambil sama sekali (baik individu maupun tim)[cite: 6]
            $query->whereNull('assigned_to')
                  ->doesntHave('technicians')
                  ->whereIn('status', ['open', 'assigned']);
        } elseif ($scope === 'team') {
            // Tiket yang dikerjakan bersama sebagai tim (teknisi yang sedang login ikut terdaftar di relasi pivot technicians)[cite: 6]
            $query->whereHas('technicians', function ($q) use ($myId) {
                $q->where('user_id', $myId);
            });
        } else {
            // Default: Tiket Saya (Individu yang di-assign langsung)[cite: 6]
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

        // Selected ticket for right detail panel[cite: 6]
        $selectedTicketId = $request->query('ticket_id');
        $selectedTicket = null;
        if ($selectedTicketId) {
            $selectedTicket = Ticket::with(['unit', 'category', 'priority', 'statusLogs.user', 'notes.user', 'creator', 'technician', 'technicians'])
                ->find($selectedTicketId);
        }

        if (!$selectedTicket && $tickets->isNotEmpty()) {
            $selectedTicket = $tickets->first();
            $selectedTicket->load(['statusLogs.user', 'notes.user', 'technicians']);
        }

        // Summary Counts Khusus Teknisi Login[cite: 6]
        $myActiveCount = Ticket::where('assigned_to', $myId)->whereIn('status', ['assigned', 'in_progress'])->count();
        $myAssignedCount = Ticket::where('assigned_to', $myId)->where('status', 'assigned')->count();
        $myInProgressCount = Ticket::where('assigned_to', $myId)->where('status', 'in_progress')->count();
        
        // Hitung tiket yang benar-benar tersedia bebas untuk diambil[cite: 6]
        $availableCount = Ticket::whereNull('assigned_to')
            ->doesntHave('technicians')
            ->whereIn('status', ['open', 'assigned'])
            ->count();

        $teamTicketsCount = Ticket::whereHas('technicians', function ($q) use ($myId) {
            $q->where('user_id', $myId);
        })->whereIn('status', ['assigned', 'in_progress'])->count();
        
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
     * Fitur Ambil Tiket Secara Mandiri (Self-Claim / Individual & Team Support).
     */
    public function claimTicket(Request $request, Ticket $ticket): RedirectResponse
    {
        $myId = Auth::id();
        $userName = Auth::user()->name;
        $claimType = $request->input('claim_type', 'individual'); // Pilihan: 'individual' atau 'team'[cite: 6]

        if ($claimType === 'team') {
            // Mode Tim: Jika tiket belum punya leader utama (assigned_to), set teknisi ini sebagai leader, lalu daftarkan ke pivot[cite: 6]
            if (!$ticket->assigned_to) {
                $ticket->update([
                    'assigned_to' => $myId,
                    'status' => 'assigned',
                    'validation_status' => 'validated',
                ]);
            }

            // Sinkronisasi tabel relasi tim (pivot technicians) agar tidak duplikat[cite: 6]
            if (method_exists($ticket, 'technicians')) {
                $ticket->technicians()->syncWithoutDetaching([$myId]);
            }

            $logNote = "Teknisi {$userName} bergabung ke dalam tim penanganan tiket secara mandiri.";
        } else {
            // Mode Individu: Diambil sendiri secara penuh[cite: 6]
            $ticket->update([
                'assigned_to' => $myId,
                'status' => 'assigned',
                'validation_status' => 'validated',
            ]);

            if (method_exists($ticket, 'technicians')) {
                $ticket->technicians()->sync([$myId]);
            }

            $logNote = "Tiket diambil secara mandiri oleh Teknisi {$userName} (Individu).";
        }

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => 'assigned',
            'changed_by' => $myId,
            'note' => $logNote,
        ]);

        $targetScope = ($claimType === 'team') ? 'team' : 'my';

        return redirect()->route('teknisi.dashboard', ['scope' => $targetScope, 'ticket_id' => $ticket->id])
            ->with('success', "Tiket {$ticket->ticket_number} berhasil Anda ambil ({$claimType}).");
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
            if ($ticket->requiresReview()) {
                $status = 'pending_review';
                $updateData['status'] = 'pending_review';
            } else {
                $updateData['resolved_at'] = now();
            }
        }

        if (!empty($resolutionNote)) {
            $updateData['admin_notes'] = $resolutionNote; // Diubah dari resolution_notes ke admin_notes agar sesuai dengan kolom fillable Model Ticket
        }

        $ticket->update($updateData);

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
            // Lewati jika ada kendala log email[cite: 6]
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
            // Lewati jika ada kendala log email[cite: 6]
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