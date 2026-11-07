<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FashionProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
