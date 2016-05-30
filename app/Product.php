<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    protected $fillable = [
    	'user_id', 'group_id', 'name', 'price', 'date', 'cleared'
    ];

    protected $table = 'products';

    public function getProduct($id, $group_id)
    {
    	$all = $this->where('user_id', $id)->where('group_id', $group_id)->get(['id', 'user_id', 'group_id', 'name', 'price', 'date']);
    	$all->total = $all->sum('price');
    	return $all;
    }

}
