/**
 * Created by hms on 2020-08-21.
 * 登录api
 */
import { ROAST_CONFIG } from '../config.js';


export default{
    login:function(send_data){
        return axios.post(ROAST_CONFIG.API_URL+'/login',qs.stringify(send_data),{
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        });
    },
    //初始化登录state信息
    initLogin:function(code){
        return {
            code:code,
            info:{
                username:'',
                session_id:'',
                user_id:'',
                role_id:''
            }
        };
    }
}