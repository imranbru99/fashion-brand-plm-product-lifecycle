<?php

namespace App\Core\Tenancy;

use App\Models\Tenant;

/**
 * Singleton service holding the current tenant context.
 */
class TenantContext
{
    private ?Tenant $tenant = null;

    /**
     * Set the current tenant.
     */
    public function set(Tenant $tenant): void
    {
        $this->tenant = $tenant;
    }

    /**
     * Get the current tenant.
     */
    public function get(): ?Tenant
    {
        return $this->tenant;
    }

    /**
     * Get the current tenant ID.
     */
    public function id(): ?string
    {
        return $this->tenant?->id;
    }

    /**
     * Check if a tenant is set.
     */
    public function hasTenant(): bool
    {
        return $this->tenant !== null;
    }

    /**
     * Clear the current tenant.
     */
    public function clear(): void
    {
        $this->tenant = null;
    }

    /**
     * Execute a callback in the context of a given tenant.
     *
     * @template T
     * @param  Tenant   $tenant
     * @param  callable(): T  $callback
     * @return T
     */
    public function run(Tenant $tenant, callable $callback): mixed
    {
        $previous = $this->tenant;
        $this->set($tenant);

        try {
            return $callback();
        } finally {
            $this->tenant = $previous;
        }
    }
}
