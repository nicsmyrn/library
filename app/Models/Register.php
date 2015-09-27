<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    //
    protected $table = 'toregister';

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'role_id',
        'org_id',
        'hash'
    ];

}