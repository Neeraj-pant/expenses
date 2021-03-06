<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class AjaxController extends Controller
{



    /**
     * Gets user data to displat in midal
     * @param integer $id
     * @return mix $detail user data
     */
	public function getUserData($id)
	{
		$user = User::find($id);
		$detail = array('id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'status' => $user->status, 'role' => $user->role);
		return $detail;
	}



    /**
     * Gets all active users
     * @return mix $user user list
     */
	public function getUsers()
	{
		$user = User::where('status', '1')->get();
		return $user;
	}



    /**
     * Gets group from specific data
     * @param Request $request
     * @return mix $product
     */
    public function filterGroup(Request $request)
    {
        $start_date = date('Y-m-d', strtotime($request->input('start_date')));
        $end_date = date('Y-m-d', strtotime($request->input('end_date')));
		$id = $request->input('id');
		$products = app('App\Http\Controllers\GroupController')->groupDetail($id, $start_date, $end_date);
		return $products;
	}

}
