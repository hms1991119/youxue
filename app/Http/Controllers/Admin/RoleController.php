<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function list(Request $request)
    {
        if($request->ajax()){
            $list=DB::table('role')->get();
            $send_list=array();
            if(!empty($list)){
                foreach($list as $key=>$item){
                    $temp=array();
                    $temp['index']=$key+1;
                    $temp['id']=$item->id;
                    $temp['role_name']=$item->role_name;
                    $send_list[]=$temp;
                }
            }
            $count=DB::table('role')->count();
            $returnData=[
               'rows'=>$send_list,
               'total'=>$count
            ];
            return response()->json($returnData);
        }
        return view('admin.role.index');
    }
    
    //新增/编辑
    public function edit(Request $request)
    {
        $id=$request->input('id','');
        if($request->isMethod('post')){
            $menus_str=$request->input('menus','');
            $role_name=$request->input('role_name');
            $menus_arr=array();
            if($menus_str!=''){
                $menus_str=substr($menus_str,0,-1);
            }
            if($id!=''){
                $res=DB::table('role')->where('id',$id)->update(['role_name'=>$role_name,'power_str'=>$menus_str]);
            }else{
                $res=DB::table('role')->insert(['role_name'=>$role_name,'power_str'=>$menus_str]);
            }
            if($res>=0){
                $return_data=create_return_arr(\ErrorParams::ERRNO_SUCCESS,\ErrorParams::ERRMSG_SUCCESS);
            }else{
                $return_data=create_return_arr(\ErrorParams::ERRNO_SERVER,\ErrorParams::ERRMSG_SERVER);
            }
            return response()->json($return_data);
        }
        $info=array();
        $power_list=array();
        if($id!=''){
            $info=DB::table('role')->where('id',$id)->first();
        }
        if(!empty($info) && $info->power_str!=''){
            $power_list=explode(',',$info->power_str);
        }
        // 全部菜单
        $menu_list=DB::table('module')->select('id','module_name','pid')->orderBy('module_sort','asc')->get();
        if(!empty($power_list)){
            foreach($menu_list as $item){
               if(in_array($item->id,$power_list)){
                       $item->checked=1;
               }
            }
        }
        return view('admin.role.edit',['info'=>$info,'menu_list'=>$menu_list]);
    }
    
    //删除
    public function del(Request $request)
    {
        $id=$request->input('id','');
        //1始终是超级管理员
        if($id==1){
            $return_data=create_return_arr(\ErrorParams::ERRNO_CAN_NOT_DEL_ADMIN,\ErrorParams::ERRMSG_CAN_NOT_DEL_ADMIN);
            return response()->json($return_data);
        }
        if($id!=''){
            $res=DB::table('role')->where('id',$id)->delete();
            if($res){
                $return_data=create_return_arr(\ErrorParams::ERRNO_SUCCESS,\ErrorParams::ERRMSG_SUCCESS);
            }else{
                $return_data=create_return_arr(\ErrorParams::ERRNO_SERVER,\ErrorParams::ERRMSG_SERVER);
            }
            return response()->json($return_data);
        }
    }
}
