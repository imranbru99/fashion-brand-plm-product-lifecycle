<?php

namespace App\Support\Enums;

enum ProductStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Development = 'development';
    case Sampling = 'sampling';
    case Production = 'production';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Active => 'Active',
            self::Development => 'In Development',
            self::Sampling => 'Sampling',
            self::Production => 'In Production',
            self::Archived => 'Archived',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Active => 'success',
            self::Development => 'warning',
            self::Sampling => 'info',
            self::Production => 'primary',
            self::Archived => 'danger',
        };
    }
}
