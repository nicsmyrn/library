<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $table = 'items';

    protected $fillable = [
        'dewey_code',
        'quantity',
        'cat_id',
        'user_id',
        'favorite',
        'available',
        'edited_by',
        'published'
    ];

    protected $dates = ['deleted_at'];

    public function category(){
        return $this->hasOne('App\Models\Category','id','cat_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public  function tags(){
        return $this->belongsToMany('App\Models\Tag', 'items_tags','item_id', 'tag_id');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }

    public function organization(){
        return $this->belongsTo('App\Models\Organization');
    }



}
