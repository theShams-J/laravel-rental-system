<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCompanyScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\RMS\Tenant;
use App\Models\RMS\Company;

class Invoice extends Model
{
    use SoftDeletes, HasCompanyScope;

    protected $table = 'rms_invoices';

    protected $fillable = [
        'company_id',
        'lease_id',
        'tenant_id',
        'amount',
        'invoice_date',
        'due_date',
        'period',
        'late_fee',
        'late_fee_date',
        'status',
        'notes',
        'paid_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'amount'        => 'decimal:2',
        'late_fee'      => 'decimal:2',
        'invoice_date'  => 'date',
        'due_date'      => 'date',
        'late_fee_date' => 'date',
        'paid_at'       => 'datetime',
        'deleted_at'    => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function lease(): BelongsTo
    {
        return $this->belongsTo(Lease::class, 'lease_id');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(MoneyReceipt::class, 'invoice_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\RMS\User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\RMS\User::class, 'updated_by');
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'Overdue');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'Paid');
    }

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}
