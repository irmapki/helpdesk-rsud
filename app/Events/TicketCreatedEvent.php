<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // Mengirim pesan secara instan (tanpa antrean queue)
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketCreatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        // Ambil data tiket beserta relasi unit dan kategori
        $this->ticket = $ticket->load(['unit', 'category']);
    }

    // Saluran (channel) publik yang akan didengarkan oleh browser Admin
    public function broadcastOn(): array
    {
        return [
            new Channel('tickets-channel'),
        ];
    }

    // Menentukan nama event spesifik agar mudah didengarkan oleh Echo
    public function broadcastAs(): string
    {
        return 'ticket.created';
    }

    // Data ringkas yang dikirimkan ke layar browser
    public function broadcastWith(): array
    {
        return [
            'ticket_number' => $this->ticket->ticket_number,
            'title'         => $this->ticket->title,
            'reporter'      => $this->ticket->reporter_name,
            'unit'          => $this->ticket->unit->name ?? 'Unit RSUD',
            'category'      => $this->ticket->category->name ?? 'Umum',
            'created_at'    => $this->ticket->created_at->format('H:i') . ' WIB',
        ];
    }
}