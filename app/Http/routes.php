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

Route::group(['middleware' => 'auth'], function(){
	
	Route::group(['middleware' => 'role'], function(){
	
		Route::get('add-user', function(){
			return view('user/addUser');
		});
	
		Route::post('save-user', 'UserController@saveUser');

		Route::get('get-user-data/{id}', 'AjaxController@getUserData');

		Route::post('update-user', 'UserController@updateUserDetail');

		Route::post('delete-user', 'UserController@deleteUser');

		Route::get('create-group', function(){
			return view('user/createGroup');
		});

	});

	Route::get('user-list', 'UserController@userList');

});