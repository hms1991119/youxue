/**
 * Created by hms on 2020-08-20.
 */
import MenuAPI from '../api/menu.js'

export const Menu = {
    state:{
        menulist:[],
        path:'/index',
        allmenulist:[],
        editHeaderAccountStatus:-1
    },
    //设置变量,监控数据变化
    mutations:{
        setMenuList(state,menulist){
            state.menulist=menulist;
        },
        setAllMenuList(state,allmenulist){
            state.allmenulist=allmenulist;
        },
        setEditHeaderAccountStatus(state,status){
            state.editHeaderAccountStatus=status;
        }
    },
    actions:{
        loadMenuList(context,data){
            MenuAPI.getMenu(data).then(function(response){
                context.commit('setMenuList',response.data.list);
            })
        },
        //加载全部菜单，用于树形图选择
        loadAllMenuList(context){
            MenuAPI.getAllMenu().then(function(response){
                context.commit('setAllMenuList',response.data.list);
            })
        },
        //修改首页
        editHeaderAccount(context,data){
            MenuAPI.editAccount(data).then(function(response){
                context.commit('setEditHeaderAccountStatus',response.data.code);
            })
        }
    },
    getters:{
        getMenuList:state=>{
           return state.menulist;
        },
        getPath:state=>{
           return state.path;
        },
        getAllMenuList:state => {
           return state.allmenulist;
        },
        getEditHeaderAccountStatus:state =>{
           return state.editHeaderAccountStatus;
        }

    }
}