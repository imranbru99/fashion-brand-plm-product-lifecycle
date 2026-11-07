<?php

namespace App\Support\Enums;

enum TenantStatus: string
{
    case Active = 'active';
    case Trial = 'trial';
    case Suspended = 'suspended';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Trial => 'Trial',
            self::Suspended => 'Suspended',
            self::Cancelled => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Trial => 'warning',
            self::Suspended => 'danger',
            self::Cancelled => 'gray',
        };
    }
}
