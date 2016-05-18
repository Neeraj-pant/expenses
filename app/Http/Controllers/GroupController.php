<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use App\Group;
use App\UserData;
use Validator;
use DB;

class GroupController extends Controller
{

	public function showGroups(){
		$users = User::where('status', 1)->get(['id','name']);
		return view('user.createGroup', compact('users'));
	}


	public function saveGroup(Request $request){
		$validator = Validator::make($request->all(), [
    		'name' 		=>	'required|max:255',
    	]);
    	if($validator->fails()){
    		return redirect('create-group')->withErrors($validator)->withInput();
    	}

    	$i = 1;
    	$g_id = Group::orderBy('id', 'desc')->get(['group_id'])->first();
    	$g_id = $g_id->group_id + 1;
		while($request->exists('group_member_'.$i)){
			$id = $request->input('group_member_'.$i);
			$group = Group::create([
				'group_id' => $g_id,
				'name' => $request->input('name'),
				'user_id' => $id,
				'status' => '1',
			]);
			$i++;
		}

		if($group){
			flash_alert('Group Created Successfully.', 'success');
		}else{
			flash_alert('Failed to create Group.', 'danger');
		}
		return redirect('manage-group');
	}


    public function groupList(){    	
    	$groups = Group::all()->where('status', 1)->groupBy('group_id');
    	$data = array();
    	$i = 0;
    	foreach ($groups as $group) {
    		if(!isset($data[$i]['user_name'])){
    			$data[$i]['user_name'] = '';
    		}
    		foreach ($group as $items) {
				$data[$i]['group_id'] = $items->group_id;
				$data[$i]['name'] = $items->name;
				$user = User::find($items->user_id);
				$data[$i]['user_name'] .= ', '.$user->name;
    		}
    		$data[$i]['user_name'] = ltrim($data[$i]['user_name'], ', ');
    		$i++;
    	}
    	return view('user.manageGroup', compact('data'));
    }


    public function deleteGroup(Request $request){
    	$key = sha1(mt_rand(10000,99999).time());
    	$res = Group::find(Auth::user()->id)->update(['delete_request_id' => $key]);
    	if($res){
    		flash_alert('Group Disabble Request Processed.', 'info');
    	}
    	else{
    		flash_alert('Failed to proceed request.', 'danger');
    	}
    	return redirect('manage-group');
    }
}
