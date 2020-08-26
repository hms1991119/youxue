<?php

use App\Http\Middleware\checkAge;
use Illuminate\Support\Facades\Auth;

//默认跳转
Route::get('/','Admin\AppController@getApp');
//匹配所有vue路由
Route::get('/{id}', 'Admin\AppController@getApp');


