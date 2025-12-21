<?php

namespace Mvcomp\Posapp\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'stock',
        'image'
    ];

    public $timestamps = true;

    protected $casts = [
        'price' => 'decimal:3',
        'stock' => 'boolean'
    ];
}
