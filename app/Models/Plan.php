<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'monthly_price', 'annual_price',
        'trial_days', 'max_users', 'max_storage_gb', 'max_factories',
        'max_warehouses', 'features', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'monthly_price' => 'decimal:2',
            'annual_price' => 'decimal:2',
            'features' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
