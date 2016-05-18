<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    protected $fillable = [
    	'u_id',
    	'delete_key'
    ];

    protected $table = 'user_datas';
}
