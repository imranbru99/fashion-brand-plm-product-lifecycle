<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Tenancy Mode
    |--------------------------------------------------------------------------
    | single-database: All tenants share one database (recommended)
    | multi-database: Each tenant has its own database
    */
    'mode' => env('TENANCY_MODE', 'single-database'),

    /*
    |--------------------------------------------------------------------------
    | Tenant Resolution
    |--------------------------------------------------------------------------
    | How to resolve the current tenant:
    | - auth: Resolve from authenticated user's tenant_id
    | - subdomain: Resolve from request subdomain
    | - header: Resolve from X-Tenant-ID header
    */
    'resolution' => env('TENANCY_RESOLUTION', 'auth'),

    /*
    |--------------------------------------------------------------------------
    | Tenant Model
    |--------------------------------------------------------------------------
    */
    'tenant_model' => \App\Models\Tenant::class,

    /*
    |--------------------------------------------------------------------------
    | Global Scope
    |--------------------------------------------------------------------------
    | Whether to automatically apply tenant scope to all tenant-owned models
    */
    'auto_scope' => true,

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 1800,
        'key_prefix' => 'tenant_',
    ],

    /*
    |--------------------------------------------------------------------------
    | Platform Users
    |--------------------------------------------------------------------------
    | User IDs that bypass tenant scoping (super admins)
    */
    'platform_users' => [],

    /*
    |--------------------------------------------------------------------------
    | Trial Settings
    |--------------------------------------------------------------------------
    */
    'trial' => [
        'days' => env('TENANCY_TRIAL_DAYS', 14),
    ],

];
