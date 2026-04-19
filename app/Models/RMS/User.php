<?php

namespace App\Models\RMS;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\RMS\Company;
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'rms_users';

    protected $fillable = [
        'company_id',
        'role_id',
        'tenant_id',
        'name',
        'email',
        'password',
        'contact',
        'photo',
        'is_active',
        'last_login_at',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'deleted_at'        => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function rolePermissions()
    {
        return $this->role ? $this->role->permissions : collect();
    }

    public function userPermissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'rms_user_permissions',
            'user_id',
            'permission_id'
        )->withPivot('is_granted');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ── Role Helpers ──────────────────────────────────────

    public function isSuperAdmin(): bool
    {
        return $this->role?->name === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    // ── Permission Helpers ────────────────────────────────

    /**
     * Check if user has a given permission.
     * Priority: user-level override → role-level permission
     */
    public function hasPermission(string $permission): bool
    {
        // Super admin bypasses all permission checks
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Check user-level override first
        $userOverride = $this->userPermissions
            ->where('name', $permission)
            ->first();

        if ($userOverride) {
            return (bool) $userOverride->pivot->is_granted;
        }

        // Fall back to role permissions
        return $this->role
            ? $this->role->permissions->contains('name', $permission)
            : false;
    }

    public function canAny($abilities, $arguments = []): bool
{
    $abilities = is_array($abilities) ? $abilities : [$abilities];

    foreach ($abilities as $ability) {
        if ($this->hasPermission($ability)) {
            return true;
        }
    }

    return false;
}

    public function canAll(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
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
