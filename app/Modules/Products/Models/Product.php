<?php

namespace App\Modules\Products\Models;

use App\Core\Tenancy\HasTenant;
use App\Support\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use HasTenant;
    use HasUlid;
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'tenant_id', 'style_number', 'name', 'slug', 'description',
        'category_id', 'type', 'gender', 'season', 'collection_id',
        'status', 'lifecycle_stage', 'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class, 'collection_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function getFullNameAttribute(): string
    {
        return "[{$this->style_number}] {$this->name}";
    }
}
