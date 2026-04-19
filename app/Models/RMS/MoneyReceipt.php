<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCompanyScope;
use App\Models\RMS\Tenant;
use App\Models\RMS\Company;
use App\Models\RMS\User;

class MoneyReceipt extends Model
{
    use SoftDeletes, HasCompanyScope;

    protected $table = 'rms_moneyreceipts';

    protected $fillable = [
        'company_id',
        'invoice_id',
        'tenant_id',
        'lease_id',
        'payment_method',
        'transaction_no',
        'reference_no',
        'remark',
        'receipt_total',
        'discount',
        'vat',
        'received_by',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'receipt_total' => 'decimal:2',
        'discount'      => 'decimal:2',
        'vat'           => 'decimal:2',
        'deleted_at'    => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id');
    }

    public function details()
    {
        return $this->hasMany(MoneyReceiptDetail::class, 'money_receipt_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
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

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}
