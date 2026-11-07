<?php

namespace App\Core\Tenancy;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Global scope that automatically filters queries by the current tenant.
 */
class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        /** @var TenantContext $context */
        $context = app(TenantContext::class);

        if ($context->hasTenant()) {
            $builder->where($model->getQualifiedTenantColumn(), $context->id());
        }
    }

    /**
     * Extend the query builder with necessary macros.
     */
    public function extend(Builder $builder): void
    {
        $builder->macro('withoutTenantScope', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });

        $builder->macro('forTenant', function (Builder $builder, string $tenantId) {
            return $builder
                ->withoutGlobalScope($this)
                ->where($builder->getModel()->getQualifiedTenantColumn(), $tenantId);
        });
    }
}
