<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RMS\User;
class Company extends Model
{
    use SoftDeletes;

    protected $table = 'rms_companies';

    protected $fillable = [
        'name',
        'contact',
        'bin',
        'email',
        'website',
        'city',
        'area',
        'street_address',
        'post_code',
        'logo',
        'trade_license',
        'tagline',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'deleted_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────

    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    public function admins()
    {
        return $this->hasMany(User::class, 'company_id')
                    ->where('role_id', 2);
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
