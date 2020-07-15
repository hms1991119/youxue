<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use app\Helpers\QiniuHelper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    //登录错误次数
    private $err_login_limit=5;
    //登录错误锁定时间
    private $err_login_delay=5*60;
    //缓存有效时长和前缀,20分钟之内连续输入错误5次
    private $err_login_cache_delay=20*60;
    private $cache_prefix='login_error_count_';
    
    //登录成功后重定向地址
    protected $redirectTo = '/admin/index';
    
    //laravel默认登录名是email，这里执行本类中使用username
    public function username()
    {
        return 'username';
    }
    
    //后台登录页面,注入容器中的reuqest实例
    public function login(Request $request)
    {
        if($request->isMethod('post')){
            //验证参数
            $this->validateLogin($request);
            //判断错误登录次数,默认是5次，可以进去修改,
            //这里生成缓存的key 是用 ip|username 的方式去存储错误登录次数,只有错误登录的时候第二次才会走到这里
            if ($this->hasTooManyLoginAttempts($request)) {
                //登录错误次数过多就写入一个日志
                $data=[
                    'last_login_ip'=> $request->ip(),
                    'username' => $request->input('username'),
                    'remark' => '连续错误登录5次',
                    'addtime' => $_SERVER['REQUEST_TIME'],
                    'status' => 1
                ];
                DB::table('login_log')->insert($data);
                //????
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }
            //登录成功
            if ($this->attemptLogin($request)) {
                //记录日志
                $data=[
                    'last_login_ip'=> $request->ip(),
                    'username' => $request->input('username'),
                    'remark' => '登录成功',
                    'addtime' => $_SERVER['REQUEST_TIME'],
                    'status' => 1
                ];
                DB::table('login_log')->insert($data);
                return $this->sendLoginResponse($request);
            }
            //增加登录错误次数
            $this->incrementLoginAttempts($request);
            //登录失败
            return $this->sendFailedLoginResponse($request,\ErrorParams::ERRMSG_WRONG_USERNAME_OR_PASSWORD);
        }
        return view('admin.login.login');
    }
    
    //退出登录
    public function quit(Request $request)
    {
        $this->logout($request);
        return redirect()->route('admin_login');
    }
}
