/*
 * vue主入口文件
 */
window._ = require('lodash');
try {
    window.$ = window.jQuery = require('jquery');
    require('foundation-sites');
} catch (e) {}
//引入axios
window.axios = require('axios');
window.qs=require('qs');
import axios from 'axios';
//设置默认的axios头，构造csrf-token
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

import Vue from 'vue';

Vue.prototype.$axios=axios;
//引入elementui
import ElementUI from 'element-ui';
//引入自定义主题
import './theme/index.css';
Vue.use(ElementUI);

//引入qs
import qs from 'qs';
Vue.prototype.$qs = qs;

//引入路由
import router from './route'
//引入vuex状态管理
import store from './store'

//引入定义的域名
import { ROAST_CONFIG } from './config.js';

Vue.prototype.$API_URL=ROAST_CONFIG.API_URL;

//解决重复点击按钮报错的问题
/*const originalPush = router.prototype.push
 router.prototype.push = function push(location) {
 return originalPush.call(this, location).catch(err => err)
 }*/


//挂载
new Vue({
    router,
    store
}).$mount('#app');
