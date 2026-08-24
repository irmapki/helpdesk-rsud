<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Priority extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sla_hours',
        'color',
        'description',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function getBadgeClassAttribute(): string
    {
        return match (strtolower($this->name)) {
            'high', 'critical', 'darurat', 'tinggi' => 'bg-rose-100 text-rose-700 font-bold',
            'medium', 'sedang' => 'bg-amber-100 text-amber-800 font-bold',
            'low', 'rendah' => 'bg-emerald-100 text-emerald-700 font-bold',
            default => 'bg-slate-100 text-slate-700 font-bold',
        };
    }
}
