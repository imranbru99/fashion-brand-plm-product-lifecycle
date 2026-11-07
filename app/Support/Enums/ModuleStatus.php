<?php

namespace App\Support\Enums;

enum ModuleStatus: string
{
    case Enabled = 'enabled';
    case Disabled = 'disabled';
    case Trial = 'trial';
    case Locked = 'locked';
    case PendingConfiguration = 'pending_configuration';
    case Maintenance = 'maintenance';

    public function label(): string
    {
        return match ($this) {
            self::Enabled => 'Enabled',
            self::Disabled => 'Disabled',
            self::Trial => 'Trial',
            self::Locked => 'Locked',
            self::PendingConfiguration => 'Pending Configuration',
            self::Maintenance => 'Maintenance',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Enabled => 'success',
            self::Disabled => 'gray',
            self::Trial => 'warning',
            self::Locked => 'danger',
            self::PendingConfiguration => 'info',
            self::Maintenance => 'warning',
        };
    }
}
