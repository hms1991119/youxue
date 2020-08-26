/**
 * Created by hms on 2020-08-22.
 * 用户列表
 */
import { ROAST_CONFIG } from '../config.js'

export default{
    //加载用户列表，加入分页查询以及查询条件为参数
    getAccountList:function(data){
        return axios.get(ROAST_CONFIG.API_URL+'/accountlist',{params : data});
    },
    //编辑角色
    editAccount:function(data){
        return axios.post(ROAST_CONFIG.API_URL+'/editaccount',qs.stringify(data),{
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        });
    },
    //获取角色信息
    getAccountInfo:function(data){
        return axios.get(ROAST_CONFIG.API_URL+'/accountinfo',{
            params:data
        });
    },
    //删除
    delAccount:function(data){
        return axios.get(ROAST_CONFIG.API_URL+'/delaccount',{
            params:data
        });
    }
}