<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends SpatieRole
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name',
    ];

    public function legacyUsers(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getLabelAttribute(): string
    {
        return match ($this->name) {
            'super_admin' => 'Super Admin',
            'admin' => 'Admin Helpdesk',
            'teknisi' => 'Teknisi IT',
            'supervisor' => 'Supervisor IT',
            default => ucfirst($this->name),
        };
    }
}
