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

    public function getAttachmentsListAttribute(): array
    {
        if (empty($this->attachment)) {
            return [];
        }

        if (is_array($this->attachment)) {
            return $this->attachment;
        }

        $decoded = json_decode($this->attachment, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return [$this->attachment];
    }

    public static function isVideoFile(string $path): bool
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return in_array($extension, ['mp4', 'mov', 'avi', 'mkv', 'webm', '3gp', 'ogg']);
    }

    public static function isHeicFile(string $path): bool
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return in_array($extension, ['heic', 'heif']);
    }

    public static function getVideoMimeType(string $path): string
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return match ($extension) {
            'webm' => 'video/webm',
            'ogg' => 'video/ogg',
            '3gp' => 'video/3gpp',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo',
            'mkv' => 'video/x-matroska',
            default => 'video/mp4',
        };
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
    /**
     * Mengecek apakah kategori tiket membutuhkan review (Software / SIMRS).
     */
    public function requiresReview(): bool
    {
        $categoryName = strtolower($this->category?->name ?? '');
        return str_contains($categoryName, 'software') || str_contains($categoryName, 'simrs') || str_contains($categoryName, 'aplikasi');
    }
    public function getSlaStatusLabelAttribute(): string
    {
        return match ($this->sla_status) {
            'completed_on_time' => 'Selesai Tepat Waktu',
            'completed_late'    => 'Selesai Terlambat (Melebihi SLA)',
            'on_track'          => 'On Track (Dalam Batas SLA)',
            'approaching'       => 'Mendekati Batas SLA (< 2 Jam)',
            'breached'          => 'Terlewati (Breached SLA)',
            'rejected'          => 'Ditolak',
            default             => 'Normal',
        };
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
            'pending_review' => 'Menunggu Review Supervisor',
            'resolved' => 'Selesai (Menunggu Konfirmasi)',
            'closed' => 'Ditutup',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        if ($this->status === 'rejected' || $this->validation_status === 'rejected') {
            return 'bg-rose-100 text-rose-700 font-bold';
        }

        return match ($this->status) {
            'open' => 'bg-amber-100 text-amber-800 font-bold',
            'assigned' => 'bg-sky-100 text-sky-700 font-bold',
            'in_progress' => 'bg-indigo-100 text-indigo-700 font-bold',
            'pending_review' => 'bg-purple-100 text-purple-800 font-bold border border-purple-200',
            'resolved' => 'bg-emerald-100 text-emerald-700 font-bold',
            'closed' => 'bg-slate-100 text-slate-700 font-bold',
            default => 'bg-slate-100 text-slate-700 font-bold',
        };
    }
}
