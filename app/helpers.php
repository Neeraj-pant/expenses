<?php

define("BACKGROUND_PATH", 'images/background/');

function flash_alert($msg, $class){
	session()->flash('message', $msg);
	session()->flash('class', $class);
}

function userStatus($key = null){
	$status = array(
		'0'	=>	'Inactive',
		'1' =>	'Active'
	);
	if($key !== null){
		return $status[$key];
	}
	return $status;
}

function userRole($key = null){
	$role = array(
		'1' =>	'Admin',
		'2'	=>	'User'
	);
	if($key !== null){
		return $role[$key];
	}
	return $role;
}