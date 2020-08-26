<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |此控制器处理应用程序和
    |将它们重定向到主屏幕。控制器使用特征
    |为您的应用程序方便地提供其功能。
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/xxx';

    public function username()
    {
        return 'username';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //验证这是写在guest这个中间件里面么？？？CNM，这里except是指 方法名
        $this->middleware('guest')->except('logout');
    }

    //自定义属性

    //可以自定义一个redirectTo来覆盖自带的跳转
    public function redirectTo()
    {
        //echo '这里';exit;
        //这是登录成功之后的跳转
        return '/admin/login';
    }
}
