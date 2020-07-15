<?php
namespace app\Helpers;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
/**
 * 七牛云静态文件上传
 */
class QiniuHelper{
    
    private $accessKey = 'Aq4Lc8t1I8LEgPB_cKesM2-AV5EJVrwCTocw00Bu';
    private $secretKey = 'CNrZCoX_K8cR55RBIz9BE9PcxSSONQRN_z1--d74';
    
    //七牛云加速域名
    private $cdn_domain='http://youxue.huomaost.com/';
    
    private $bucket='hms_space';
    
    private $prefix='youxue/images/';
    
    private $auth;
    
    function __construct(){
        require '../vendor/qiniu/autoload.php';
        //鉴权
        $this->auth=new Auth($this->accessKey,$this->secretKey);
    }
    
    /*
     * 上传
     * @filePath 上传临时文件路径
     * @key 上传文件返回路径
     */
    public function upload($filePath,$key)
    {
        //生成上传token
        $token=$this->auth->uploadToken($this->bucket);
        
        $uploadMgr = new UploadManager();
        list($ret, $err)=$uploadMgr->putFile($token,$this->prefix.$key,$filePath);
        if ($err !== null) {
            return false;
        } else {
            if(isset($ret['key']) && isset($ret['hash'])){
                return $this->cdn_domain.$ret['key'];
            }
        }
        return false;
    }
}