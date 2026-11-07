<?php

namespace App\Core\Tenancy;

use App\Models\Tenant;

/**
 * Trait applied to all tenant-owned Eloquent models.
 * Automatically applies TenantScope and sets tenant_id on creation.
 */
trait HasTenant
{
    /**
     * Boot the trait and register the global scope.
     */
    public static function bootHasTenant(): void
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function (self $model) {
            if (empty($model->tenant_id)) {
                /** @var TenantContext $context */
                $context = app(TenantContext::class);

                if ($context->hasTenant()) {
                    $model->tenant_id = $context->id();
                }
            }
        });
    }

    /**
     * Get the tenant column name used by this model.
     */
    public function getTenantColumn(): string
    {
        return 'tenant_id';
    }

    /**
     * Get the qualified tenant column name.
     */
    public function getQualifiedTenantColumn(): string
    {
        return $this->getTable() . '.' . $this->getTenantColumn();
    }

    /**
     * Relationship: belongs to a tenant.
     */
    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
