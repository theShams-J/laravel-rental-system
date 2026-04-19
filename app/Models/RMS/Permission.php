<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'rms_permissions';

    protected $fillable = [
        'name',
        'label',
        'group',
    ];

    // ── Relationships ──────────────────────────────────────

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'rms_role_permissions',
            'permission_id',
            'role_id'
        );
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'rms_user_permissions',
            'permission_id',
            'user_id'
        )->withPivot('is_granted');
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeGroup($query, string $group)
    {
        return $query->where('group', $group);
    }
}
