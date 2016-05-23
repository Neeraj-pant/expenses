<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::post('save-user', 'UserController@saveUser');

Route::get('add-user', function(){
	return view('user/addUser');
});

Route::group(['middleware' => 'auth'], function(){
	
	Route::group(['middleware' => 'role'], function(){

		Route::get('get-user-data/{id}', 'AjaxController@getUserData');

		Route::get('get-users', 'AjaxController@getUsers');

		Route::post('update-user', 'UserController@updateUserDetail');

		Route::post('delete-user', 'UserController@deleteUser');

		Route::get('create-group', 'GroupController@showGroups');

		Route::post('save-group', 'GroupController@saveGroup');

	});

	Route::get('user-list', 'UserController@userList');

	Route::post('delete-group', 'GroupController@deleteGroup');

	Route::get('manage-group', 'GroupController@groupList');

	Route::get('product/home', 'ProductController@allProducts');

	Route::get('product/list/{id}', 'ProductController@listProduct');
	
	Route::post('product/save', 'ProductController@saveProduct');

	// Route::group(['as' => 'product::'], function () {
	//     Route::get('product/add', ['as' => 'add', 'ProductController@addProduct']);
	//      Route::post('product/save', ['as' => 'save', 'ProductController@saveProduct']);
	// });

});
