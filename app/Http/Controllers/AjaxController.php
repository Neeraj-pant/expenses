<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

class AjaxController extends Controller
{
	public function getUserData($id){
		$user = User::find($id);
		$detail = array('id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'status' => $user->status, 'role' => $user->role);
		return $detail;
	}

}
