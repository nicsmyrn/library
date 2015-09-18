<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Role
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereDescription($value)
 */
class Role extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description'];

    /**
     * The table has no timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    public function permissions(){
        return $this->belongsToMany('App\Models\Permission','permissions_roles','role_id','permission_id');
    }

    public function organizations(){
        return $this->belongsToMany('App\Models\Organization', 'users','role_id','org_id')
            ->withPivot('username', 'email', 'password')
            ->withTimestamps();
    }


}
