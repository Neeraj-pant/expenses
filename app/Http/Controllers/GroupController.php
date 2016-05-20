<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use App\Group;
use App\UserData;
use App\GroupDelete;
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
		if($g_id){
			$g_id = $g_id->group_id + 1;
		}
		else{
			$g_id = 1;
		}
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
			$data[$i]['delete_id'] = '';
			$data[$i]['delete_request'] = 0;
			foreach ($group as $items) {
				$is_del = GroupDelete::where(['user_id' => Auth::user()->id, 'group_id' =>  $items->group_id])->count();
				$is_requ = GroupDelete::where('group_id',  $items->group_id)->count();
				if($is_del > 0){
					$data[$i]['delete_id'] = 1;
				}
				if($is_requ){
					$data[$i]['delete_request'] = $is_req;
				}
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
		$id = (int) $request->delete_group_id;
		$res = GroupDelete::create([
			'group_id' => $id,
			'user_id' => Auth::user()->id
		]);
		$delete_count = GroupDelete::where('group_id', $id)->count();
		$group_count = Group::where('group_id', $id)->count();
		if($delete_count == $group_count){
			$del = Group::where('group_id', $id)->update(['status' => 0]);
			if($res){
				flash_alert('Group Deleted Successfully.', 'success');
				return redirect('manage-group');
			}
		}
		if($res){
			flash_alert('Group Disabble Request Processed.', 'info');
		}
		else{
			flash_alert('Failed to proceed request (Unauthorised) .', 'danger');
		}
		return redirect('manage-group');
	}
}

