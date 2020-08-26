<?php
namespace App\Http\Controllers\Admin;

use App\AdminRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller{
    
    /*
     * vue端获取菜单列表
     */
    public function menulist(){
        $input=$this->input;
        if($input['role_id']=='null'){
            return $this->vue_return_json(0);
        }
        $role_power=AdminRole::find($input['role_id'],['power_str'])->toArray();
        if(empty($role_power)){
            return $this->vue_return_json(0);
        }
        $role_power=json_decode($role_power['power_str'],true);
        $menu_list=\Menu::getMenuList();
        foreach($menu_list as $key=>&$item){
            foreach($item['child_items'] as $k=>$child){
                if(!in_array($child['id'],$role_power)){
                    unset($item['child_items'][$k]);
                }
            }
            if(count($item['child_items'])==0){
                unset($menu_list[$key]);
            }
        }
        return response()->json([
            'code' => 1,
            'list' => $menu_list
        ]);
    }

    //获取全部菜单
    public function allmenulist(Request $request)
    {
        $menu_list=\Menu::getMenuList();
        $send_list=[];
        if(!empty($menu_list)){
            $total_list=[];
            foreach($menu_list as $item){
                $temp=[];
                $temp['id']=$item['id'];
                $temp['label']=$item['module_name'];
                if(!empty($item['child_items'])){
                    foreach($item['child_items'] as $child){
                        $children=[];
                        $children['id']=$child['id'];
                        $children['label']=$child['module_name'];
                        $temp['children'][]=$children;
                    }
                }
                array_push($total_list,$temp);
            }
            //添加一个全部,id为-1
            $send_list[0]['children']=$total_list;
            $send_list[0]['id']=-1;
            $send_list[0]['label']='全部';
        }
        return response()->json([
            'code' => 1,
            'list' => $send_list
        ]);
    }
}