/**
 * Created by hms on 2020-08-21.
 * session存储，必须加密
 */
export default{
    //存储加密
    store_storage:function(key,item){
        localStorage.setItem(key,item);
    },

    //存储解密
    get_storage:function(key) {
        //return sessionStorage.getItem(key);
        return localStorage.getItem(key);
    },

    //sessionStorage加密
    store_session_storage:function(key,item){
        sessionStorage.setItem(key,item);
    },

    get_session_storage:function(key){
        sessionStorage.getItem(key);
    }
}
