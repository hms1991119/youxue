<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    protected $user;
    protected $uid;
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    function __construct(Request $request){
        $request_uri=$_SERVER['REQUEST_URI'];
        if(strpos($request_uri,'login') || strpos($request_uri,'logout')){
            return;
        }
        $this->middleware(function($request,$next){
            if(!Auth::check()){
                if($request->ajax()){
                    //返回错误json
                    $return_data=create_return_arr(\ErrorParams::ERRNO_LOGIN_INVALID,\ErrorParams::ERRMSG_LOGIN_INVALID);
                    return response()->json($return_data);
                }
                return redirect()->route('admin_login');
            }
            $this->user=Auth::user();
            $this->uid=Auth::id();
            return $next($request);
        });
    }
    
}
