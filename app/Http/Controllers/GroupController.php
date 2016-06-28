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



    /**
     * Return User list to create group page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showGroups()
    {
        $users = User::where('status', 1)->get(['id', 'name']);
        return view('user.createGroup', compact('users'));
    }



    /**
     * Saves group detail to user_group table and Group table
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails())
        {
            return redirect('create-group')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        $group = Group::create([
            'name' => trim($request->input('name')),
            'status' => '1',
        ]);

        if ($group)
        {
            $i = 1;
            while ($request->exists('group_member_' . $i))
            {
                $u_id = $request->input('group_member_' . $i);
                $g_id = $group->id;
                $group_up = UserGroup::create([
                    'user_id' => $u_id,
                    'group_id' => $g_id,
                    'group_delete' => 0,
                ]);

                if (!$group_up)
                {
                    DB::rollBack();
                }
                $i++;
            }
        }

        if ($group_up)
        {
            DB::commit();
            flash_alert('Group Created Successfully.', 'success');
        }
        else
        {
            flash_alert('Failed to create Group.', 'danger');
        }
        return redirect('manage-group');
    }



    /**
     * Return Group Data to views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groupList()
    {
        $groups = $this->getAllGroups();
        return view('user.manageGroup', compact('groups'));
    }



    /**
     * Gets all Active Group ans checks for Delete Request for the group
     * @return array
     */
    public function getAllGroups()
    {
        $groups = Group::all()->where('status', 1)->toArray();

        foreach ($groups as $key => $group)
        {
            $delete_request_user = UserGroup::where([
                'user_id' => Auth::user()->id,
                'group_id' => $group['id']
            ])->get(['group_delete'])->toArray();

            if ($delete_request_user)
            {
                $groups[$key]['active_user_delete'] = $delete_request_user[0]['group_delete'];
            }
            else
            {
                $groups[$key]['active_user_delete'] = false;
            }


            $groups[$key]['other_user_delete'] = 0;
            $delete_request_others = UserGroup::where('user_id', '<>', Auth::user()->id)->where('group_id',
                $group['id'])->get(['group_delete'])->toArray();

            if ($delete_request_others)
            {
                foreach ($delete_request_others as $delreq)
                {
                    $groups[$key]['other_user_delete'] += $delreq['group_delete'];
                }
            }
            else
            {
                $groups[$key]['other_user_delete'] = false;
            }

            $groups[$key]['members'] = '';
            $user_ids = UserGroup::where('group_id', $group['id'])->get(['user_id'])->toArray();

            foreach ($user_ids as $u_id)
            {
                $user_name = User::find($u_id['user_id']);
                $groups[$key]['members'] .= $user_name['name'] . ', ';
            }
            $groups[$key]['members'] = rtrim($groups[$key]['members'], ', ');
        }
        return $groups;
    }



    /**
     * Deletes or Set Delete request for Group
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteGroup(Request $request)
    {
        $id = (int)$request->delete_group_id;
        $res = UserGroup::where(['group_id' => $id, 'user_id' => Auth::user()->id])->update(['group_delete' => 1]);

        if (!$res || $res == 0)
        {
            flash_alert('Failed to proceed request (Unauthorised) .', 'danger');
        }

        $member_count = UserGroup::where('group_id', $id)->count();
        $group_count = UserGroup::where(['group_id' => $id, 'group_delete' => 1])->count();

        if ($member_count == $group_count)
        {
            $del = Group::where('id', $id)->update(['status' => 0]);
            if ($del)
            {
                flash_alert('Group Deleted Successfully.', 'success');
            }
            else
            {
                flash_alert('Failed to proceed request (Unauthorised) Only Group Members can Delete Group.', 'danger');
            }
        }
        return redirect('manage-group');
    }



    /**
     * Return Detail group transaction detail and user transaction detail to views
     * @param $id
     * @param null $start_date
     * @param null $end_date
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groupDetail($id, $start_date = null, $end_date = null)
    {
        if($start_date == null || $start_date < '2000-01-01')
        {
            $start_date = '';
        }
        if($end_date == null)
        {
            $end_date = date('Y-m-d');
        }

        $products = $this->groupDetailByMonths( $id, $start_date, $end_date );
        //dd($products);
        $users_detail = $this->groupDetailByUsers( $id, $start_date, $end_date );

        return view('product.group_detail', compact(['products', 'users_detail', 'id']));
    }



    /**
     * Gets Transaction detail of Group
     * @param $id integer group id
     * @param $start_date
     * @param $end_date
     * @return mixed
     */
    private function groupDetailByMonths( $id, $start_date, $end_date )
    {
        //DB::enableQueryLog();
        $members = UserGroup::where('group_id', $id)->count();

        $products = DB::table( 'products' )
                ->where('group_id', $id)
                ->whereBetween('date', array($start_date, $end_date))
                ->select( DB::raw('sum(price) as total'),
                DB::raw('count(*) as entries'),
                'date')
                ->groupBy(DB::raw('month(date)'))
                ->get();
        //dd(DB::getQueryLog());
        foreach($products as $key => $product)
        {
            $product->month_avg = $product->total / $members;
        }

        return $products;
    }



    /**
     * Gets Transaction detail of users in specific Group
     * @param $id integer group id
     * @param $start_date
     * @param $end_date
     * @return mixed
     */
    public function groupDetailByUsers( $id, $start_date, $end_date )
    {
        $members = UserGroup::where('group_id', $id)->get(['user_id'])->toArray();
        $m_count = DB::table('products')->distinct()->select(DB::raw('month(date) as month'))->where('date', '<=', $end_date)->where('group_id', $id)->orderBy('date')->get();
        $user_detail = array();

        foreach($members as $key => $member)
        {
            foreach($m_count as $s_key => $month)
            {
                $user_detail[$key][$s_key] = DB::table('products')
                    ->where('group_id', $id)
                    ->where('user_id', $member['user_id'])
                    ->where(DB::raw('month(date)'), $month->month)
                    ->select(DB::raw('sum(price) as total'),
                        DB::raw('count(*) as entries'),
                        'date', 'user_id')
                    ->orderBy('date')
                    ->get();

                if($user_detail[$key][$s_key][0]->total == '')
                {
                    $user_detail[$key][$s_key][0]->total = 0;
                }
                if($user_detail[$key][$s_key][0]->date == '')
                {
                    $user_detail[$key][$s_key][0]->date = date('Y-' . $month->month . '-d');
                }
                if($user_detail[$key][$s_key][0]->user_id == '' || $user_detail[$key][$s_key][0]->user_id == null)
                {
                    $user_detail[$key][$s_key][0]->user_id = $member['user_id'];
                }
            }
        }

        /*$user_detail= DB::table( 'products' )
            ->where('group_id', $id)
            ->whereBetween('date', array($start_date, $end_date))
            ->select( DB::raw('sum(price) as total'),
                DB::raw('count(*) as entries'),
                'date', 'user_id')
            ->groupBy('user_id')
            ->groupBy(DB::raw('month(date)'))
            ->orderBy('user_id')
            ->get();*/

        foreach($user_detail as $key => $detail)
        {
            foreach($detail as $s_key => $month_detail) {
                $month = date('m', strtotime($month_detail[0]->date));
                $month_detail[0]->month_total = Product::where(DB::raw('month(date)'), $month)->where('group_id',
                    $id)->sum('price');
                $month_detail[0]->month_avg = $month_detail[0]->month_total / count($members);
                $month_detail[0]->advance = $month_detail[0]->total - $month_detail[0]->month_avg;
            }
        }
        return $user_detail;
    }

}
