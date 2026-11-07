<?php

namespace App\Modules\Products\Models;

use App\Core\Tenancy\HasTenant;
use App\Support\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory;
    use HasTenant;
    use HasUlid;
    use SoftDeletes;

    protected $table = 'collections';

    protected $fillable = [
        'tenant_id', 'name', 'slug', 'season', 'year', 'status', 'description', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
        ];
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'collection_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function getSeasonLabelAttribute(): string
    {
        return match ($this->season) {
            'SS' => 'Spring/Summer',
            'AW' => 'Autumn/Winter',
            'Resort' => 'Resort',
            'Pre' => 'Pre-Season',
            default => $this->season,
        };
    }
}
