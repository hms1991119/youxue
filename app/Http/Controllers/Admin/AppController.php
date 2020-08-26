<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    //vue视图入口
    public function getApp()
    {
        $title=config('app.name');
        return view('app',[
            'title' => $title
        ]);
    }

}
