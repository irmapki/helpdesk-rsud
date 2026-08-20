<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Ticket;
use App\Models\TicketStatusLog;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

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
            'unit_id' => ['required', 'exists:units,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'priority_id' => ['nullable', 'exists:priorities,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'attachment' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // Max 5MB image
        ]);

        // Default priority to Medium if not specified
        if (empty($validated['priority_id'])) {
            $defaultPriority = Priority::where('name', 'Medium')->first() ?? Priority::first();
            $validated['priority_id'] = $defaultPriority?->id;
        }

        // Handle attachment upload
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $validated['attachment'] = $path;
        }

        $ticketNumber = Ticket::generateTicketNumber();
        $validated['ticket_number'] = $ticketNumber;
        $validated['status'] = 'open';
        $validated['validation_status'] = 'pending';

        $ticket = Ticket::create($validated);

        // Record initial status log
        TicketStatusLog::create([
            'ticket_id' => $ticket->id,
            'status' => 'open',
            'changed_by' => null,
            'note' => "Pengaduan baru diajukan oleh {$ticket->guest_name} ({$ticket->unit->name}) melalui Portal Helpdesk RSUD.",
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
            $ticket = Ticket::with(['unit', 'category', 'priority', 'technician', 'statusLogs'])
                ->where('ticket_number', trim($searchNumber))
                ->first();
        }

        return view('guest.track', compact('ticket', 'searchNumber'));
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
