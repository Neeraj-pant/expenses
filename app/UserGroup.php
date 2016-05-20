<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $fillabel = [
    	'user_id',
    	'group_id',
    	'group_delete'
    ];

    protected $table = 'user_groups';
}
