<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'npwp',
        'email',
        'phone',
        'address',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    protected $attributes = [
        'rating' => 0,
    ];
}
