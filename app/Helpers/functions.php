<?php
/*
 * 公共函数库，通过在composer.json中autoload加入files标签即可，然后运行composer dump-auto实现全局自动加载
 */
//返回数组
function create_return_arr($errno,$errmsg)
{
    return [
       'errno' => $errno,
       'errmsg' => $errmsg
    ];
}
//获取表的hash

