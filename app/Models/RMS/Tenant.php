<?php

namespace App\Models\RMS;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCompanyScope;
use App\Models\RMS\Company;
use App\Models\RMS\User;
use App\Models\RMS\Lease;
use App\Models\RMS\Invoice;
use App\Models\RMS\MoneyReceipt;
use App\Models\RMS\Country;

class Tenant extends Model
{
    use SoftDeletes, HasCompanyScope;

    protected $table = 'rms_tenants';

    protected $fillable = [
        'company_id',
        'name',
        'nid',
        'contact',
        'email',
        'gender',
        'date_of_birth',
        'profession',
        'address',
        'photo',
        'nid_front',
        'nid_back',
        'postcode',
        'city',
        'country_id',
        'emergency_contact_name',
        'emergency_contact_mobile',
        'emergency_contact_relation',
        'remarks',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'date_of_birth' => 'date',
        'deleted_at'    => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function leases()
    {
        return $this->hasMany(Lease::class, 'tenant_id');
    }

    public function activeLease()
    {
        return $this->hasOne(Lease::class, 'tenant_id')
                    ->where('status', 'Active');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'tenant_id');
    }

    public function receipts()
    {
        return $this->hasMany(MoneyReceipt::class, 'tenant_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'tenant_id');
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

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}
