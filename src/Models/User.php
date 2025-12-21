<?php

namespace Mvcomp\Posapp\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'image'
    ];

    protected $hidden = [
        'password'
    ];
}
