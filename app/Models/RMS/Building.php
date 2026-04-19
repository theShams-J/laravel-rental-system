<?php

namespace App\Models\RMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCompanyScope;
use App\Models\RMS\Company;

class Building extends Model
{
    use SoftDeletes, HasCompanyScope;

    protected $table = 'rms_buildings';

    protected $fillable = [
        'company_id',
        'name',
        'contact',
        'email',
        'address',
        'city_id',
        'country_id',
        'total_floors',
        'total_units',
        'photo',
        'description',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'deleted_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'building_id');
    }

    // public function apartments_count()
    // {
    //     return $this->hasMany(Apartment::class, 'building_id');
    // }

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
        return $query->where('is_active', 1);
    }

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}
