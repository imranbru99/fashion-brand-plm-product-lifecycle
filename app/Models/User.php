<?php

namespace App\Models;

use App\Core\Tenancy\HasTenant;
use App\Support\Enums\UserType;
use App\Support\Traits\HasUlid;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'tenant_id', 'employee_id',
        'type', 'status', 'avatar', 'job_title', 'phone',
        'timezone', 'locale', 'last_login_at', 'demo_account',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'type' => UserType::class,
            'last_login_at' => 'datetime',
            'demo_account' => 'boolean',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function isPlatformUser(): bool
    {
        return $this->type === UserType::Platform;
    }

    public function isTenantAdmin(): bool
    {
        return $this->hasRole('Tenant Administrator');
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->status === 'active';
    }
}
