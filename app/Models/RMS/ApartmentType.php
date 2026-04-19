<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;

class ApartmentType extends Model
{
    protected $table = 'rms_apartment_types';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────────

    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'type_id');
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
