<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'status',
        'changed_by',
        'note',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'open' => 'Tiket Dibuat / Diajukan',
            'validated' => 'Tiket Divalidasi Admin',
            'assigned' => 'Tiket Ditugaskan ke Teknisi',
            'in_progress' => 'Teknisi Mulai Mengerjakan',
            'resolved' => 'Pengerjaan Selesai oleh Teknisi',
            'closed' => 'Tiket Ditutup',
            'rejected' => 'Tiket Ditolak',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }
}
