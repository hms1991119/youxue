<?php

namespace App\Http\Controllers\Admin;

use App\AdminAccount;
use App\AdminLoginLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    //登录错误次数
    private $err_login_limit=5;
    //登录错误锁定时间
    private $err_login_delay=5*60;
    //缓存有效时长和前缀,20分钟之内连续输入错误5次
    private $err_login_cache_delay=20*60;

    //laravel默认登录名是email，这里执行本类中使用username
    public function username()
    {
        return 'username';
    }
    
    //后台登录页面,注入容器中的reuqest实例
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response|void
     * @throws \Illuminate\Validation\ValidationException
     * code  1:登录成功  0:账号或密码错误  2:连续错误5次，请1分钟后再试   3:未知错误  4:账号禁用
     */
    public function login(Request $request)
    {
        if($request->isMethod('post')){
            //判断错误登录次数,默认是5次，可以进去修改,
            //这里生成缓存的key 是用 ip|username 的方式去存储错误登录次数,只有错误登录的时候第二次才会走到这里
            if ($this->hasTooManyLoginAttempts($request)) {
                $data=[
                    'last_login_ip'=> $request->ip(),
                    'username' => $request->input('username'),
                    'remark' => '连续错误登录5次',
                ];
                AdminLoginLog::create($data);
                $this->fireLockoutEvent($request);
                return $this->vue_return_json(2);
            }
            //登录成功
            if ($this->attemptLogin($request)) {
                $session_id=$this->sendLoginResponse($request);
                $user=Auth::user();
                //禁用
                if($user->enabled!=1){
                    return $this->vue_return_json(4);
                }
                //登录成功，将session_id更新的到api_token作为token，然后每次校验时用session_id作为token进行校验
                $res=AdminAccount::where('id',$user->id)->update(['api_token'=>$session_id]);
                return response()->json([
                    'code' => 1,
                    'info' => [
                    'session_id' => $session_id,
                    'username' => $user->realname,
                    'user_id' => $user->id,
                    'role_id' => $user->role
                    ]
                ]);
            }
            //增加登录错误次数
            $this->incrementLoginAttempts($request);
            return $this->vue_return_json(0);
        }
        return $this->vue_return_json(3);
    }
}
