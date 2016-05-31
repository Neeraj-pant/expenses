<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use DB;

class PaymentController extends Controller
{
    public function payNow($id)
    {
        $users = DB::table('users')->join('user_groups', 'users.id', '=',
            'user_groups.user_id')->where('user_groups.group_id', '=', $id)->where()->select('users.id', 'users.name',
            'user_groups.group_id')->get();
        dd($users);
        return view('product.pay');
    }
}
