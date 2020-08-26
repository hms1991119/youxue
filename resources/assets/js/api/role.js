/**
 * Created by hms on 2020-08-22.
 */
import { ROAST_CONFIG } from '../config.js';

export default{
    getRoleList:function(data){
        return axios.get(ROAST_CONFIG.API_URL+'/rolelist',{ params : data});
    },
    //编辑角色
    editRole:function(data){
        return axios.post(ROAST_CONFIG.API_URL+'/editrole',qs.stringify(data),{
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        });
    },
    //获取角色信息
    getRoleInfo:function(data){
        return axios.get(ROAST_CONFIG.API_URL+'/roleinfo',{
            params:data
        });
    },
    //删除
    delRole:function(data){
        return axios.get(ROAST_CONFIG.API_URL+'/delrole',{
            params:data
        });
    },
    //全部角色
    getAllRoleList:function(){
        return axios.get(ROAST_CONFIG.API_URL+'/allrolelist');
    }
}