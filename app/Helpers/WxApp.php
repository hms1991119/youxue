<?php
/**
 * Created by PhpStorm.
 * User: hms
 * Date: 2020-08-25
 * Time: 9:25
 */
class WxApp{
    private static $appid='wx18d5a145308e44d8';
    private static $sercet='0e6f6a49eb69c839b46a93bbec515357';

    //登录，code2session 得到session_key和open_id
    public static function getWxInfo($code)
    {
        $appid=self::$appid;
        $sercet=self::$sercet;
        $url="https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$sercet}&js_code={$code}&grant_type=authorization_code";
        $res=curl_get($url);
        if(empty($res['session_key']) && empty($res['openid'])){
            return -1;
        }
        return $res;
    }

    //获取用户信息
    public static function checkUserInfo($session_key,$rawData,$signature,$iv,$encryptedData)
    {
        //校验sha1加密
        $check_signature=sha1($rawData.$session_key);
        if($check_signature!=$signature){
            //校验失败
            return -1;
        }
        $wx_crypt=new WXBizDataCrypt(self::$appid,$session_key);
        //解密
        $errCode = $wx_crypt->decryptData($encryptedData, $iv, $data );
        var_dump($errCode);
        var_dump($data);exit;
        if($errCode==1){
            return $data;
        }
        return -1;
    }

}