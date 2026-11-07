<?php

namespace App\Modules\Materials\Models;

use App\Core\Tenancy\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialCategory extends Model
{
    use HasFactory;
    use HasTenant;

    protected $table = 'material_categories';

    protected $fillable = ['tenant_id', 'name', 'parent_id', 'description'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MaterialCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MaterialCategory::class, 'parent_id');
    }
}
