<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Product;
use App\User;
use App\UserGroup;
use Validator;
use DB;

class productController extends Controller
{

	public function allProducts()
	{
		$groups = app('App\Http\Controllers\groupController')->getAllGroups();
		return view('product.add', compact('groups'));
	}



    public function saveProduct(Request $request)
    {
        $validator = $this->validateFields($request);
        if($validator->fails()){
            return redirect('product/home')->withErrors($validator)->withInput();
        }

        $prd = saveProductDate($request);

        if($prd){
            flash_alert('Product Added successfully', 'info');
        }
        else{
            flash_alert('Failed to Save product', 'danger');
        }
        return redirect('product/home');
    }


    public function saveProductAjax(Request $request)
    {
        dd($request);
    }


    private function saveProductDate($request)
    {
        $date = str_replace('/', '-', $request->input('date'));
        $prd = Product::create([
            'user_id'   =>  Auth::user()->id,
            'group_id'  =>  $request->input('product_group_id'),
            'name'      =>  $request->input('name'),
            'price'     =>  $request->input('price'),
            'date'      =>  date('Y-m-d', strtotime($date))
        ]);
    }


    protected function validateFields($request){
    	return Validator::make($request->all(), [
    		'name' 		=>	'required|max:255',
    		'price'		=>	'required',
    		'date'		=>	'required|min:1'
    	]);
    }


    public function listProduct($id)
    {
        //get group user and get pass data in view for group users
        $users = DB::table('users')->join('user_groups', 'users.id', '=', 'user_groups.user_id')->where('user_groups.group_id', '=', $id)->select('users.id', 'users.name', 'user_groups.group_id')->get();

        return view('product.list', compact(['users']));
    }

    public function isUserInGroup($group_id){
        $isUser = UserGroup::where(['user_id' => Auth::user()->id, 'group_id' => $group_id])->count();
        if(!empty($isUser) || $isUser >= 1){
            return true;
        }
        return false;
    }

}