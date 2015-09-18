<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    //

    protected $table = 'series';

    protected $fillable = [
        's_name'
    ];

    public function book(){
        return $this->hasMany('App\Models\Book');
    }
}
