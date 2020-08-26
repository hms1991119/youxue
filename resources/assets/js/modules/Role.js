/**
 * Created by hms on 2020-08-22.
 */
import RoleAPI from '../api/role.js'

export const Role={
    state:{
        rolelist:[],
        role_total_count:0,
        editRoleStatus:-1,     //插入状态 0失败  1成功  -1不改变
        roleinfo:[],
        delRoleStatus:-1,       //删除状态
        allrolelist:[]           //全部未禁用的角色
    },
    mutations:{
        setRoleList(state,rolelist){
            state.rolelist=rolelist;
        },
        setRoleTotalCount(state,total_count){
            state.role_total_count=total_count;
        },
        setEditRoleStatus(state,status){
            state.editRoleStatus=status;
        },
        setRoleInfo(state,info){
            state.roleinfo=info;
        },
        setDelRoleStatus(state,status){
            state.delRoleStatus=status;
        },
        setAllRoleList(state,list){
            state.allrolelist=list;
        }
    },
    actions:{
        loadRoleList(context,data){
            RoleAPI.getRoleList(data).then(function(response){
                if(response.data.code==1){
                    context.commit('setRoleList',response.data.list);
                    context.commit('setRoleTotalCount',response.data.total_count);
                }
            })
        },
        //插入role
        editRole(context,data){
            RoleAPI.editRole(data).then(function(response){
                context.commit('setEditRoleStatus',response.data.code);
            })
        },
        //获取详情
        loadRoleInfo(context,data){
            RoleAPI.getRoleInfo(data).then(function(response){
                if(response.data.code==1){
                    context.commit('setRoleInfo',response.data.info);
                }
            })
        },
        //删除
        delRole(context,data){
            RoleAPI.delRole(data).then(function(response){
                  context.commit('setDelRoleStatus',response.data.code);
            })
        },
        //获取全部未禁用角色，下拉框
        loadAllRoleList(context){
            RoleAPI.getAllRoleList().then(function(response){
                if(response.data.code==1){
                    context.commit('setAllRoleList',response.data.list);
                }
            })
        }
    },
    getters:{
        getRoleList:state => {
            return state.rolelist;
        },
        getRoleTotalCount:state => {
            return state.role_total_count;
        },
        getEditRoleStatus:state=>{
            return state.editRoleStatus;
        },
        getRoleInfo:state => {
            return state.roleinfo;
        },
        getDelRoleStatus:state => {
            return state.delRoleStatus;
        },
        getAllRoleList: state =>{
            return state.allrolelist;
        }
    }
}