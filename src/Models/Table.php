<?php

namespace Mvcomp\Posapp\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'tables';

    protected $fillable = [
        'name',
        'qr_token',
        'status'
    ];

    public $timestamps = true;
}
