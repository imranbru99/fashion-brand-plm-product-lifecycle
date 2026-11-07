<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturingDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    public function products()
    {
        return $this->hasMany(ManufacturingProduct::class);
    }
}
