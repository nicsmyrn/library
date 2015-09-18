<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editor extends Model
{
    //
    protected $table = 'editors';

    protected $fillable = [
        'e_name'
    ];

    public function books(){
        return $this->hasMany('App\Models\Book', 'books');
    }
}
