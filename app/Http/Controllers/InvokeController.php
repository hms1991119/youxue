<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    //命名空间三元素：

class InvokeController extends Controller
{
    //单个控制器方法
    public function __invoke(Request $request)
    {
        var_dump(route('alias'));
        var_dump($request->input('name'));
        echo '单例方法';
    }
}
