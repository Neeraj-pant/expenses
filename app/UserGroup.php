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

    public function isInGroup($id, $g_id){
        $in_group = $this->where('group_id', $g_id)->where('user_id', $id)->get()->toArray();
        return $in_group;
    }
}
