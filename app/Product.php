<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class Product extends Model
{
    protected $fillable = [
    	'user_id', 'group_id', 'name', 'price', 'date', 'cleared'
    ];

    protected $table = 'products';

    public function getProduct($id, $group_id)
    {
    	$all = $this->where('user_id', $id)
            ->where('group_id', $group_id)
            ->get(['id', 'user_id', 'group_id', 'name', 'price', 'date']);

    	$all->total = $all->sum('price');

        return $all;
    }

    public function wallet( $id, $members ){
        $total = $this->where('group_id', $id)->sum('price');
        $total_avg = $total / $members;
        $user_total = $this->where('group_id', $id)
            ->where('user_id', Auth::user()->id)
            ->sum('price');

        $wallet = $user_total - $total_avg;
        return $wallet;
    }



    /**
    * Get all transaction of user
    **/
    public function userTransaction(){
        return $this->select(DB::raw('sum(price) as total'), 'date' )->groupBy(DB::raw('month(date)'))->get();
    }

}
