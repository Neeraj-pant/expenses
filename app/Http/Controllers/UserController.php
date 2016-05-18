<?php

namespace App\Http\Controllers;

use App\User;
use App\UserData;
use App\UserReference;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use DB;

class UserController extends Controller
{
    public function saveUser(Request $request){
    	$validator = $this->validateFields($request);
    	if($validator->fails()){
    		return redirect('add-user')->withErrors($validator)->withInput();
    	}
        DB::beginTransaction();
            $user = User::create([
        		'name'=> $request->input('name'),
        		'email'=> $request->input('email'),
        		'password'=> bcrypt($request->input('password')),
        		'status'=> $request->input('status'),
        		'role'=> $request->input('role'),
        	]);          
            if($user){
                $res = UserData::create([ 'u_id' => $user->id]);		
                DB::commit();
                if($res){
                    flash_alert('User Added Successfully', 'success');
                    return redirect('user-list');
                }
                else{
                    DB::rollBack();
                }
            }
        DB::commit();
    	flash_alert('Failed To Add User', 'danger');
    	return redirect('add-user');
    }



    protected function validateFields($request){
    	return Validator::make($request->all(), [
    		'name' 		=>	'required|max:255',
    		'email'		=>	'email|required',
    		'password'	=>	'required',
   			'role'		=>	'required'
    	]);
    }


    public function userList(){
        $users = User::all();
        return view('user.userList',compact('users'));
    }


    
    public function updateUserDetail(Request $request){
        $status = 0;
        if($request->exists('status')){
            $status = 1;
        }
        $res = User::where('id', $request->input('id'))
        ->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'status' => $status
        ]);
        if($res){
            flash_alert('User Details Updated Successfully.', 'success');
        }
        else{
            flash_alert('Failed to Update User Details.', 'error');
        }
        return redirect('user-list');
    }

    

    public function deleteUser(Request $request){
        $id = $request->input('delete_id');
        $del = User::where('id', $id)->delete();
        if($del){
            flash_alert('User Deleted Successfully.', 'success');
        }
        else{
            flash_alert('Failed to Delete User.', 'error');
        }
        return redirect('user-list');
    }
}

