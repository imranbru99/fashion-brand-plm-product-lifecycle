<?php

namespace App\Support\Enums;

enum UserType: string
{
    case Platform = 'platform';
    case Tenant = 'tenant';
    case Supplier = 'supplier';
    case Buyer = 'buyer';
    case Customer = 'customer';
}
