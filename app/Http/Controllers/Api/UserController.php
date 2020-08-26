<?php
/**
 * 微信登录接口继承controller
 * 其他api接口继承ApiController校验access_token
 */
namespace App\Http\Controllers\Api;

use App\ApiModel\User;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Cache;

class UserController extends ApiController
{
    /**
     * 登录/刷新access_token
     * @return \Illuminate\Http\JsonResponse
     */
    public function wxlogin()
    {
        $input=$this->input;
        if(!isset($input['code'])){
            return $this->wx_return_json(0,'登录凭证不存在');
        }
        $res=\WxApp::getWxInfo($input['code']);
        if(!is_array($res)){
            return $this->wx_return_json(0,'获取openid失败');
        }
        $aes=new \AESCrypt($res['session_key']);
        $need_crypt_str=$res['session_key'].'||||||'.$res['openid'];
        $access_token=$aes->encrypt($need_crypt_str);
        //查询用户表中是否有数据，没有就插入
        $user_info=User::where('openid',$res['openid'])->first();
        if(empty($user_info)){
            $user_info=User::create(['openid'=>$res['openid'],'nickname'=>'']);
            if(!$user_info){
                return $this->wx_return_json(0,'用户数据插入失败');
            }
        }
        if(empty($user_info->id)){
            return $this->wx_return_json(0,'access_token生成失败');
        }
        //不设置有效时长，小程序端每次请求checkSession，过期就重新获取
        //缓存有效期30分钟，如果更新了就覆盖掉
        $res=Cache::put($access_token,true,30*3600);
        return response()->json([
            'code' => 1,
            'msg' => 'access_token获取成功',
            'access_token' => $access_token,
        ]);
    }

    //授权
    public function authUserInfo()
    {
        $session_key=$this->session_key;
        $input=$this->input;
        /*$input=[
            'encryptedData'=>'RQ5+oo1dANLGLuVl9SHAo5rZdlBqVgGmMwClhhpx3S6mWPmk/mFkX3OyPtX2ko5yeVM00lMI+cjDBP9S7cT5ar2i/2canKjH6iGIFjNNwX6cSUca8MPuDIdHFoc7Mio2dMXnnUb2n5SJND8CDG/AkGoy3l8qZbP7G+Ix3bYw14CquEuy5XXE8+qcTUfijHb4wI7xhN6Jvmm8aVnJhUEqzRjO62n+TmfRhz5uwenerJ6ief0RYuzsMH2/VVqDS3wit0sllEy0TGNjiWapo4PHQVOVhsF9JFP7CDiz8DgU+VvPmr07W07uhX0cD4fqeTTUnFuNYUkovk06gZNTcfzSvJnZCn0MqDvI2r1wu5tUf4gB9+9xnA/8CqNfneiDxvWz08mIE/lEdzzSUb5bYomN5ptEyOojDnyBCiQ0TtfnYktUYTk0E4dUdXcWiR93pAwN+OtrHj//u6lil0NfMnXSxeRb6b2smo2mKezfh1lVyGNcH/kbcmq2YRsEqMa3Re+s',
            'iv'=>'',
            'rawData'=>'{"nickName":"云信 微盛小程序 企微服务商","gender":0,"language":"zh_CN","city":"","province":"","country":"","avatarUrl":"https://thirdwx.qlogo.cn/mmopen/vi_32/aA4ZbHAhbRaichc8sibythu4NIKk4zhAA9hsIKiag51CXlzicf1VXtAOGAhTIzmgLgbXWfeic8LBI16m77L3GdhosgQ/132"}',
            'signature'=>'6d3b57fe3a1447309dfebe233ee5c21166eb639a'
        ];*/
        $auth_info=\WxApp::checkUserInfo($session_key,$input['rawData'],$input['signature'],$input['iv'],$input['encryptedData']);
        if($auth_info==-1){
            return $this->wx_return_json(0,'用户授权失败');
        }
        //写入数据库
        $user=$this->user;
        if(empty($user->nickname)){
            $user->nickname=$auth_info['nickname'];
            $user->gender=$auth_info['gender'];
            $user->city=$auth_info['city'];
            $user->province=$auth_info['province'];
            $user->avatarUrl=$auth_info['avatarUrl'];
            $res=$user->save();
        }
        //返回最新的用户信息
        return response()->json([
            'code' => 1,
            'msg' => '用户获取授权成功',
            'info' => $user->toArray()
        ]);
    }

}
