<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCompanyScope;
use App\Models\RMS\Company;
use App\Models\RMS\building;

class Apartment extends Model
{
    use SoftDeletes, HasCompanyScope;

    protected $table = 'rms_apartments';

    protected $fillable = [
        'company_id',
        'building_id',
        'type_id',
        'apartment_no',
        'floor',
        'rent',
        'size_sqft',
        'num_bedrooms',
        'num_bathrooms',
        'has_parking',
        'is_furnished',
        'facing',
        'photo',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'rent'         => 'decimal:2',
        'has_parking'  => 'boolean',
        'is_furnished' => 'boolean',
        'deleted_at'   => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function apartmentType()
    {
        return $this->belongsTo(ApartmentType::class, 'type_id');
    }

    public function leases()
    {
        return $this->hasMany(Lease::class, 'apartment_id');
    }

    public function activeLease()
    {
        return $this->hasOne(Lease::class, 'apartment_id')
                    ->where('status', 'Active');
    }

    public function maintenance()
    {
        return $this->hasMany(\App\Models\RMS\Maintenance::class, 'apartment_id');
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

    public function scopeAvailable($query)
    {
        return $query->where('status', 'Available');
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', 'Occupied');
    }

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }
    public function getFullNameAttribute(): string
{
    return $this->apartment_no . ' (' . ($this->building->name ?? 'N/A') . ')';
}

}
