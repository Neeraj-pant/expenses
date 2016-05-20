<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupDelete extends Model
{
    protected $fillabel = [
    	'group_id',
    	'user_id'
    ];

    protected $table = 'group_deletes';
}
