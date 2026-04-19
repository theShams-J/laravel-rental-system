<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $table = 'rms_user_permissions';

    public $timestamps = false; // only has created_at

    protected $fillable = [
        'user_id',
        'permission_id',
        'is_granted',
        'created_by',
    ];

    protected $casts = [
        'is_granted' => 'boolean',
        'created_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
