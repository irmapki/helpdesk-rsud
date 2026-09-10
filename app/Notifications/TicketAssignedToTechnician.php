<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TicketAssignedToTechnician extends Notification
{
    use Queueable;

    public function __construct(public Ticket $ticket) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Tiket Baru Ditugaskan: {$this->ticket->ticket_number}")
            ->greeting("Halo {$notifiable->name},")
            ->line("Anda mendapat penugasan tiket baru.")
            ->line("Nomor Tiket: {$this->ticket->ticket_number}")
            ->line("Judul: {$this->ticket->title}")
            ->line("Unit: {$this->ticket->unit->name}")
            ->line("Prioritas: {$this->ticket->priority->name} (SLA {$this->ticket->priority->sla_hours} jam)")
            ->action('Lihat Tiket', route('teknisi.dashboard', ['ticket' => $this->ticket->id]))
            ->line('Mohon segera ditangani sesuai target SLA.');
    }
}