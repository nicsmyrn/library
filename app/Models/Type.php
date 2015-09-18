<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    protected $table = 'type_category';

    protected $fillable = [
        't_name'
    ];

    public function categories(){
        return $this->hasMany('App\Models\Category');
    }

    public $timestamps = false;

}
