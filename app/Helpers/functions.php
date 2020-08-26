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


function curl_get($url)
{
    $headerArray =array("Content-type:application/json;","Accept:application/json");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
    $output = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($output,true);
    return $output;
}

