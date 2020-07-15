<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        // 查询菜单
        $info = DB::table('adminuser')->select('role.power_str')
            ->leftJoin('role','role.id','=','adminuser.role')
            ->where('adminuser.id', $this->uid)
            ->first();
        $power_str=$info->power_str;
        $power_arr=array();
        if($power_str!=''){
            $power_arr=explode(',',$power_str);
        }
        $menu_list=DB::table('module')->whereIn('id',$power_arr)->orderBy('module_sort','asc')->get();
        $new_menu_list=array();
        if(!empty($menu_list)){
            foreach($menu_list as $item){
                if($item->pid==0){
                    foreach($menu_list as $item1){
                       if($item->id==$item1->pid){
                           $item->child_items[]=$item1;
                           
                       }
                    }
                    $new_menu_list[]=$item;
                }
            }
        }
        // 获取用户信息
        $userinfo = DB::table('adminuser')->where('id', $this->uid)->first();
        return view('admin.index.index', [
            'menu_list' => $new_menu_list,
            'realname' => $userinfo->realname,
            'headimgurl' => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $userinfo->headimgurl
        ]);
    }

    // 头像上传
    public function upload_headimg(Request $request)
    {
        if ($request->hasFile('myfile')) {
            $file = $_FILES['myfile'];
            $upload_path = 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d');
            if (! is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            $file_name = $upload_path . '/' . $file['name'];
            $res = move_uploaded_file($file['tmp_name'], $file_name);
            if ($res) {
                DB::table('adminuser')->where('id', $this->uid)->update([
                    'headimgurl' => $file_name
                ]);
                $return_data = [
                    'errno' => \ErrorParams::ERRNO_SUCCESS,
                    'errmsg' => \ErrorParams::ERRMSG_SUCCESS,
                    'data' => $file_name
                ];
                return response()->json($return_data);
            }
        }
        $return_data = [
            'errno' => \ErrorParams::ERRNO_UPLOAD_FAILED,
            'errmsg' => \ErrorParams::ERRMSG_UPLOAD_FAILED,
            'data' => ''
        ];
        return response()->json($return_data);
    }

    // 密码修改
    public function save_password(Request $request)
    {
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');
        $user_password = DB::table('adminuser')->where('id', $this->uid)->value('password');
        if (md5($old_password) != $user_password) {
            $return_data=create_return_arr(\ErrorParams::ERRNO_OLD_PASSWORD_ERROR,\ErrorParams::ERRMSG_OLD_PASSWORD_ERROR);
        } else {
            $update_res = DB::table('adminuser')->where('id', $this->uid)->update([
                'password' => md5($new_password)
            ]);
            if (! $update_res) {
                $return_data=create_return_arr(\ErrorParams::ERRNO_SERVER,\ErrorParams::ERRMSG_SERVER);
            } else {
                $return_data=create_return_arr(\ErrorParams::ERRNO_SUCCESS,\ErrorParams::ERRMSG_SUCCESS);
            }
        }
        return response()->json($return_data);
    }
}
