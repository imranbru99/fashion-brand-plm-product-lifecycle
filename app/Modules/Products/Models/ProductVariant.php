<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id', 'sku', 'color_id', 'size_id', 'barcode',
        'stock_quantity', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class, 'color_id');
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(ProductSize::class, 'size_id');
    }
}
