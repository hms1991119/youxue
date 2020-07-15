<?php
/**
 * banner上传
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use app\Helpers\QiniuHelper;

class BannerController extends Controller
{
    public function list(Request $request)
    {
        if($request->ajax()){
            
        }
        return view('admin.banner.index');
    }
    
    public function edit(Request $request)
    {
        $id=$request->input('id','');
        if($request->isMethod('post')){
            $data=$request->input();
            $pic=$_FILES['pic'];
            //文件上传失败
            if($pic['error']!=0){
                $return_data=create_return_arr(\ErrorParams::ERRNO_UPLOAD_FAILED, \ErrorParams::ERRMSG_UPLOAD_FAILED);
                return response()->json($return_data);
            }
            $qiniu=new QiniuHelper();
            $upload_src=$qiniu->upload($pic['tmp_name'],$pic['name']);
            $data['enabled']=is_null($data['enabled'])?0:1;
            $data['src']=$upload_src;
            
            //文件上传失败
            
            //这边处理七牛云上传
            
            var_dump($pic);exit;
        }
        return view('admin.banner.edit');
    }
}
