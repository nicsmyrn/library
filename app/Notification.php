<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $table = 'notifications';

    protected $fillable = [
        'id',
        'user_id',
        'text',
        'url',
        'unread',
        'barcode',
        'created_on'
    ];

    public $timestamps = false;

}
