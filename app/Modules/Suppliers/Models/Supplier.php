<?php

namespace App\Modules\Suppliers\Models;

use App\Core\Tenancy\HasTenant;
use App\Support\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use HasTenant;
    use HasUlid;
    use SoftDeletes;

    protected $table = 'suppliers';

    protected $fillable = [
        'tenant_id', 'name', 'code', 'type', 'status', 'country', 'city',
        'address', 'website', 'email', 'phone', 'payment_terms', 'currency',
        'rating', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:1',
        ];
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(SupplierContact::class, 'supplier_id');
    }

    public function primaryContact(): HasMany
    {
        return $this->hasMany(SupplierContact::class, 'supplier_id')->where('is_primary', true);
    }

    public function getTypeOptions(): array
    {
        return ['fabric' => 'Fabric Supplier', 'trim' => 'Trim Supplier', 'factory' => 'Factory', 'logistics' => 'Logistics', 'other' => 'Other'];
    }
}
