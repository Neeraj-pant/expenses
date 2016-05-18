<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
    	'group_id',
    	'name',
    	'user_id',
    	'delete_request_id',
    	'status',
    ];

    protected $table = 'groups';
}
