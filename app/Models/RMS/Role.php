<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'rms_roles';

    protected $fillable = [
        'name',
        'label',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────────

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'rms_role_permissions',
            'role_id',
            'permission_id'
        );
    }

    // ── Helpers ───────────────────────────────────────────

    public function hasPermission(string $name): bool
    {
        return $this->permissions->contains('name', $name);
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
