<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCompanyScope;

class Maintenance extends Model
{
    use SoftDeletes, HasCompanyScope;

    protected $table = 'rms_maintenance';

    protected $fillable = [
        'company_id',
        'apartment_id',
        'title',
        'description',
        'priority',
        'status',
        'cost',
        'cost_bearer',
        'charge_method',
        'is_billed',
        'invoice_id',
        'photo_before',
        'photo_after',
        'vendor_name',
        'vendor_mobile',
        'scheduled_at',
        'resolved_at',
        'reported_by',
        'assigned_to',
        'resolved_by',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'cost'         => 'decimal:2',
        'is_billed'    => 'boolean',
        'scheduled_at' => 'datetime',
        'resolved_at'  => 'datetime',
        'deleted_at'   => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id'); // ✅ RMS namespace
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id'); // ✅ RMS namespace
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeOpen($query)
    {
        return $query->where('status', 'Open');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['Open', 'In Progress']);
    }

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }
}