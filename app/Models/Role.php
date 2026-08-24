<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function users(): HasMany
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
