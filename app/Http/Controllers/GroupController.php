<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use App\Group;
use App\UserGroup;
use Validator;
use DB;

class GroupController extends Controller
{

	public function showGroups(){
		$users = User::where('status', 1)->get(['id','name']);
		return view('user.createGroup', compact('users'));
	}


	public function saveGroup(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' 		=>	'required|max:255',
		]);
		if($validator->fails()){
			return redirect('create-group')->withErrors($validator)->withInput();
		}
        DB::beginTransaction();
		$group = Group::create([
			'name' => $request->input('name'),
			'status' => '1',
		]);
		if($group){
			$i = 1;
			while($request->exists('group_member_'.$i)){
				$u_id = $request->input('group_member_'.$i);
				$g_id = $group->id;
				$group_up = UserGroup::create([
					'user_id' => $u_id,
					'group_id' => $g_id,
					'group_delete' => 0,
				]);
				if(!$group_up){
					DB::rollBack();
				}
				$i++;
			}
		}
		if($group_up){
			DB::commit();
			flash_alert('Group Created Successfully.', 'success');
		}else{
			flash_alert('Failed to create Group.', 'danger');
		}
		return redirect('manage-group');
	}


	public function groupList()
	{
		$groups = $this->getAllGroups();
		return view('user.manageGroup', compact('groups'));
	}


	public function getAllGroups()
	{
		$groups = Group::all()->where('status', 1)->toArray();
		
		foreach ($groups as $key => $group) 
		{
			$delete_request_user = UserGroup::where(['user_id' => Auth::user()->id, 'group_id' => $group['id']])->get(['group_delete'])->toArray();
			if($delete_request_user)
			{
				$groups[$key]['active_user_delete'] = $delete_request_user[0]['group_delete'];
			}else{
				$groups[$key]['active_user_delete'] = false;
			}
		
			
			$groups[$key]['other_user_delete'] = 0;
			$delete_request_others = UserGroup::where('user_id', '<>', Auth::user()->id)->where('group_id', $group['id'])->get(['group_delete'])->toArray();
			if($delete_request_others)
			{
				foreach ($delete_request_others as $delreq) {
					$groups[$key]['other_user_delete'] += $delreq['group_delete'];
				}
			}else{
				$groups[$key]['other_user_delete'] = false;
			}

			$groups[$key]['members'] = ''; 
			$user_ids = UserGroup::where('group_id', $group['id'])->get(['user_id'])->toArray();
			foreach ($user_ids as $u_id) {
				$user_name = User::find($u_id['user_id']);
				$groups[$key]['members'] .= $user_name['name'].', ';
			}
			$groups[$key]['members'] = rtrim($groups[$key]['members'], ', ');
		}
		return $groups;
	}

	public function deleteGroup(Request $request)
	{
		$id = (int) $request->delete_group_id;  
		$res = UserGroup::where(['group_id' => $id, 'user_id' => Auth::user()->id])->update(['group_delete' => 1]);
		if(!$res || $res == 0){
			flash_alert('Failed to proceed request (Unauthorised) .', 'danger');
		}
		$member_count = UserGroup::where('group_id', $id)->count();
		$group_count = UserGroup::where(['group_id' => $id, 'group_delete' => 1])->count();
		if($member_count == $group_count){
			$del = Group::where('id', $id)->update(['status' => 0]);
			if($del){
				flash_alert('Group Deleted Successfully.', 'success');
			}
			else{
				flash_alert('Failed to proceed request (Unauthorised) Only Group Members can Delete Group.', 'danger');
			}
		}
		return redirect('manage-group');
	}


	public function groupDetail( $id )
	{
		$group = Group::find($id);
		return view('product.group_detail', compact('group'));
	}
}

