<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompanyScope;

class Notification extends Model
{
    use HasCompanyScope;

    protected $table = 'rms_notifications';

    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'user_id',
        'type',
        'message',
        'url',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read'    => 'boolean',
        'read_at'    => 'datetime',
        'created_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeUnread($query)
    {
        return $query->where('is_read', 0);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // ── Helpers ───────────────────────────────────────────

    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }
}