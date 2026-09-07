<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Klasifikasi tipe divisi kendala: software vs hardware/jaringan.
     */
    public function getGroupTypeAttribute(): string
    {
        $name = strtolower($this->name);
        if (str_contains($name, 'simrs') || str_contains($name, 'software') || str_contains($name, 'bpjs') || str_contains($name, 'aplikasi') || str_contains($name, 'sistem') || str_contains($name, 'vclaim')) {
            return 'software';
        }
        return 'hardware';
    }
}
