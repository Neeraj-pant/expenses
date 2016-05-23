<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

class productController extends Controller
{

	public function allProducts()
	{

		$groups = app('App\Http\Controllers\groupController')->getAllGroups();
		return view('product.add', compact('groups'));
	}



    public function saveProduct(Request $request){
    	$validator = $this->validateFields($request);
    	if($validator->fails()){
    		return redirect('product/home')->withErrors($validator)->withInput();
    	}

    	$prd = Product::create([
    		'user_id'	=>	Auth::user()->id,
    		'product_group_id'	=>	$request->input('group'),
    		'name'		=>	$request->input('name'),
    		'price'		=>	$request->input('price'),
    		'date'		=>	$request->input('date')
    	]);

    }


    protected function validateFields($request){
    	return Validator::make($request->all(), [
    		'name' 		=>	'required|max:255',
    		'price'		=>	'required',
    		'date'		=>	'required|min:1'
    	]);
    }

}
