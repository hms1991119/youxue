<?php

namespace App\Http\Controllers;

use App\ApiModel\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    protected $input;
    protected $user;
    protected $session_key;

    function __construct(Request $request)
    {
        $input=$request->input();
        //判断登录不校验access_token
        if(strpos($_SERVER['REQUEST_URI'],'api/wx/login')){
            $this->input=$input;
            return;
        }
        //判断access_token,这边access_token表示小程序端自定义登录token，与本地对比
        if(!array_key_exists('access_token',$input)){
            return response()->json([
                'code' => 0,
                'msg' => 'access_token不存在'
            ]);
        }
        //校验
        $access_token=$input['access_token'];
        //获取缓存、解密校验
        $auth_check=Cache::get($access_token);
        if(empty($auth_check)){
            return $this->wx_return_json([
                'code' => 0,
                'msg' => 'access_token不合法'
            ]);
        }
        //解密
        $aes=new \AESCrypt();
        $decrypt_access_token=$aes->decrypt($access_token);
        $session_and_openid=explode('||||||',$decrypt_access_token);
        if(empty($session_and_openid)){
            return $this->wx_return_json([
                'code' => 0,
                'msg' => 'access_token校验失败'
            ]);
        }
        $user_info=User::where('openid',$session_and_openid[1])->first();
        $this->session_key=$session_and_openid[0];
        $this->user=$user_info;
        unset($input['access_token']);
        $this->input=$input;
    }

    //返回wx_json
    protected function wx_return_json($code,$msg)
    {
        return response()->json([
            'code' => $code,
            'msg' => $msg
        ]);
    }
}
