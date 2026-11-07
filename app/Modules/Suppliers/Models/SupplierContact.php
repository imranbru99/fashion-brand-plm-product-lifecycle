<?php

namespace App\Modules\Suppliers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierContact extends Model
{
    use HasFactory;

    protected $table = 'supplier_contacts';

    protected $fillable = ['supplier_id', 'name', 'title', 'email', 'phone', 'is_primary'];

    protected function casts(): array
    {
        return ['is_primary' => 'boolean'];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
