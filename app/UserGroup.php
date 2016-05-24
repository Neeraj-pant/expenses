<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $fillable = [
    	'user_id',
    	'group_id',
    	'group_delete'
    ];

    protected $table = 'user_groups';

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
