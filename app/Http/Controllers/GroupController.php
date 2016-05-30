<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use App\Group;
use App\Product;
use App\UserGroup;
use Validator;
use DB;

class GroupController extends Controller
{

    public function showGroups()
    {
        $users = User::where('status', 1)->get(['id', 'name']);
        return view('user.createGroup', compact('users'));
    }


    public function saveGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect('create-group')->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        $group = Group::create([
            'name' => $request->input('name'),
            'status' => '1',
        ]);
        if ($group) {
            $i = 1;
            while ($request->exists('group_member_' . $i)) {
                $u_id = $request->input('group_member_' . $i);
                $g_id = $group->id;
                $group_up = UserGroup::create([
                    'user_id' => $u_id,
                    'group_id' => $g_id,
                    'group_delete' => 0,
                ]);
                if (!$group_up) {
                    DB::rollBack();
                }
                $i++;
            }
        }
        if ($group_up) {
            DB::commit();
            flash_alert('Group Created Successfully.', 'success');
        } else {
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

        foreach ($groups as $key => $group) {
            $delete_request_user = UserGroup::where([
                'user_id' => Auth::user()->id,
                'group_id' => $group['id']
            ])->get(['group_delete'])->toArray();
            if ($delete_request_user) {
                $groups[$key]['active_user_delete'] = $delete_request_user[0]['group_delete'];
            } else {
                $groups[$key]['active_user_delete'] = false;
            }


            $groups[$key]['other_user_delete'] = 0;
            $delete_request_others = UserGroup::where('user_id', '<>', Auth::user()->id)->where('group_id',
                $group['id'])->get(['group_delete'])->toArray();
            if ($delete_request_others) {
                foreach ($delete_request_others as $delreq) {
                    $groups[$key]['other_user_delete'] += $delreq['group_delete'];
                }
            } else {
                $groups[$key]['other_user_delete'] = false;
            }

            $groups[$key]['members'] = '';
            $user_ids = UserGroup::where('group_id', $group['id'])->get(['user_id'])->toArray();
            foreach ($user_ids as $u_id) {
                $user_name = User::find($u_id['user_id']);
                $groups[$key]['members'] .= $user_name['name'] . ', ';
            }
            $groups[$key]['members'] = rtrim($groups[$key]['members'], ', ');
        }
        return $groups;
    }

    public function deleteGroup(Request $request)
    {
        $id = (int)$request->delete_group_id;
        $res = UserGroup::where(['group_id' => $id, 'user_id' => Auth::user()->id])->update(['group_delete' => 1]);
        if (!$res || $res == 0) {
            flash_alert('Failed to proceed request (Unauthorised) .', 'danger');
        }
        $member_count = UserGroup::where('group_id', $id)->count();
        $group_count = UserGroup::where(['group_id' => $id, 'group_delete' => 1])->count();
        if ($member_count == $group_count) {
            $del = Group::where('id', $id)->update(['status' => 0]);
            if ($del) {
                flash_alert('Group Deleted Successfully.', 'success');
            } else {
                flash_alert('Failed to proceed request (Unauthorised) Only Group Members can Delete Group.', 'danger');
            }
        }
        return redirect('manage-group');
    }


    public function groupDetail($id)
    {
        $total = 0;
        $count = 0;
        $cleared = array('total' => 0, 'count' => 0);
        $pending = array('total' => 0, 'count' => 0);
        $user_data = array();

        $products = Product::where('group_id', $id)->get()->groupBy('user_id')->toArray();
        foreach ($products as $key => $pg) {
            $user_total = 0;
            $user_cleared = 0;
            $user_pending = 0;
            $user_entries = 0;
            $pending_date = 'Updated';
            foreach ($pg as $s_key => $product) {
                $total += $product['price'];
                $count++;
                if ($product['cleared'] == 0) {
                    $cleared['total'] += $product['price'];
                    $user_cleared += $product['price'];
                    $cleared['count']++;
                } else {
                    $pending['total'] += $product['price'];
                    $user_pending += $product['price'];
                    $pending['count']++;

                    if($pending_date == 'Updated'){
                        $pending_date = date('d-M-Y', strtotime($product['created_at']));
                    }
                }

                $user_total += $product['price'];
                $user_entries++;
                $user_id = $product['user_id'];

            }
            $user_data[$key]['total']           =   $user_total;
            $user_data[$key]['entries']         =   $user_entries;
            $user_data[$key]['cleared']         =   $user_cleared;
            $user_data[$key]['pending']         =   $user_pending;
            $user_data[$key]['pending_date']    =   $pending_date;
            $user_data[$key]['user_id']         =   $user_id;
        }

        $products['cleared']    =    $cleared;
        $products['pending']    =    $pending;
        $products['group_id']   =    $id;
        $products['entries']    =    $count;
        $products['total']      =    $total;
        $products['user_data']  =    $user_data;

        return view('product.group_detail', compact('products'));
    }
}

