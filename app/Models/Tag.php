<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = 'tags';

    protected $fillable = [
        'tag_name'
    ];

    public function items(){
        return $this->belongsToMany('App\Models\Item');
    }
}
