<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'title',
        'description',
        'attachment',
        'category_id',
        'priority_id',
        'unit_id',
        'created_by',
        'guest_name',
        'guest_email',
        'guest_phone',
        'assigned_to',
        'status',
        'validation_status',
        'admin_notes',
        'rejection_reason',
        'assigned_at',
        'resolved_at',
        'closed_at',
        'rating',
        'feedback',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'resolved_at' => 'datetime',
            'closed_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'rating' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(TicketStatusLog::class)->orderBy('created_at', 'asc');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(TicketNote::class)->orderBy('created_at', 'desc');
    }

    public static function generateTicketNumber(): string
    {
        $prefix = 'HD-' . date('Ymd') . '-';
        $latest = self::where('ticket_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if (!$latest) {
            $number = 1;
        } else {
            $lastNumber = (int) substr($latest->ticket_number, -4);
            $number = $lastNumber + 1;
        }

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function getReporterNameAttribute(): string
    {
        if ($this->creator) {
            return $this->creator->name;
        }
        return $this->guest_name ?: 'Pelapor Tamu/Umum';
    }

    public function getReporterContactAttribute(): string
    {
        return $this->guest_phone ?: ($this->creator?->phone ?: ($this->guest_email ?: ($this->creator?->email ?: '-')));
    }

    public function getSlaDeadlineAttribute(): ?Carbon
    {
        if (!$this->created_at || !$this->priority) {
            return null;
        }
        return $this->created_at->copy()->addHours($this->priority->sla_hours);
    }

    public function getSlaStatusAttribute(): string
    {
        if (in_array($this->status, ['resolved', 'closed'])) {
            $completionTime = $this->resolved_at ?? $this->closed_at ?? $this->updated_at;
            $deadline = $this->sla_deadline;
            if ($deadline && $completionTime->gt($deadline)) {
                return 'completed_late';
            }
            return 'completed_on_time';
        }

        if ($this->status === 'rejected') {
            return 'rejected';
        }

        $deadline = $this->sla_deadline;
        if (!$deadline) {
            return 'normal';
        }

        $now = Carbon::now();
        if ($now->gt($deadline)) {
            return 'breached';
        }

        // Less than 2 hours remaining
        if ($now->diffInHours($deadline, false) <= 2) {
            return 'approaching';
        }

        return 'on_track';
    }

    public function getStatusLabelAttribute(): string
    {
        if ($this->status === 'rejected' || $this->validation_status === 'rejected') {
            return 'Ditolak';
        }

        return match ($this->status) {
            'open' => 'Menunggu Validasi',
            'assigned' => 'Sudah Ditugaskan',
            'in_progress' => 'Sedang Dikerjakan',
            'resolved' => 'Selesai (Menunggu Konfirmasi)',
            'closed' => 'Ditutup',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        if ($this->status === 'rejected' || $this->validation_status === 'rejected') {
            return 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/40 dark:text-red-300 dark:border-red-800';
        }

        return match ($this->status) {
            'open' => 'bg-amber-100 text-amber-800 border-amber-200 dark:bg-amber-900/40 dark:text-amber-300 dark:border-amber-800',
            'assigned' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800',
            'in_progress' => 'bg-indigo-100 text-indigo-800 border-indigo-200 dark:bg-indigo-900/40 dark:text-indigo-300 dark:border-indigo-800',
            'resolved' => 'bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-300 dark:border-emerald-800',
            'closed' => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600',
            default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600',
        };
    }
}
