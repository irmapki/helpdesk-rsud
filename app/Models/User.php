<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
        'unit_id',
        'specialization',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function collaboratedTickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'ticket_collaborators', 'user_id', 'ticket_id')
                    ->withPivot('role_in_team')
                    ->withTimestamps();
    }

    public function createdTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'created_by');
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(TicketStatusLog::class, 'changed_by');
    }

    public function ticketNotes(): HasMany
    {
        return $this->hasMany(TicketNote::class, 'user_id');
    }

    public function scopeTechnicians(Builder $query): Builder
    {
        return $query->whereHas('role', function ($q) {
            $q->where('name', 'teknisi');
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function hasRole(string ...$roles): bool
    {
        return $this->role && in_array($this->role->name, $roles);
    }

    public function getActiveTicketsCountAttribute(): int
    {
        return $this->assignedTickets()
            ->whereIn('status', ['assigned', 'in_progress', 'open'])
            ->count();
    }

    public function getResolvedTicketsCountAttribute(): int
    {
        return $this->assignedTickets()
            ->whereIn('status', ['resolved', 'closed'])
            ->count();
    }
}