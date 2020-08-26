<!--首页-->
<template>
    <div id="app-layout">
    <el-container v-if="!(path=='/login')">
        <el-header class="el-header" height="80px">
            <el-scrollbar>
                <el-menu class="el-menu-demo" id="head-el-menu" mode="horizontal" background-color="#409EFF" text-color="#FFFFFF"
                         active-text-color="#FFFFFF">
                    <el-menu-item index="image" class="li-left">
                        <el-image style="height:80px;auto" :src="admin_logo" fit="contain"></el-image>
                    </el-menu-item>
                    <el-menu-item index="system_name" class="li-left" style="font-size:25px;padding-left:0px">保康社区后台管理系统</el-menu-item>
                    <el-menu-item index="/login" @click="logout">退出</el-menu-item>
                    <el-submenu index="2" class="el-submenu">
                        <template slot="title">当前用户：{{username}}</template>
                        <el-menu-item @click="fix_info(1)">修改资料</el-menu-item>
                    </el-submenu>

                </el-menu>
            </el-scrollbar>
        </el-header>
        <el-container>
            <el-aside width="null">
                <el-menu :style="mainStyle" default-active="1-4-1" class="el-menu-vertical-demo"
                         unique-opened @select="handleMenuSelect">
                    <el-submenu v-for="(menu,key) in menulist" :index="key.toString()">
                        <template slot="title">
                            <i :class="menu.icon_class"></i>
                            <span slot="title">{{menu.module_name}}</span>
                        </template>
                        <el-menu-item v-for="child in menu.child_items" :index="child.url">{{child.module_name}}</el-menu-item>
                    </el-submenu>
                </el-menu>
            </el-aside>
            <el-main class="el-main" :style="mainStyle">
                <router-view  v-if="hideRouterView"/>
            </el-main>
        </el-container>
    </el-container>
        <!--修改信息弹窗-->
        <el-dialog title="个人资料修改" :visible="showDialog" :show-close=false width="30%">
            <el-form ref="fix_form" :model="fix_form" :rules="rules" label-width="80px">
                <el-form-item label="账号">
                    <el-input v-model="fix_form.username" disabled></el-input>
                </el-form-item>
                <el-form-item label="新密码">
                    <el-input v-model="fix_form.password" placeholder="注意：如无需修改密码此项不要填写！！！"></el-input>
                </el-form-item>
                <el-form-item label="姓名">
                    <el-input v-model="fix_form.realname" ></el-input>
                </el-form-item>
                <el-form-item label="手机号">
                    <el-input v-model="fix_form.phone"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button type="primary" @click="submitFix('fix_form')" :loading="loading">{{button_name}}</el-button>
                <el-button @click="fix_info(0)">关闭</el-button>
            </div>
        </el-dialog>
    </div>
</template>
<script>
    import admin_logo from '../../../sass/images/admin_logo.png';

    export default {
        name: "Index",
        //父级组件属性，给子组件使用
        provide(){
            return {
                reload:this.reload
            }
        },
        data(){
            return {
                mainStyle: {
                    height: '800px'
                },
                fix_form:{
                    username:'',
                    password:'',
                    realname:'',
                    phone:''
                },
                rules:{
                    realname: [
                        { required:true , message:'请输入姓名',trigger:'blur' }
                    ],
                    phone: [
                        { min: 10, max: 11, message: '请输入11位手机号', trigger: 'blur' }
                    ]
                },
                path:'',
                admin_logo:admin_logo,
                hideRouterView:true,
                showDialog:false,
                loading:false,
                button_name:'立即修改'
            }
        },
        //初始化时
        created(){
            //加载菜单列表
            var send_data={
                api_token:this.$store.getters.getSessionId,
                role_id:this.$store.getters.getLoginRoleId
            };
            this.$store.dispatch('loadMenuList',send_data);
            //侧边栏和main高度
            let window_height = window.innerHeight;
            let mainHeight = (window_height - 80) + 'px';
            this.mainStyle = {
                height: mainHeight
            }
        },
        mounted() {

        },
        computed:{
            //直接可以在页面上进行使用
            menulist(){
                return this.$store.getters.getMenuList;
            },
            username(){
                return this.$store.getters.getLoginUsername==''?'未知':this.$store.getters.getLoginUsername;
            },
            login_status(){
                return this.$store.getters.getLoginStatus;
            },
            account_info(){
                return this.$store.getters.getAccountInfo;
            },
            editHeaderAccountStatus(){
                return this.$store.getters.getEditHeaderAccountStatus;
            }
        },
        watch: {
            //登录状态变化
            login_status(val){
                let that=this;
                if(val==-1){
                    //退出成功
                    this.$message({
                        message:'退出成功',
                        type:'success',
                        duration:1000,
                        onClose:function(e){
                            that.$router.push('/login');
                        }
                    });
                }else{
                    this.$message({message:'退出失败',type:'error'});
                }
            },
            //获取表单信息
            account_info(val){
                this.fix_form.username=val.username;
                this.fix_form.realname=val.realname;
                this.fix_form.phone=val.phone;
            },
            editHeaderAccountStatus(val){
                let that=this;
                if(val==1){
                    //按钮置为失效
                    this.$message({
                        message:'修改成功，退出登录后生效',
                        type:'success',
                        duration:1000,
                        onClose:function(e){
                            that.showDialog=false;
                            that.$store.commit('setEditHeaderAccountStatus',-1);
                        }
                    });
                }else if(val==0){
                    this.$message({
                        message:'修改失败，请重试',
                        type:'error',
                        duration:2000
                    });
                    that.loading=false;
                    that.button_name='立即修改';
                    //初始化状态
                    that.$store.commit('setEditHeaderAccountStatus',-1);
                }
            },
        },
        methods: {
            handleMenuSelect(index, indexPath) {
                this.$router.push(index);
            },
            logout(e){
                let that=this;
                this.$confirm('确认退出登录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    that.$store.dispatch('loadLogout');
                })
            },
            //重载刷新页面
            reload(){
                this.hideRouterView=false;
                this.$nextTick(function(){
                    this.hideRouterView=true;
                })
            },
            //修改个人资料
            fix_info(type){
                if(type==1){
                    var send_data={
                        id:this.$store.getters.getLoginUserId,
                        api_token:this.$store.getters.getSessionId
                    };
                    this.$store.dispatch('loadAccountInfo',send_data);
                    this.showDialog=true;
                }else{
                    this.showDialog=false;
                }
            },
            submitFix(formName){
                let that = this;
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.loading=true;
                        this.button_name='正在提交';
                        var send_data={
                            api_token:this.$store.getters.getSessionId,
                            realname:this.fix_form.realname,
                            phone:this.fix_form.phone,
                            id:this.$store.getters.getLoginUserId
                        };
                        if(this.fix_form.password!=''){
                            send_data.password=this.fix_form.password;
                        }
                        this.$store.dispatch('editHeaderAccount',send_data);
                    }else{
                        return false;
                    }
                })
            }
        },
    }
</script>


<style>
@import url('../../../sass/css/header.css');

</style>