<?php
/**
 * 后台用户列表
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function list(Request $request)
    {
        if($request->ajax()){
            //参数
            $username=$request->input('username','');
            $query=DB::table('adminuser')->select('adminuser.*','role.role_name')
            ->leftJoin('role','role.id','=','adminuser.role');
            $query_count=DB::table('adminuser');
            if($username!=''){
                $query->where('username',$username);
                $query_count->where('username',$username);
            }
            $pageNumber=$request->input('pageNumber',0);
            $pageSize=$request->input('pageSize',20);
            $list=$query->orderBy('id','asc')->offset($pageNumber)->limit($pageSize)->get();
            $send_list=array();
            if(!empty($list)){
                foreach($list as $key=>$item){
                    $temp=array();
                    $temp['index']=$key+1;
                    $temp['realname']=$item->realname;
                    $temp['id']=$item->id;
                    $temp['username']=$item->username;
                    $temp['addtime']=date('Y-m-d',$item->addtime);
                    $temp['role_name']=$item->role_name;
                    $temp['enabled_name']=$item->enabled==0?'正常':'禁用';
                    $temp['enabled']=$item->enabled;
                    $send_list[]=$temp;
                }
            }
            $count=$query_count->count();
            $returnData=[
                'rows' => $send_list,
                'total' => $count
            ];
            return response()->json($returnData);
        }
        return view('admin.user.list');
    }
    
    //新增/编辑
    public function edit(Request $request)
    {
        $id=$request->input('id','');
        if($request->isMethod('post')){
            $data=$request->input();
            $data['enabled']=isset($data['enabled'])?1:0;
            unset($data['id']);
            if($id!=''){
                $res=DB::table('adminuser')->where('id',$id)->update($data);
            }else{
                //laravel自带加密
                $data['password']=bcrypt($data['password']);
                $data['addtime']=$_SERVER['REQUEST_TIME'];
                $res=DB::table('adminuser')->insert($data);
            }
            if($res>=0){
                $return_data=create_return_arr(\ErrorParams::ERRNO_SUCCESS,\ErrorParams::ERRMSG_SUCCESS);
            }else{
                $return_data=create_return_arr(\ErrorParams::ERRNO_SERVER,\ErrorParams::ERRMSG_SERVER);
            }
            return response()->json($return_data);
        }
        $info=array();
        if($id!=''){
            $info=DB::table('adminuser')->where('id',$id)->first();
        }
        $role_list=DB::table('role')->get();
        return view('admin.user.edit',['info'=>$info,'role_list'=>$role_list]);
    }
    
    //禁用/启用
    public function change_status(Request $request)
    {
        if($request->ajax()){
            $id=$request->input('id','');
            $status=$request->input('status',0);
            if($id!=''){
                $res=DB::table('adminuser')->where('id',$id)->update(['enabled'=>$status]);
                if($res){
                    $returnData=create_return_arr(\ErrorParams::ERRNO_SUCCESS,\ErrorParams::ERRMSG_SUCCESS);
                }else{
                    $returnData=create_return_arr(\ErrorParams::ERRNO_SERVER,\ErrorParams::ERRMSG_SERVER);
                }
                return response()->json($returnData);
            }
        }
    }
    
    //删除
    public function del(Request $request)
    {
        if($request->ajax()){
            $id=$request->input('id','');
            //自己不能删除自己
            if($this->uid==$id){
                $return_data=create_return_arr(\ErrorParams::ERRNO_CAN_NOT_DEL_SELF,\ErrorParams::ERRMSG_CAN_NOT_DEL_SELF);
                return response()->json($return_data);
            }
            if($id!=''){
                $res=DB::table('adminuser')->where('id',$id)->delete();
                if($res){
                    $return_data=create_return_arr(\ErrorParams::ERRNO_SUCCESS,\ErrorParams::ERRMSG_SUCCESS);
                }else{
                    $return_data=create_return_arr(\ErrorParams::ERRNO_SERVER,\ErrorParams::ERRMSG_SERVER);
                }
                return response()->json($return_data);
            }
        }
    }
}
