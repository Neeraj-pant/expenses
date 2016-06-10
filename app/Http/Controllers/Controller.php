<?php

namespace App\Http\Controllers;

use App\Dummy;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function test(){
	    $carbon = new Carbon();                  // equivalent to Carbon::now()
		$carbon = new Carbon('first day of January 2008', 'America/Vancouver');
		echo get_class($carbon);                 // 'Carbon\Carbon'
		$carbon = Carbon::now(-5);
		echo $carbon;
    }

}
