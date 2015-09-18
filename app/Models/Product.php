<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Product extends Model
{
    //
    protected $table = 'products';

    protected $fillable = [
        'barcode',
        'title'
    ];


    public function is(){
        return $this->morphTo();
    }

    public function organizations(){
        return $this->belongsToMany('App\Models\Organization','items','product_id', 'organization_id')
            ->withPivot('id','dewey_code','quantity', 'cat_id', 'user_id', 'favorite','published', 'available')
//            ->wherePivot('published',1)
            ->wherePivot('deleted_at',null)
            ->withTimestamps();
    }

    public function scopePublish()
    {
        Item::findOrFail($this->organizations->first()->pivot->id)->update(['published'=>1]);
    }

    public function getCountOrganizationsAttribute()
    {
        $product =  Product::where('barcode', $this->barcode)
            ->firstOrFail();
        return $product->organizations->count();
    }

    public function delete()
    {
        $this->is()->delete();
        $this->photos()->delete(); // δεν είμαι σίγουρος αν διαγράφει ΟΛΕΣ τις φωτογραφίες
        parent::delete();
    }
//    public function unpublished(){
//        return $this->belongsToMany('App\Models\Organization','items','product_id', 'organization_id')
//            ->withPivot('id','dewey_code','quantity', 'cat_id', 'user_id', 'favorite', 'available')
////            ->wherePivot('published',0)
//            ->wherePivot('user_id', \Auth::id())
//            ->wherePivot('deleted_at',null)
//            ->withTimestamps();
//    }

//    public static function unpublished($barcode)
//    {
//        $org = \Auth::user()->organization->products->where('barcode',$barcode);
//        if ( $org->first()->pivot->published == 0) {
//            return true;
//        }
//        return false;
//    }

    public function orgcreate(){
        return $this->belongsToMany('App\Models\Organization','items','product_id', 'organization_id')
            ->withPivot('id','dewey_code','quantity', 'cat_id', 'user_id', 'favorite', 'available')
            ->wherePivot('deleted_at',null)
            ->withTimestamps();
    }

    public function photos(){
        return $this->morphOne('App\Models\Photo','imageable');
    }

    public function getPhotocoverAttribute(){
        $cover = $this->photos()->where('type', 'cover')->first();
        return $cover->thumbnail_path;
    }

    public function addPhoto(Photo $photo){
        return $this->photos()->save($photo);
    }
}
