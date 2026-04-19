<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCompanyScope;
use App\Models\RMS\Tenant;
use App\Models\RMS\Company;

class Lease extends Model
{
    use SoftDeletes, HasCompanyScope;

    protected $table = 'rms_leases';

    protected $fillable = [
        'company_id',
        'tenant_id',
        'apartment_id',
        'start_date',
        'end_date',
        'monthly_rent',
        'security_deposit',
        'total_paid',
        'rent_due_day',
        'grace_period_days',
        'late_fee_amount',
        'late_fee_percent',
        'notice_period_days',
        'agreement_document',
        'status',
        'renewed_from_lease_id',
        'terminated_at',
        'termination_reason',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'monthly_rent'     => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'total_paid'       => 'decimal:2',
        'late_fee_amount'  => 'decimal:2',
        'late_fee_percent' => 'decimal:2',
        'start_date'       => 'date',
        'end_date'         => 'date',
        'terminated_at'    => 'datetime',
        'deleted_at'       => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'lease_id');
    }

    public function receipts()
    {
        return $this->hasMany(MoneyReceipt::class, 'lease_id');
    }

    public function renewedFrom()
    {
        return $this->belongsTo(Lease::class, 'renewed_from_lease_id');
    }

    public function renewals()
    {
        return $this->hasMany(Lease::class, 'renewed_from_lease_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\RMS\User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\RMS\User::class, 'updated_by');
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}
