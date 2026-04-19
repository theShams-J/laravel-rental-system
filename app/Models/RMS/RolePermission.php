<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'rms_role_permissions';

    public $timestamps = false; // only has created_at

    protected $fillable = [
        'role_id',
        'permission_id',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
