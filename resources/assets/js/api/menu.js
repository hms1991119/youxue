/**
 * Created by hms on 2020-08-20.
 */
/**
 * 首页相关接口
 */
import { ROAST_CONFIG } from '../config.js';


export default{
    //获取菜单列表
    getMenu:function(data){
        return axios( ROAST_CONFIG.API_URL +'/menulist',{
            params:data
        });
    },
    getAllMenu:function(){
        return axios( ROAST_CONFIG.API_URL + '/allmenulist');
    },
    //修改资料
    editAccount:function(data){
        return axios.post(ROAST_CONFIG.API_URL+'/editaccount',qs.stringify(data),{
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        });
    },
}