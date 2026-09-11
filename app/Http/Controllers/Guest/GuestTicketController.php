<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Ticket;
use App\Models\TicketStatusLog;
use App\Models\Unit;
use App\Models\User;
use App\Notifications\NewTicketNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Events\TicketCreatedEvent;

class GuestTicketController extends Controller
{
    public function landing(): View
    {
        $totalResolved = Ticket::whereIn('status', ['resolved', 'closed'])->count();
        $categories = Category::withCount('tickets')->get();
        $unitsCount = Unit::count();

        return view('welcome', compact('totalResolved', 'categories', 'unitsCount'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $priorities = Priority::all();
        $units = Unit::all();

        return view('guest.create', compact('categories', 'priorities', 'units'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_phone' => ['required', 'string', 'max:30'],
            'guest_email' => ['nullable', 'email', 'max:255'],
            'unit_id' => ['nullable'],
            'custom_unit_name' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'priority_id' => ['nullable', 'exists:priorities,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'mimes:jpg,jpeg,png,webp,heic,heif,mp4,mov,avi,mkv,webm,3gp', 'max:51200'],
            'attachment' => ['nullable'],
        ]);

        if ($request->unit_id === 'other' || !empty($request->custom_unit_name)) {
            $customName = trim((string) $request->custom_unit_name);
            if (empty($customName)) {
                return redirect()->back()->withInput()->withErrors(['custom_unit_name' => 'Silakan ketik nama ruangan / unit Anda.']);
            }
            $unit = Unit::firstOrCreate(
                ['name' => $customName],
                ['description' => 'Ruangan baru (ditambahkan pelapor)', 'location' => 'RSUD']
            );
            $validated['unit_id'] = $unit->id;
        } else {
            if (empty($validated['unit_id']) || !Unit::where('id', $validated['unit_id'])->exists()) {
                return redirect()->back()->withInput()->withErrors(['unit_id' => 'Silakan pilih unit atau ketik nama ruangan Anda.']);
            }
        }

        unset($validated['custom_unit_name']);

        if (empty($validated['priority_id'])) {
            $defaultPriority = Priority::where('name', 'Medium')->first() ?? Priority::first();
            $validated['priority_id'] = $defaultPriority?->id;
        }

        $storedPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $storedPaths[] = $file->store('attachments', 'public');
            }
        } elseif ($request->hasFile('attachment')) {
            $storedPaths[] = $request->file('attachment')->store('attachments', 'public');
        }

        if (!empty($storedPaths)) {
            $validated['attachment'] = json_encode($storedPaths);
        } else {
            $validated['attachment'] = null;
        }

        unset($validated['attachments']);

        $ticketNumber = Ticket::generateTicketNumber();
        $validated['ticket_number'] = $ticketNumber;
        
        // Diselaraskan dengan pengecekan lonceng admin (status open dan validation_status pending)
        $validated['status'] = 'open';
        $validated['validation_status'] = 'pending';

        $ticket = Ticket::create($validated);
        
        event(new TicketCreatedEvent($ticket));

        // Mengirimkan database notification ke Admin dan Super Admin
        $admins = User::whereHas('role', function($query) {
            $query->whereIn('name', ['admin', 'super_admin']);
        })->get();

        foreach ($admins as $admin) {
            $admin->notify(new NewTicketNotification($ticket));
        }

        try {
            Mail::raw(
                "Halo Tim Admin & Teknisi,\n\nAda pengaduan/tiket baru masuk dengan detail berikut:\n" .
                "- No Tiket: {$ticket->ticket_number}\n" .
                "- Pelapor: {$ticket->guest_name}\n" .
                "- Unit/Ruangan: " . ($ticket->unit?->name ?? '-') . "\n" .
                "- Judul Masalah: {$ticket->title}\n" .
                "- Deskripsi: {$ticket->description}\n\n" .
                "Silakan buka Dashboard Helpdesk RSUD untuk menindaklanjuti tiket ini.", 
                function ($message) use ($ticket) {
                    $message->to('admin.helpdesk@rsud.co.id')
                            ->subject("Notifikasi Tiket Baru: " . $ticket->ticket_number);
                }
            );
        } catch (\Exception $e) {
            // Mencegah error email menghentikan proses redirect
        }

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => 'open',
            'changed_by' => null,
            'note' => "Pengaduan baru diajukan oleh {$ticket->guest_name} (" . ($ticket->unit?->name ?? '-') . ") melalui Portal Helpdesk RSUD.",
        ]);

        return redirect()->route('guest.ticket.success', ['ticket_number' => $ticketNumber])
            ->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function success(string $ticket_number): View
    {
        $ticket = Ticket::with(['unit', 'category', 'priority'])
            ->where('ticket_number', $ticket_number)
            ->firstOrFail();

        return view('guest.success', compact('ticket'));
    }

    public function track(Request $request): View
    {
        $ticket = null;
        $searchNumber = $request->query('ticket_number');

        if ($searchNumber) {
            $ticket = Ticket::with(['unit', 'category', 'priority', 'technician', 'statusLogs.user'])
                ->where('ticket_number', trim($searchNumber))
                ->first();
        }

        return view('guest.track', compact('ticket', 'searchNumber'));
    }

    public function uploadAttachment(Request $request, string $ticket_number): RedirectResponse
    {
        $ticket = Ticket::where('ticket_number', $ticket_number)->firstOrFail();

        $request->validate([
            'attachments' => ['required', 'array', 'min:1'],
            'attachments.*' => ['file', 'mimes:jpg,jpeg,png,webp,heic,heif,mp4,mov,avi,mkv,webm,3gp', 'max:51200'],
        ]);

        $existing = $ticket->attachments_list;
        $newPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $newPaths[] = $file->store('attachments', 'public');
            }
        }

        $merged = array_merge($existing, $newPaths);
        $ticket->update(['attachment' => json_encode($merged)]);

        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => $ticket->status,
            'changed_by' => null,
            'note' => 'Pelapor mengunggah ' . count($newPaths) . ' berkas bukti kendala baru (foto/video).',
        ]);

        return redirect()->back()->with('success', 'Bukti kendala tambahan berhasil diunggah.');
    }

    public function submitFeedback(Request $request, string $ticket_number): RedirectResponse
    {
        $ticket = Ticket::where('ticket_number', $ticket_number)->firstOrFail();

        if (!in_array($ticket->status, ['resolved', 'closed'])) {
            return redirect()->back()->with('error', 'Penilaian hanya dapat diberikan setelah tiket selesai ditangani.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'feedback' => ['nullable', 'string', 'max:1000'],
        ]);

        $ticket->update($validated);

        return redirect()->back()->with('success', 'Terima kasih atas penilaian dan masukan yang Anda berikan!');
    }
}