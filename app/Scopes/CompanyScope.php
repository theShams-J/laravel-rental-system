<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CompanyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     * Automatically filters all queries by the logged-in user's company_id.
     * Super admin (company_id = NULL) bypasses this scope entirely.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Only apply if a user is logged in
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();

        // Super admin has no company — bypass scope, sees everything
        if ($user->isSuperAdmin()) {
            return;
        }

        // Apply company filter for all other roles
        if ($user->company_id) {
            $builder->where($model->getTable() . '.company_id', $user->company_id);
        }
    }
}
