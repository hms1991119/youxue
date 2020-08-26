/**
 * 路由
 */
import Vue from 'vue'
import Router from 'vue-router'
import store from './store'
import StorageAPI from './api/storage'

Vue.use(Router)

const limit_time=60*60*1000;   //session响应时间30分钟，超过清空

//加一个判断，如果没有登录就直接跳到登录页面,这边到时候用access_token或者session来判断
function checkLogin(to,from,next){
    //这边设置拦截，刷新页面判断state和缓存，判断过期时间
    //20200823解决跨标签登录问题，修改sessionStorage为localStorage
    var state_session_id=store.getters.getSessionId;
    var over_limit=false;
    if(state_session_id==''){
        var storage_session_id=StorageAPI.get_storage('session_id');
        console.log(storage_session_id);
        //缓存中也没有登录信息的时候就跳转登录
        if(storage_session_id=='' || storage_session_id=='undefined' || storage_session_id==null){
            next('/login');
            return;
        }else{
            //缓存中有信息，就让缓存中的数据给state更新一遍
            console.log(StorageAPI.get_storage('username'));
            store.commit('setLogin',{
                code:1,
                info:{
                    username:StorageAPI.get_storage('username'),
                    session_id:StorageAPI.get_storage('session_id'),
                    user_id:StorageAPI.get_storage('user_id'),
                    role_id:StorageAPI.get_storage('role_id')
                }
            })
            over_limit=setLimitTime();
            //超时跳转回登录页，清空session
            if(!over_limit){
                next('/login');
            }else{
                next();
            }
        }
    }else{
        over_limit=setLimitTime();
        if(!over_limit){
            next('/login');
        }else{
            next();
        }
    }
}

//判断过期时间
function setLimitTime(){
    //是否有这个时间
    var start_time=StorageAPI.get_session_storage('start_limit_time');
    if(start_time!='undefined' && start_time!=null){
        //看到当前的时间是否超过超时时间
        var now_time=Date.now();
        if((parseInt(start_time)+limit_time)<now_time){
            //清空缓存，跳回登录页
            localStorage.clear();
            return false;
        }
        //不超过就重新计时
        StorageAPI.store_session_storage('start_limit_time',now_time);
        return true;
    }
    var now_time=Date.now();
    StorageAPI.store_session_storage('start_limit_time',now_time);
    return true;
}


export default  new Router({
    //嵌套路由，设置布局
    mode: 'history',
    routes: [
        {
            path: '/',
            name:'layout',
            beforeEnter:checkLogin,
            component:Vue.component('Index',require('./components/layout/Header.vue')),
            children:[
                {
                    path: 'index',
                    name:'layout',
                    beforeEnter:checkLogin,
                    component:Vue.component('Index',require('./components/index/Index.vue')),
                },
                //用户列表
                {
                    path:'accountlist',
                    name:'accountlist',
                    beforeEnter:checkLogin,
                    component: Vue.component( 'AccountList', require( './components/account/AccountList.vue' ) )
                },
                {
                    path:'accountEdit/:id/:edit_type',
                    name:'accountEdit',
                    beforeEnter:checkLogin,
                    component: Vue.component( 'AccountEdit', require( './components/account/AccountEdit.vue' ) )
                },
                //角色列表
                {
                    path:'rolelist',
                    name:'rolelist',
                    beforeEnter:checkLogin,
                    component: Vue.component( 'RoleList', require( './components/role/RoleList.vue' ) )
                },
                {
                    path:'roleedit/:id/:edit_type',
                    name:'roleedit',
                    beforeEnter:checkLogin,
                    component: Vue.component( 'RoleEdit', require( './components/role/RoleEdit.vue' ) )
                }
            ]
        },
        {
            path:'/login',
            name:'login',
            component:Vue.component( 'Test', require( './components/login/Login.vue' ) )
        }
    ]
})