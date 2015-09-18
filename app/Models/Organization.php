<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Organization extends Model
{
    //

    protected $table = 'organizations';

    protected $fillable = [
        'name'
    ];

    public function users(){
        return $this->hasMany('App\Models\User');
    }

//    public function products(){
//        return $this->belongsToMany('App\Models\Product','items','organization_id', 'product_id')
//            ->withPivot('id','dewey_code','quantity', 'cat_id', 'user_id', 'favorite', 'available')
//            ->wherePivot('published',1)
//            ->wherePivot('deleted_at',null)
//            ->withTimestamps();
//    }

    public function products(){
        return $this->belongsToMany('App\Models\Product','items','organization_id', 'product_id')
            ->withPivot('id','dewey_code','quantity', 'cat_id', 'user_id', 'favorite', 'available', 'published')
            ->withTimestamps();
    }

    public function scopeUnpublished()
    {
        $this->products;//->where('pivot.published',0)->where('pivot.user_id', Auth::id()
    }


//    public function allUnpublished()
//    {
//        return $this->belongsToMany('App\Models\Product','items','organization_id', 'product_id')
//            ->withPivot('id','dewey_code','quantity', 'cat_id', 'user_id', 'favorite', 'available')
//            ->wherePivot('published',0)
//            ->wherePivot('deleted_at',null)
//            ->withTimestamps();
//    }

    public function roles(){
        return $this->belongsToMany('App\Models\Role', 'users','org_id','role_id')
            ->withPivot('username', 'email', 'password')
            ->withTimestamps();
    }
}
