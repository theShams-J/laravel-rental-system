<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'rms_cities';

    public $timestamps = false;

    protected $fillable = [
        'country_id',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────────

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function buildings()
    {
        return $this->hasMany(Building::class, 'city_id');
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
