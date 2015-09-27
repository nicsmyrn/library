<?php

namespace App\Repositories\Admin;


use App\Models\Register;
use App\User;
use DB;
class UsersRepository{

    public function getUsersOfOrganization(User $admin, $status )
    {
        $users = DB::table('users')
            ->where('org_id', $admin->org_id)
            ->where('role_id', '<>', $admin->role_id)
            ->where(function($query) use ($status){
                if ($status) $query->where('status', $status);
            })
            ->join('roles','role_id', '=', 'roles.id')
            ->select(['first_name', 'last_name', 'username', 'email', 'role_id', 'org_id', 'created_at', 'hash', 'status', 'roles.name as role_name']);
        $allUsers = DB::table('toregister')
            ->select(['first_name', 'last_name', 'username', 'email', 'role_id', 'org_id', 'created_at', 'hash', 'status', 'roles.name as role_name'])
            ->where(function($query) use ($status){
                if ($status) $query->where('status', $status);
            })
            ->union($users)
            ->join('roles','role_id', '=', 'roles.id')
            ->get();
        return $allUsers;
    }
}