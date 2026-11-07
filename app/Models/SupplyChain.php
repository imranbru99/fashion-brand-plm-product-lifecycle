<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyChain extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'product_id',
        'quantity',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(FashionProduct::class);
    }
}
