<?php

namespace App\Models;

use App\Support\Enums\ModuleStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantModule extends Model
{
    protected $fillable = [
        'tenant_id', 'module_id', 'status', 'settings', 'enabled_at', 'disabled_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ModuleStatus::class,
            'settings' => 'array',
            'enabled_at' => 'datetime',
            'disabled_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
