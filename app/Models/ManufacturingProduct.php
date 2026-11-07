<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturingProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'quantity',
        'price',
        'status',
        'created_at',
        'updated_at',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
