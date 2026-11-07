<?php

namespace App\Modules\Materials\Models;

use App\Core\Tenancy\HasTenant;
use App\Modules\Suppliers\Models\Supplier;
use App\Support\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory;
    use HasTenant;
    use HasUlid;
    use SoftDeletes;

    protected $table = 'materials';

    protected $fillable = [
        'tenant_id', 'name', 'code', 'type', 'composition', 'gsm',
        'width_cm', 'weight_gsm', 'description', 'unit', 'unit_cost',
        'currency', 'supplier_id', 'category_id', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'gsm' => 'decimal:2',
            'width_cm' => 'decimal:2',
            'unit_cost' => 'decimal:4',
            'is_active' => 'boolean',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }

    public function getTypeOptions(): array
    {
        return ['fabric' => 'Fabric', 'trim' => 'Trim', 'accessory' => 'Accessory', 'packaging' => 'Packaging', 'other' => 'Other'];
    }
}
