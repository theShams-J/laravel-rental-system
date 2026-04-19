<?php

namespace App\Traits;

use App\Scopes\CompanyScope;

trait HasCompanyScope
{
    /**
     * Boot the trait — automatically registers CompanyScope
     * on any model that uses this trait.
     */
    protected static function bootHasCompanyScope(): void
    {
        static::addGlobalScope(new CompanyScope());
    }

    /**
     * Remove company scope for a specific query.
     * Useful when super admin needs to query without scope explicitly.
     * Usage: Model::withoutCompanyScope()->get()
     */
    public static function withoutCompanyScope()
    {
        return static::withoutGlobalScope(CompanyScope::class);
    }
}
