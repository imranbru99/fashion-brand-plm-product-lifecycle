<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    */
    'name' => env('PLM_NAME', 'Fashion Brand PLM'),

    /*
    |--------------------------------------------------------------------------
    | Demo Mode
    |--------------------------------------------------------------------------
    */
    'demo_mode' => env('DEMO_MODE', false),
    'demo_user_password' => env('DEMO_USER_PASSWORD', 'DemoPass@2024'),

    /*
    |--------------------------------------------------------------------------
    | Platform Settings
    |--------------------------------------------------------------------------
    */
    'platform' => [
        'version' => '1.0.0',
        'currency_default' => env('PLM_CURRENCY', 'USD'),
        'timezone_default' => env('PLM_TIMEZONE', 'UTC'),
        'locale_default' => env('PLM_LOCALE', 'en'),
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Settings
    |--------------------------------------------------------------------------
    */
    'uploads' => [
        'max_size_mb' => env('PLM_MAX_UPLOAD_MB', 50),
        'allowed_image_types' => ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'],
        'allowed_document_types' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt'],
        'disk' => env('PLM_UPLOAD_DISK', 'local'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Product Settings
    |--------------------------------------------------------------------------
    */
    'products' => [
        'style_number_prefix' => env('PLM_STYLE_PREFIX', 'STY'),
        'sku_separator' => env('PLM_SKU_SEPARATOR', '-'),
        'seasons' => ['SS25', 'AW25', 'SS26', 'AW26', 'Resort25', 'Pre25'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Monitoring
    |--------------------------------------------------------------------------
    */
    'performance' => [
        'enabled' => env('PLM_PERFORMANCE_MONITORING', true),
        'slow_query_threshold_ms' => env('PLM_SLOW_QUERY_MS', 100),
        'log_slow_queries' => env('PLM_LOG_SLOW_QUERIES', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Attendance Settings
    |--------------------------------------------------------------------------
    */
    'attendance' => [
        'driver' => env('PLM_ATTENDANCE_DRIVER', 'fake'),
        'work_hours_per_day' => env('PLM_WORK_HOURS', 8),
    ],

];
