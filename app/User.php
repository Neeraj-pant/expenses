<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'role', 'deleted'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'users';

    /**
    * Get Role of User.
    *
    */
    public function getRole(){
        return $this->role;
    }

    /**
     * Gets Name of user by id
     */
    public function getName($id){
        $name = $this->where('id', $id)->get(['name']);
        return $name[0]->name;
    }

    public function userGroup(){
        return $this->hasOne('App\UserGroup');
    }
}
