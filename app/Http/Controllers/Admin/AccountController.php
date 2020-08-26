<?php

namespace App\Http\Controllers\Admin;

use App\AdminAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    private $model_instance=AdminAccount::class;

    public function accountlist(Request $request){
        $input=$this->input;
        $current_page=$input['current_page']<=1?1:$input['current_page'];
        $page_size=$input['page_size'];
        $start=($current_page-1)*$page_size;
        $list=AdminAccount::offset($start)->limit($page_size)->get()->toArray();
        $send_list=[];
        if(!empty($list)){
            foreach($list as $key=>$item){
                $temp=[];
                $temp['index']=$key+1;
                $temp['id']=$item['id'];
                $temp['username']=$item['username'];
                $temp['realname']=$item['realname'];
                $temp['role']='管理员';
                $temp['create_date']=is_null($item['created_at'])?'':substr($item['created_at'],0,10);
                $temp['enabled']=$item['enabled']==1?'正常':'禁用';
                array_push($send_list,$temp);
            }
        }
        $total_count=AdminAccount::count();
        return response()->json([
            'code' => 1,
            'list' => $send_list,
            'total_count'=> $total_count
        ]);
    }

    public function editaccount()
    {
        //创建角色添加api_token
        $input=$this->input;
        if(!isset($input['id'])){
            $input['api_token']=Str::random(60);
        }
        //密码加密
        if(isset($input['password'])){
            $input['password']=bcrypt($input['password']);
        }
        $code=$this->edit_instance($this->model_instance,$input);
        return $this->vue_return_json($code);
    }

    public function accountinfo()
    {
        $res=$this->instance_info($this->model_instance);
        return $res;
    }

    public function delaccount(Request $request)
    {
        $code=$this->del_instance($this->model_instance);
        return $this->vue_return_json($code);
    }
}
