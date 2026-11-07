<?php

namespace App\Support\Enums;

enum TenantType: string
{
    case FashionBrand = 'fashion_brand';
    case Manufacturer = 'manufacturer';
    case Startup = 'startup';
    case TextileSupplier = 'textile_supplier';
    case SourcingAgency = 'sourcing_agency';
    case Wholesaler = 'wholesaler';
    case Retailer = 'retailer';
    case FullyIntegrated = 'fully_integrated';

    public function label(): string
    {
        return match ($this) {
            self::FashionBrand => 'Fashion Brand',
            self::Manufacturer => 'Garment Manufacturer',
            self::Startup => 'Fashion Startup',
            self::TextileSupplier => 'Textile Supplier',
            self::SourcingAgency => 'Sourcing Agency',
            self::Wholesaler => 'Wholesale Business',
            self::Retailer => 'Retail Business',
            self::FullyIntegrated => 'Fully Integrated Fashion Company',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::FashionBrand => '👗',
            self::Manufacturer => '🏭',
            self::Startup => '🚀',
            self::TextileSupplier => '🧶',
            self::SourcingAgency => '🌐',
            self::Wholesaler => '📦',
            self::Retailer => '🛍️',
            self::FullyIntegrated => '⭐',
        };
    }
}
