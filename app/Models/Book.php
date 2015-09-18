<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $table = 'books';

    protected $fillable = [
        'isbn',
        'subtitle',
        'year',
        'e_id',
        's_id',
        'description'
    ];

    public function authors(){
        return $this->belongsToMany('App\Models\Author','authors_books','book_id', 'author_id')
            ->withPivot('translator');
    }

    public function editor(){
        return $this->hasOne('App\Models\Editor','id','e_id');
    }

    public function series(){
        return $this->hasOne('App\Models\Series');
    }

    public function product(){
        return $this->morphOne('App\Models\Product','is');
    }
}
