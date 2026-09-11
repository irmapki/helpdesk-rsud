<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewTicketNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_number' => $this->ticket->ticket_number,
            'guest_name' => $this->ticket->guest_name ?? 'Pelapor',
            'title' => $this->ticket->title ?? 'Tiket Pengaduan Baru',
            'unit_name' => $this->ticket->unit?->name ?? 'Umum',
            'message' => 'Tiket baru dari ' . ($this->ticket->guest_name ?? 'Pelapor') . ' (' . $this->ticket->ticket_number . ')',
            'url' => route('admin.tickets.show', $this->ticket->id),
        ];
    }
}