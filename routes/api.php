<?php

use Illuminate\Http\Request;

/*
 * vue 后台接口，这个api文件中的路由会默认添加  api 到作为每个接口的前缀，无需手动添加
 */
Route::group(['prefix'=>'/vue','middleware'=>'auth:api'],function(){
    //菜单
    Route::get('/menulist','Admin\MenuController@menulist');
    /*
     * 系统设置
     */
    //用户
    Route::get('/accountlist','Admin\AccountController@accountlist');
    Route::post('/editaccount','Admin\AccountController@editaccount');
    Route::get('/accountinfo','Admin\AccountController@accountinfo');
    Route::get('/delaccount','Admin\AccountController@delaccount');
    //角色
    Route::get('/rolelist','Admin\RoleController@rolelist');
    Route::post('/editrole','Admin\RoleController@editrole');
    Route::get('/roleinfo','Admin\RoleController@roleinfo');
    Route::get('/delrole','Admin\RoleController@delrole');
});
//登录
Route::post('/vue/login','Admin\LoginController@login');
//全部菜单
Route::get('/vue/allmenulist','Admin\MenuController@allmenulist');
//全部角色
Route::get('/vue/allrolelist','Admin\RoleController@allrolelist');


/**
 * 小程序后台接口
 */
Route::group(['prefix'=>'/wx'],function(){
    Route::get('/login','Api\UserController@wxlogin');
    Route::get('/auth','Api\UserController@authUserInfo');
});
