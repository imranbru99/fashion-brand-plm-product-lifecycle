<?php

namespace App\Models;

use App\Support\Enums\TenantStatus;
use App\Support\Enums\TenantType;
use App\Support\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory;
    use HasUlid;
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'domain', 'subdomain', 'type', 'status',
        'plan_id', 'settings', 'trial_ends_at',
    ];

    protected function casts(): array
    {
        return [
            'type' => TenantType::class,
            'status' => TenantStatus::class,
            'settings' => 'array',
            'trial_ends_at' => 'datetime',
        ];
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(TenantModule::class);
    }

    public function subscription(): HasMany
    {
        return $this->hasMany(Subscription::class)->latest();
    }

    public function isOnTrial(): bool
    {
        return $this->status === TenantStatus::Trial && $this->trial_ends_at?->isFuture();
    }

    public function isActive(): bool
    {
        return $this->status === TenantStatus::Active || $this->isOnTrial();
    }
}
