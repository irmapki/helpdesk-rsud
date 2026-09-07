<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketNote;
use App\Models\TicketStatusLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TeknisiController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard teknisi (Mendukung Self-Assign, Klasifikasi Software/Hardware, & Tim).
     */
    public function index(Request $request): View
    {
        $myId = Auth::id();
        $scope = $request->query('scope', 'my'); // 'my' (Tiket Saya), 'available' (Tersedia / Belum Diambil), 'team' (Tiket Tim Kolaborasi)
        $tab = $request->query('tab', 'all');
        $categoryType = $request->query('category_type', 'all'); // 'all', 'software', 'hardware'

        $query = Ticket::with(['unit', 'category', 'priority', 'statusLogs.user', 'creator', 'technician', 'collaborators']);

        if ($scope === 'available') {
            // Tiket yang belum diambil sama sekali di antrean terbuka
            $query->whereNull('assigned_to')
                  ->whereIn('status', ['open', 'assigned']);

            if ($categoryType === 'software') {
                $query->whereHas('category', function ($q) {
                    $q->where('name', 'like', '%simrs%')
                      ->orWhere('name', 'like', '%software%')
                      ->orWhere('name', 'like', '%bpjs%')
                      ->orWhere('name', 'like', '%vclaim%')
                      ->orWhere('name', 'like', '%aplikasi%')
                      ->orWhere('name', 'like', '%sistem%');
                });
            } elseif ($categoryType === 'hardware') {
                $query->whereHas('category', function ($q) {
                    $q->where('name', 'not like', '%simrs%')
                      ->where('name', 'not like', '%software%')
                      ->where('name', 'not like', '%bpjs%')
                      ->where('name', 'not like', '%vclaim%')
                      ->where('name', 'not like', '%aplikasi%')
                      ->where('name', 'not like', '%sistem%');
                });
            }
        } elseif ($scope === 'team') {
            // Tiket di mana teknisi login terdaftar sebagai rekan tim (collaborator) ATAU tiket rekan tim yang aktif
            $query->where(function ($q) use ($myId) {
                $q->whereHas('collaborators', fn($qc) => $qc->where('user_id', $myId))
                  ->orWhere(fn($qo) => $qo->whereNotNull('assigned_to')->where('assigned_to', '!=', $myId));
            })->whereIn('status', ['assigned', 'in_progress']);
        } else {
            // Default: Tiket Saya (Individu yang di-assign langsung)
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
            $selectedTicket = Ticket::with(['unit', 'category', 'priority', 'statusLogs.user', 'notes.user', 'creator', 'technician', 'collaborators'])
                ->find($selectedTicketId);
        }

        if (!$selectedTicket && $tickets->isNotEmpty()) {
            $selectedTicket = $tickets->first();
            $selectedTicket->load(['statusLogs.user', 'notes.user', 'collaborators']);
        }

        // Summary Counts Khusus Teknisi Login
        $myActiveCount = Ticket::where('assigned_to', $myId)->whereIn('status', ['assigned', 'in_progress'])->count();
        $myAssignedCount = Ticket::where('assigned_to', $myId)->where('status', 'assigned')->count();
        $myInProgressCount = Ticket::where('assigned_to', $myId)->where('status', 'in_progress')->count();
        
        // Hitung tiket yang tersedia bebas untuk diambil
        $availableCount = Ticket::whereNull('assigned_to')
            ->whereIn('status', ['open', 'assigned'])
            ->count();

        $availableSoftwareCount = Ticket::whereNull('assigned_to')
            ->whereIn('status', ['open', 'assigned'])
            ->whereHas('category', function ($q) {
                $q->where('name', 'like', '%simrs%')
                  ->orWhere('name', 'like', '%software%')
                  ->orWhere('name', 'like', '%bpjs%')
                  ->orWhere('name', 'like', '%vclaim%')
                  ->orWhere('name', 'like', '%aplikasi%')
                  ->orWhere('name', 'like', '%sistem%');
            })
            ->count();

        $availableHardwareCount = Ticket::whereNull('assigned_to')
            ->whereIn('status', ['open', 'assigned'])
            ->whereHas('category', function ($q) {
                $q->where('name', 'not like', '%simrs%')
                  ->where('name', 'not like', '%software%')
                  ->where('name', 'not like', '%bpjs%')
                  ->where('name', 'not like', '%vclaim%')
                  ->where('name', 'not like', '%aplikasi%')
                  ->where('name', 'not like', '%sistem%');
            })
            ->count();

        $teamTicketsCount = Ticket::where(function ($q) use ($myId) {
            $q->whereHas('collaborators', fn($qc) => $qc->where('user_id', $myId))
              ->orWhere(fn($qo) => $qo->whereNotNull('assigned_to')->where('assigned_to', '!=', $myId));
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
        $allTechnicians = User::technicians()->active()->where('id', '!=', $myId)->get();

        return view('teknisi.dashboard', compact(
            'tickets',
            'selectedTicket',
            'scope',
            'tab',
            'categoryType',
            'myActiveCount',
            'myAssignedCount',
            'myInProgressCount',
            'availableCount',
            'availableSoftwareCount',
            'availableHardwareCount',
            'teamTicketsCount',
            'resolvedThisMonth',
            'approachingSlaCount',
            'totalMyTickets',
            'allTechnicians'
        ));
    }

    /**
     * Fitur Ambil Tiket Secara Mandiri (Self-Claim).
     */
    public function claimTicket(Request $request, Ticket $ticket): RedirectResponse
    {
        $myId = Auth::id();
        $userName = Auth::user()->name;

        $ticket->update([
            'assigned_to' => $myId,
            'assigned_at' => now(),
            'status' => 'assigned',
            'validation_status' => 'validated',
        ]);

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => 'assigned',
            'changed_by' => $myId,
            'note' => "Tiket diambil secara mandiri oleh Teknisi {$userName}.",
        ]);

        return redirect()->route('teknisi.dashboard', ['scope' => 'my', 'ticket_id' => $ticket->id])
            ->with('success', "Tiket {$ticket->ticket_number} berhasil Anda ambil.");
    }

    /**
     * Ajak rekan teknisi lain untuk berkolaborasi dalam tim.
     */
    public function inviteCollaborator(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'collaborator_id' => ['required', 'exists:users,id'],
        ]);

        $collaborator = User::findOrFail($validated['collaborator_id']);
        
        if ($collaborator->id === Auth::id() || $collaborator->id === $ticket->assigned_to) {
            return redirect()->back()->with('error', 'Teknisi ini sudah menjadi penanggung jawab tiket.');
        }

        $ticket->collaborators()->syncWithoutDetaching([$collaborator->id => ['role_in_team' => 'member']]);

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => $ticket->status,
            'changed_by' => Auth::id(),
            'note' => "Teknisi " . Auth::user()->name . " mengajak {$collaborator->name} ({$collaborator->specialization}) ke dalam tim penanganan tiket.",
        ]);

        return redirect()->back()->with('success', "{$collaborator->name} berhasil ditambahkan ke tim pengerjaan tiket.");
    }

    /**
     * Lepas rekan teknisi dari tim kolaborasi.
     */
    public function removeCollaborator(Request $request, Ticket $ticket, User $user): RedirectResponse
    {
        $ticket->collaborators()->detach($user->id);

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => $ticket->status,
            'changed_by' => Auth::id(),
            'note' => "{$user->name} telah dilepas dari tim pengerjaan tiket oleh " . Auth::user()->name . ".",
        ]);

        return redirect()->back()->with('success', "{$user->name} telah dikeluarkan dari tim pengerjaan tiket.");
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