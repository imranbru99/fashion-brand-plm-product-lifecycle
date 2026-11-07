<?php

namespace App\Modules\Products\Models;

use App\Core\Tenancy\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;
    use HasTenant;

    protected $table = 'product_sizes';

    protected $fillable = ['tenant_id', 'name', 'abbreviation', 'size_group', 'sort_order'];
}
