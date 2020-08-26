<?php

namespace App\Http\Controllers\Admin;

use App\AdminRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    private $model_instance=AdminRole::class;

    public function rolelist(){
        $input=$this->input;
        $current_page=$input['current_page']<=1?1:$input['current_page'];
        $page_size=$input['page_size'];
        $start=($current_page-1)*$page_size;
        $list=AdminRole::offset($start)->limit($page_size)->get()->toArray();
        $send_list=[];
        if(!empty($list)){
            foreach($list as $key=>$item){
                $temp=[];
                $temp['index']=$key+1;
                $temp['id']=$item['id'];
                $temp['name']=$item['name'];
                $temp['create_date']=is_null($item['created_at'])?'':substr($item['created_at'],0,10);
                $temp['enabled']=$item['enabled']==1?'正常':'禁用';
                array_push($send_list,$temp);
            }
        }
        $total_count=AdminRole::count();
        return response()->json([
            'code' => 1,
            'list' => $send_list,
            'total_count' => $total_count
        ]);
    }

    //获取全部角色
    public function allrolelist()
    {
        $list=AdminRole::where('enabled',1)->get()->toArray();
        $send_list=[];
        if(!empty($list)){
            foreach($list as $item){
                $temp=[];
                $temp['value']=$item['id'];
                $temp['label']=$item['name'];
                array_push($send_list,$temp);
            }
        }
        return response()->json([
            'code' => 1,
            'list' => $send_list
        ]);
    }

    public function editrole()
    {
        $input=$this->input;
        $code=$this->edit_instance($this->model_instance,$input);
        return $this->vue_return_json($code);
    }

    public function roleinfo()
    {
        $info=$this->input;
        if(isset($info['id'])){
            $info=AdminRole::find($info['id'])->toArray();
            $info['power_str']=is_null($info['power_str'])?[]:json_decode($info['power_str'],true);
            return response()->json([
                'code' => 1,
                'info' => $info
            ]);
        }
        return response()->json([
            'code' => 0
        ]);
    }

    //删除
    public function delrole()
    {
        $input=$this->input;
        //1始终是超级管理员
        if(!isset($input['id']) || $input['id']==1){
            return response()->json([
                'code' => 0
            ]);
        }
        $res=AdminRole::where('id',$input['id'])->delete();
        if($res){
            return response()->json([
                'code' => 1
            ]);
        }
        return response()->json([
            'code' => 0
        ]);
    }
}
