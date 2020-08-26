/**
 * Created by hms on 2020-08-22.
 */
import AccountAPI from '../api/account.js'

export const Account={
    state:{
        accountlist:[],
        account_total_count:0,
        editAccountStatus:-1,     //插入状态 0失败  1成功  -1不改变
        accountinfo:[],
        delAccountStatus:-1       //删除状态
    },
    mutations:{
        setAccountList(state,data){
            state.accountlist=data;
        },
        setTotalCount(state,count){
            state.account_total_count=count;
        },
        setEditAccountStatus(state,status){
            state.editAccountStatus=status;
        },
        setAccountInfo(state,info){
            state.accountinfo=info;
        },
        setDelAccountStatus(state,status){
            state.delAccountStatus=status;
        }
    },
    actions:{
        loadAccountList(context,data){
            AccountAPI.getAccountList(data).then(function(response){
                if(response.data.code==1){
                    context.commit('setAccountList',response.data.list);
                    context.commit('setTotalCount',response.data.total_count);
                }
            })
        },
        editAccount(context,data){
            AccountAPI.editAccount(data).then(function(response){
                context.commit('setEditAccountStatus',response.data.code);
            })
        },
        //获取详情
        loadAccountInfo(context,data){
            AccountAPI.getAccountInfo(data).then(function(response){
                if(response.data.code==1){
                    context.commit('setAccountInfo',response.data.info);
                }
            })
        },
        //删除
        delAccount(context,data){
            AccountAPI.delAccount(data).then(function(response){
                context.commit('setDelAccountStatus',response.data.code);
            })
        }
    },
    getters:{
        getAccountList:state => {
            return state.accountlist;
        },
        getAccountTotalCount:state => {
            return state.account_total_count;
        },
        getEditAccountStatus:state=>{
            return state.editAccountStatus;
        },
        getAccountInfo:state => {
            return state.accountinfo;
        },
        getDelAccountStatus:state => {
            return state.delAccountStatus;
        }
    }
}