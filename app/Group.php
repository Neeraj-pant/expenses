<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
    	'name',
    	'status'
    ];

    protected $table = 'groups';

    public function getName($id){
    	$name = $this->where('id', $id)->get(['name']);
    	return $name[0]->name;
    }
}
