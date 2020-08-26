/**
 * Created by hms on 2020-08-18.
 */
import Vue from 'vue';
import Vuex from 'vuex'

//挂载
Vue.use(Vuex);

//加载modules!!!!!千万注意：这边{index} 是作为常量加进来
import { Menu } from './modules/Menu.js'
import { Login } from './modules/Login.js'
import { Account } from './modules/Account.js'
import { Role } from './modules/Role.js'

//创建VueX对象
const store = new Vuex.Store({
    state:{
        //分页配置
        page_sizes:[20,50,100],

    },
    modules:{
        Menu,
        Login,
        Account,
        Role
    }
})
export default store