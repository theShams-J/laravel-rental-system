<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'rms_countries';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'currency',
        'currency_symbol',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────────

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id');
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
