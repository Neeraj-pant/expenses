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


    /**
     * Gets all product or user group entries
     * @return mix product entries to view
     */
	public function allProducts()
	{
		$groups = app('App\Http\Controllers\groupController')->getAllGroups();
        foreach ($groups as $key => $group) {
            $name = explode(' ', $group['name']);
            $icon = '';
            $i = 0;
            $groups[$key]['class'] = '';
            foreach ($name as $first) {
                $icon .= $first[0];
                $i++;
                if($i>=2){
                    $groups[$key]['class'] = 'double';
                    break;
                }
            }
            $groups[$key]['icon'] = $icon;
        }
		return view('product.add', compact('groups'));
	}



    /**
     * Save product entry
     * @param Request $request
     */
    public function saveProduct(Request $request)
    {
        $validator = $this->validateFields($request);
        if($validator->fails()){
            return redirect('product/home')->withErrors($validator)->withInput();
        }

        $prd = $this->saveProductDate($request);

        if($prd){
            flash_alert('Product Added successfully', 'info');
        }
        else{
            flash_alert('Failed to Save product', 'danger');
        }
        if( ! empty($request->input('product_url')) ){
        	return redirect('product/list/'.$request->input('product_url'));
        }
        return redirect('product/home');
    }



    /**
     * Save product in ajax request
     * @param Request $request
     * @return integer 1 if success
     */
    public function saveProductAjax(Request $request)
    {
        $validator = $this->validateFields($request);
        if($validator->fails()){
            return $validator->errors()->toArray();
        }

        $res = $this->saveProductDate($request);

        return 1;
    }




    /**
     * Savve product
     * @param object $request
     * @return mix|array
     */
    private function saveProductDate($request)
    {
        $date = date('Y-m-d', strtotime($request->input('date')));
        $prd = Product::create([
            'user_id'   =>  Auth::user()->id,
            'group_id'  =>  $request->input('product_group_id'),
            'name'      =>  $request->input('name'),
            'price'     =>  $request->input('price'),
            'date'      =>  $date,
        ]);
        return $prd;
    }




    /**
     * Validates product entry fields
     * @param Request $request
     */
    protected function validateFields($request){
    	return Validator::make($request->all(), [
    		'name' 		=>	'required|max:255',
    		'price'		=>	'required',
    		'date'		=>	'required|min:1'
    	]);
    }



    /**
     * Gets all product
     * @param integer $id id of group
     * @return array|mix
     */
    public function listProduct($id)
    {
        //get group user and get pass data in view for group users
        $users = DB::table('users')->join('user_groups', 'users.id', '=', 'user_groups.user_id')->where('user_groups.group_id', '=', $id)->select('users.id', 'users.name', 'user_groups.group_id')->get();

        return view('product.list', compact(['users']));
    }




    /**
     * Checks if a user is in particulatr group
     * @param integer $group_id group id
     * @return boolian if user found return true else false
     */
    public function isUserInGroup($group_id){
        $isUser = UserGroup::where(['user_id' => Auth::user()->id, 'group_id' => $group_id])->count();
        if(!empty($isUser) || $isUser >= 1){
            return true;
        }
        return false;
    }



    /**
     * delete product
     * @param integer $id product id
     */
    public function deleteProduct($id){
        $del = Product::find($id)->delete();
        if($del){
            flash_alert('Product Entry Deleted Successfully', 'success');
        }
        else{
            flash_alert("Delete failed", 'danger');
        }
        return back();
    }

}