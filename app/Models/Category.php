<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'category';

    protected $fillable = [
        'cat_id',
        'name',
        'parent_id',
        'level',
        'dewey',
        'type'
    ];

    public function type(){
        return $this->hasOne('App\Models\Type');
    }

    public function items(){
        return $this->hasMany('App\Models\Item','items');
    }

    public function getNameCatAttribute(){
        return "$this->cat_id - $this->name";
    }
}
