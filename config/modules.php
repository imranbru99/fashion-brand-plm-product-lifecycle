<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Module Registry Settings
    |--------------------------------------------------------------------------
    */
    'namespace' => 'App\\Modules',
    'path' => app_path('Modules'),

    /*
    |--------------------------------------------------------------------------
    | Module Discovery
    |--------------------------------------------------------------------------
    | Automatically discover and register module definitions
    */
    'auto_discover' => true,

    /*
    |--------------------------------------------------------------------------
    | Core Modules
    |--------------------------------------------------------------------------
    | These modules are always enabled and cannot be disabled by tenants
    */
    'core_modules' => [
        'platform',
        'users',
        'settings',
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Categories
    |--------------------------------------------------------------------------
    */
    'categories' => [
        'design' => 'Design & Development',
        'sourcing' => 'Sourcing & Materials',
        'production' => 'Production & Manufacturing',
        'supply_chain' => 'Supply Chain & Logistics',
        'sales' => 'Sales & Commerce',
        'finance' => 'Finance & Accounting',
        'hr' => 'Human Resources',
        'analytics' => 'Analytics & Reporting',
        'platform' => 'Platform & Administration',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 3600,
        'key_prefix' => 'plm_modules_',
    ],

];
