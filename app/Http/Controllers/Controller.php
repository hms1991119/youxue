<?php

namespace App\Http\Controllers;

use App\ApiModel\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    protected $user;
    protected $uid;
    protected $input;
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function __construct(Request $request){
        //设置跨域
        header('Content-Type: text/html;charset=utf-8');
        header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
        header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
        header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段
        //如果有内容,统一解除api_token,这边api_token是vue端后台校验
        $input=$request->input();
        if(array_key_exists('api_token',$input)){
            unset($input['api_token']);
        }
        $this->input=$input;
    }

    //返回json
    protected function vue_return_json($code)
    {
        return response()->json([
            'code' => $code
        ]);
    }

    //编辑
    protected function edit_instance($instance,$input)
    {
        //编辑
        if(isset($input['id'])){
            $id=$input['id'];
            unset($input['id']);
            $res=$instance::where('id',$id)->update($input);
        }else{
            $res=$instance::create($input);
        }
        if($res){
            return 1;
        }
        return 0;
    }

    //查看
    protected function instance_info($instance)
    {
        $input=$this->input;
        if(isset($input['id'])){
            $info=$instance::find($input['id'])->toArray();
            return response()->json([
                'code' => 1,
                'info' => $info
            ]);
        }
        return response()->json([
            'code' => 0
        ]);
    }

    //删除
    protected function del_instance($instance)
    {
        $input=$this->input;
        if(!isset($input['id'])){
            return 0;
        }
        $res=$instance::where('id',$input['id'])->delete();
        if($res){
            return 1;
        }
        return 0;
    }
    
}
