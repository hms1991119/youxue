<?php

use App\Http\Middleware\checkAge;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//请求方式：GET POST PUT DELETE PATH OPTION

//返回view()是直接返回视图页面，不需要经过控制器
Route::get('/', function () {
    return view('welcome');
});

//回调函数
Route::get('home',function(){
    echo 'home主页';
});

//一个路由对应多个请求,第一个参数：请求方式数组    第二个参数：/路由    第三个参数：回调
Route::match(['post','get'],'/match',function(){
    //
});

//一个路由对应任意请求
Route::any('/any',function(){      //这里回调也可以是controller@method
    //
});

//路由参数，必填参数
Route::get('/param/{id}',function($id){
    echo '当前用户id为：'.$id;
});
//路由参数，可选参数
Route::get('/params/{id?}',function($id=''){
    echo '可选参数id：'.$id;
});
//问号传参,不考虑
Route::get('/wenhao',function(){
    echo '可选参数id：'.$_GET['id'];
});

//路由别名
Route::get('/alias/a/b/c','TestControler@alias')->name('alias');

//路由群组，相同的类里面的方法可以使用一个共同的前缀prefix
Route::group(['prefix'=>'admin'],function(){
    Route::get('/a',function(){ echo 'a'; });
    Route::get('/b',function(){ echo 'b'; });
});




//路由 auth 权限，登录
//Route::get('/test','TestController@index')->middleware(checkAge::class);
Route::get('/test','TestController@index');

//单方法控制器
Route::get('/invoke','InvokeController');

/**
 * --------------------------------分割线-------------------------------------------
 */
/*
 * 后台
 */

Route::group(['prefix'=>'/admin'],function(){
    //模板
    Route::match(['get','post'],'/login','Admin\LoginController@login')->name('admin_login'); 
    Route::get('/index','Admin\IndexController@index')->name('admin_index');
    Route::get('/main',function(){
        return view('admin.index.main');
    });
    Route::get('/logout','Admin\LoginController@quit')->name('admin_logout');
    //头像上传
    Route::post('/upload_headimg','Admin\IndexController@upload_headimg')->name('admin_upload_headimg');
    //修改密码
    Route::post('/save_password','Admin\IndexController@save_password')->name('admin_save_password');
    
    /*
     * 系统设置
     */
    //用户管理
    Route::match(['get','post'],'/userlist','Admin\UserController@list');
    Route::match(['get','post'],'/user_add','Admin\UserController@edit');
    Route::post('/change_user_status','Admin\UserController@change_status');
    Route::post('/user_del','Admin\UserController@del');
    
    //角色管理
    Route::match(['get','post'],'/rolelist','Admin\RoleController@list');
    Route::match(['get','post'],'/role_add','Admin\RoleController@edit');
    Route::post('/role_del','Admin\roleController@del');
    
    //菜单管理
    Route::match(['get','post'],'/menulist','Admin\MenuController@list');
    
    //banner列表
    Route::match(['get','post'],'/bannerlist','Admin\BannerController@list');
    Route::match(['get','post'],'/banner_add','Admin\BannerController@edit');
});





//Auth::routes();
//var_dump(Auth::routes());

//Route::get('/home', 'HomeController@index')->name('home');
