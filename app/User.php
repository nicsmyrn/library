<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;


/**
 * App\User
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $role_id
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDeletedAt($value)
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name','username', 'email', 'password', 'role_id','org_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function can($permission = null){
        return $this->checkIfHavePermission($permission);
    }

    public function isRole($role = null){
        if ($this->role->slug == $role){
            return true;
        }
        return false;
    }

    private  function checkIfHavePermission($permission = null){

        $havePermission = $this->role->first()->permissions->where('slug', $permission);

        return !$havePermission->isEmpty();
    }

    public function role(){

        return $this->belongsTo('App\Models\Role','role_id', 'id');
    }

    public function organization(){
        return $this->belongsTo('App\Models\Organization','org_id','id');
    }

    public function items(){
        return $this->hasMany('App\Models\Item','user_id', 'id');
    }

    public function getNameAttribute(){
        return "$this->first_name $this->last_name";
    }

    public function setHashAttribute()
    {
        $this->hash = md5($this->id);
    }

    public function notices(){
        return $this->hasMany('App\Notice');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function scopeAdminNotifications()
    {
        if ($this->isRole('admin')){
            $query = DB::table('notifications')
                ->join('users', 'users.id', '=', 'notifications.user_id')
                ->where('users.org_id', $this->org_id)
                ->select([
                    'notifications.text',
                    'notifications.url',
                    'notifications.unread',
                    'notifications.created_on',
                    'notifications.barcode'
                ])
                ->get();
            return $query;
        }
        return false;
    }

    public function myAdministratorHash()
    {
       $query =  DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.slug', 'admin')
            ->where('users.org_id', $this->org_id)
            ->select(['users.hash'])
            ->first();

        return $query->hash;
    }

}
