<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function list(Request $request)
    {
        $parent_list=DB::table('module')->select('id','module_name')->where('pid',0)->orderBy('module_sort','asc')->get();
        $parent_hash=array();
        if(!empty($parent_list)){
            foreach($parent_list as $item){
                $parent_hash[$item->id]=$item->module_name;
            }
        }
        if($request->ajax()){
            $pid=$request->input('pid',0);
            $pageNumber=$request->input('pageNumber',0);
            $pageSize=$request->input('pageSize',20);
            $query=DB::table('module');
            $query_count=DB::table('module');
            if($pid!=0){
                $query->where('pid',$pid);
                $query_count->where('pid',$pid);
            }
            $list=$query->orderBy('module_sort','asc')->offset($pageNumber)->limit($pageSize)->get();
            $count=$query_count->count();
            $send_list=array();
            if(!empty($list)){
                foreach($list as $key=>$item){
                        $temp=array();
                        $temp['index']=$key+1;
                        $temp['module_name']=$item->module_name;
                        $temp['url']=$item->url;
                        $temp['status_name']=$item->status==1?'正常':'禁用';
                        $temp['pid']=$item->pid;
                        $send_list[]=$temp;
                }
                foreach($send_list as $key=>$item){
                    if($item['pid']==0){
                        $send_list[$key]['parent_name']='系统';
                    }else{
                        $send_list[$key]['parent_name']=$parent_hash[$item['pid']];
                    }
                }
            }
            $returnData=[
                'rows' => $send_list,
                'total' => $count
            ];
            return response()->json($returnData);
        }
        
        return view('admin.menu.index',['parent_hash'=>$parent_hash]);
    }
}
