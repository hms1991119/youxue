/**
 * Created by hms on 2020-08-21.
 * 登录模块
 */
import LoginAPI from '../api/login.js'
import StorageAPI from '../api/storage.js'

export const Login = {
    state:{
        login_status:-1,    //0 失败  1 成功   -1初始状态
        username:'',
        session_id:'',
        role_id:'',
        user_id:''
    },
    mutations:{
        setLogin(state,data){
            state.login_status = data.code;
            state.username = data.info.username;
            state.session_id = data.info.session_id;
            state.role_id=data.info.role_id;
            state.user_id=data.info.user_id;
        },
        setLoginStatus(state,code){
            state.login_status=code;
        }
    },
    actions:{
        //登录
        loadLogin(context,send_data){
            LoginAPI.login(send_data).then(function(response){
                //请求成功，将session信息存放到localStorage
                if(response.data.code==1){
                    //这边每次都看缓存中是否有，如果有就重新赋值
                    for(var key in response.data.info){
                        StorageAPI.store_storage(key,response.data.info[key]);
                    }
                    context.commit('setLogin',response.data);
                }else{
                    context.commit('setLogin',LoginAPI.initLogin(response.data.code));
                }
            })
        },
        //退出登录，清空session_id
        loadLogout(context,data){
            //清空缓存
            localStorage.clear();
            sessionStorage.clear();
            context.commit('setLogin',LoginAPI.initLogin(-1));
        }
    },
    getters:{
        getLoginStatus: state =>{
            return state.login_status
        },
        getLoginUsername: state =>{
            return state.username
        },
        getSessionId: state =>{
            return state.session_id
        },
        getLoginRoleId: state =>{
            return state.role_id
        },
        getLoginUserId: state =>{
            return state.user_id
        }
    }
}