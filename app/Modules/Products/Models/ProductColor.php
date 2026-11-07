<?php

namespace App\Modules\Products\Models;

use App\Core\Tenancy\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;
    use HasTenant;

    protected $table = 'product_colors';

    protected $fillable = ['tenant_id', 'name', 'code', 'pantone_code', 'sort_order'];
}
