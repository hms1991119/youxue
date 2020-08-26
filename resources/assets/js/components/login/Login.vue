<template>
    <div id="login">
        <el-card class="my-card">
            <div slot="header" class="clearfix" shadow="always">
                <span>登录</span>
            </div>
            <el-form ref="login_form" class="edit-el-form" :model="login_form" :rules="rules" label-width="80px">
                <el-form-item label="账号" prop="username">
                    <el-input v-model="login_form.username" clearable required></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="password">
                    <el-input v-model="login_form.password" show-password clearable required></el-input>
                </el-form-item>
            </el-form>
            <div style="display: flex;justify-content: center;">
                <el-button type="primary" @click="submitForm('login_form')" :loading="loading">{{button_name}}</el-button>
            </div>
        </el-card>

    </div>
</template>

<script>
    export default {
        name: 'Login',
        data() {
            return {
                login_form: {
                    username: '',
                    password: '',
                },
                //校验规则
                rules:{
                    username: [
                        { required:true , message:'请输入用户名',trigger:'blur' },
                        { min:3 ,message:'用户名不能少于3个字符',trigger:'blur'}
                    ],
                    password: [
                        { required:true,message:'请输入密码',trigger:'blur'},
                        { min:3, message:'密码不能少于3个字符',trigger:'blur'}
                    ]
                },
                loading:false,
                button_name:'登录'
            }
        },
        methods: {
            submitForm(formName) {
                let that = this;
                this.$refs[formName].validate((valid)=>{
                    if (valid) {
                        that.loading=true;
                        that.button_name='正在登录';
                        let send_data={
                            username: this.login_form.username,
                            password: this.login_form.password
                        };
                        this.$store.dispatch('loadLogin',send_data);
                    } else {
                        return false;
                     }
                })
            }
        },
        computed:{
            login_status(){
                return this.$store.getters.getLoginStatus;
            },
            msg(){
                return this.$store.getters.getMsg;
            }
        },
        //用watch观察status中的值
        watch:{
            login_status(val){
                let that=this;
                if(val==1){
                    //按钮置为失效
                    this.$message({
                        message:'登录成功,正在跳转...',
                        type:'success',
                        center: true,
                        duration:1000,
                        onClose:function(e){
                            that.loading=false;
                            that.$router.push('/index');
                        }
                    });
                }else{
                    let msg='';
                    if(val==0){
                        msg='账号或密码错误，登录失败';
                    }else if(val==2){
                        msg='您已连续输错5次，请1分钟后再试';
                    }else if(val==3){
                        msg='未知错误';
                    }else if(val==4){
                        msg='您的账号已被禁用,请联系管理员';
                    }else{
                        return;
                    }
                    this.$message({
                        message:msg,
                        type:'error',
                        center: true,
                        duration:2000,
                        onClose:function(e){
                            that.loading=false;
                            that.button_name='登录';
                            //登录失败提示之后将code改为初始值-1，不然watch监测不到变化
                            that.$store.commit('setLoginStatus',-1);
                        }
                    });
                }
            }
        }
    }
</script>

<style>
@import url('../../../sass/css/login.css');

</style>
