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
use Illuminate\Support\Facades\Mail;
use App\Mail\TechnicianAssignedMail;
use App\Mail\TicketResolvedMail;
use App\Mail\TicketAvailableMail;
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

        // Data khusus untuk Papan Kanban (semua tiket aktif yang sesuai filter pencarian)
        $kanbanQuery = Ticket::with(['category', 'priority', 'unit', 'technician', 'creator']);
        if ($request->filled('category_id')) {
            $kanbanQuery->where('category_id', $request->category_id);
        }
        if ($request->filled('priority_id')) {
            $kanbanQuery->where('priority_id', $request->priority_id);
        }
        if ($request->filled('unit_id')) {
            $kanbanQuery->where('unit_id', $request->unit_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $kanbanQuery->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhereHas('creator', function ($qc) use ($search) {
                      $qc->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $allKanbanTickets = $kanbanQuery->latest()->get();

        $kanbanColumns = [
            'pending' => [
                'id' => 'pending',
                'title' => '1. Antrean Masuk',
                'color' => 'amber',
                'dotColor' => 'bg-amber-500',
                'borderColor' => 'border-amber-400',
                'badgeClass' => 'bg-amber-100 text-amber-900 border-amber-300',
                'tickets' => $allKanbanTickets->where('status', 'open')->values(),
            ],
            'assigned' => [
                'id' => 'assigned',
                'title' => '2. Ditugaskan',
                'color' => 'sky',
                'dotColor' => 'bg-sky-500',
                'borderColor' => 'border-sky-400',
                'badgeClass' => 'bg-sky-100 text-sky-900 border-sky-300',
                'tickets' => $allKanbanTickets->where('status', 'assigned')->values(),
            ],
            'in_progress' => [
                'id' => 'in_progress',
                'title' => '3. Sedang Dikerjakan',
                'color' => 'indigo',
                'dotColor' => 'bg-indigo-500',
                'borderColor' => 'border-indigo-500',
                'badgeClass' => 'bg-indigo-100 text-indigo-900 border-indigo-300',
                'tickets' => $allKanbanTickets->where('status', 'in_progress')->values(),
            ],
            'pending_review' => [
                'id' => 'pending_review',
                'title' => '4. Review Supervisor',
                'color' => 'purple',
                'dotColor' => 'bg-purple-500',
                'borderColor' => 'border-purple-400',
                'badgeClass' => 'bg-purple-100 text-purple-900 border-purple-300',
                'tickets' => $allKanbanTickets->where('status', 'pending_review')->values(),
            ],
            'resolved' => [
                'id' => 'resolved',
                'title' => '5. Selesai Ditangani',
                'color' => 'emerald',
                'dotColor' => 'bg-emerald-500',
                'borderColor' => 'border-emerald-500',
                'badgeClass' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
                'tickets' => $allKanbanTickets->whereIn('status', ['resolved', 'closed'])->values(),
            ],
        ];

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
            'kanbanColumns',
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

        // Ambil semua teknisi aktif, lalu urutkan supaya yang spesialisasinya
        // cocok dengan group_type kategori tiket muncul lebih dulu di dropdown assign
        $groupType = $ticket->category->group_type ?? null;

        $technicians = User::technicians()->active()->with(['assignedTickets' => function ($q) {
            $q->whereIn('status', ['assigned', 'in_progress']);
        }])->get();

        if ($groupType) {
            $technicians = $technicians->sortByDesc(function ($tech) use ($groupType) {
                return $tech->specialization_group === $groupType;
            })->values();
        }

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

            // Kirim email ke teknisi saat divalidasi & langsung ditugaskan
            if (!empty($technician->email)) {
                try {
                    Mail::to($technician->email)->send(new TechnicianAssignedMail($ticket));
                } catch (\Exception $e) {
                    \Log::error('MAIL GAGAL: ' . $e->getMessage());
                }
            }

            return redirect()->back()->with('success', "Tiket {$ticket->ticket_number} divalidasi dan ditugaskan ke {$technician->name}.");
        }

        // Default: Masukkan ke Antrean Terbuka (Open Pool untuk diambil mandiri oleh teknisi)
        $ticket->update([
            'validation_status' => 'validated',
            'assigned_to' => null,
            'status' => 'open',
            'admin_notes' => $request->admin_notes,
        ]);

        $groupType = $ticket->category->group_type ?? null;
        $groupLabel = $ticket->category ? (strtoupper($ticket->category->group_type) . ' - ' . $ticket->category->name) : 'Tim IT';

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => 'validated',
            'changed_by' => Auth::id(),
            'note' => "Tiket divalidasi oleh Admin dan dimasukkan ke Antrean Terbuka ({$groupLabel}) untuk diambil oleh Teknisi.",
        ]);

        // Notifikasi ke teknisi yang spesialisasinya cocok dengan group_type kategori tiket
        $this->notifyMatchingTechnicians($ticket, $groupType);

        return redirect()->back()->with('success', "Tiket {$ticket->ticket_number} berhasil divalidasi dan dibuka ke Antrean Terbuka Tim.");
    }

    /**
     * Kirim email ke semua teknisi aktif yang specialization_group-nya
     * sama dengan group_type kategori tiket. Dipanggil saat tiket masuk
     * ke Antrean Terbuka supaya hanya teknisi yang relevan yang diberi tahu.
     */
    protected function notifyMatchingTechnicians(Ticket $ticket, ?string $groupType): void
    {
        if (!$groupType) {
            return;
        }

        $matchingTechnicians = User::technicians()->active()
            ->where('specialization_group', $groupType)
            ->get();

        foreach ($matchingTechnicians as $tech) {
            if (empty($tech->email)) {
                continue;
            }

            try {
                Mail::to($tech->email)->send(new TicketAvailableMail($ticket));
            } catch (\Exception $e) {
                \Log::error('MAIL GAGAL (pool): ' . $e->getMessage());
            }
        }
    }

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

        // Beri tahu ulang teknisi yang cocok spesialisasinya, karena tiket kembali ke pool
        $groupType = $ticket->category->group_type ?? null;
        $this->notifyMatchingTechnicians($ticket, $groupType);

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

        // Kirim email ke teknisi saat ditugaskan melalui aksi assign
        if (!empty($technician->email)) {
            try {
                Mail::to($technician->email)->send(new TechnicianAssignedMail($ticket));
            } catch (\Exception $e) {
                \Log::error('MAIL GAGAL: ' . $e->getMessage());
            }
        }

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

        // Mengambil email guest/pelapor secara aman berdasarkan struktur tabel tiket umum (guest_email / email / relasi creator)
        $guestEmail = $ticket->guest_email ?? $ticket->email ?? $ticket->creator?->email;

        if (!empty($guestEmail)) {
            try {
                Mail::to($guestEmail)->send(new TicketResolvedMail($ticket));
            } catch (\Exception $e) {
                \Log::error('MAIL GAGAL: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', "Tiket {$ticket->ticket_number} telah ditutup.");
    }

    /**
     * Endpoint live-check untuk lonceng notifikasi & pop-up toast real-time
     */
    public function checkNewTickets(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();

        // Jika teknisi: tampilkan tiket yang ditugaskan ke dirinya
        if ($user && ($user->hasRole('teknisi') && !$user->hasRole('admin') && !$user->hasRole('super_admin'))) {
            $tickets = Ticket::with(['unit', 'category', 'priority'])
                ->where('assigned_to', $user->id)
                ->whereIn('status', ['assigned', 'in_progress'])
                ->latest('updated_at')
                ->take(10)
                ->get();

            $type = 'assigned_task';
        } elseif ($user && ($user->hasRole('supervisor') && !$user->hasRole('admin') && !$user->hasRole('super_admin'))) {
            // Jika supervisor: tampilkan tiket software yang butuh review approval
            $tickets = Ticket::with(['unit', 'category', 'priority'])
                ->where('status', 'pending_review')
                ->latest('updated_at')
                ->take(10)
                ->get();

            $type = 'supervisor_review';
        } else {
            // Default: Admin / Super Admin (Tiket baru masuk yang pending / open / perlu validasi)
            $tickets = Ticket::with(['unit', 'category', 'priority'])
                ->where(function($query) {
                    $query->where('validation_status', 'pending')
                          ->orWhere('status', 'open')
                          ->orWhere('status', 'Menunggu Validasi');
                })
                ->latest('created_at')
                ->take(10)
                ->get();

            $type = 'new_ticket';
        }

        $notifications = $tickets->map(function($ticket) use ($user) {
            $url = match(true) {
                $user && $user->hasRole('teknisi') && !$user->hasRole('admin') => route('teknisi.dashboard', ['ticket_id' => $ticket->id]),
                $user && $user->hasRole('supervisor') && !$user->hasRole('admin') => route('supervisor.dashboard'),
                default => route('admin.tickets.show', $ticket->id),
            };

            return [
                'id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number ?? ('HD-' . str_pad($ticket->id, 4, '0', STR_PAD_LEFT)),
                'title' => $ticket->title ?? $ticket->subject ?? 'Pengaduan Layanan IT',
                'unit' => optional($ticket->unit)->name ?? 'Unit RSUD',
                'category' => optional($ticket->category)->name ?? 'Umum',
                'priority' => optional($ticket->priority)->name ?? 'Normal',
                'status' => $ticket->status,
                'time' => $ticket->created_at ? $ticket->created_at->diffForHumans() : 'Baru saja',
                'url' => $url,
            ];
        });

        $latest = $notifications->first();

        // Hitung total tiket yang berstatus 'pending' / butuh validasi admin secara real-time
        $pendingCount = Ticket::where(function($query) {
            $query->where('validation_status', 'pending')
                  ->orWhere('status', 'open')
                  ->orWhere('status', 'Menunggu Validasi');
        })->count();

        // Hitung total tiket aktif milik teknisi yang sedang login
        $myActiveCount = ($user && method_exists($user, 'hasRole') && $user->hasRole('teknisi'))
            ? Ticket::where('assigned_to', $user->id)->whereIn('status', ['assigned', 'in_progress'])->count()
            : 0;

        return response()->json([
            'type' => $type,
            'pending_count' => $pendingCount,
            'my_active_count' => $myActiveCount,
            'unread_count' => $notifications->count(),
            'latest_id' => $latest ? $latest['id'] : 0,
            'latest_ticket' => $latest,
            'notifications' => $notifications,
        ]);
    }
}