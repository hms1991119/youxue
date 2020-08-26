<template>
    <div>
        <el-card class="box-card" shadow="never">
            <!--导航栏-->
            <el-page-header @back="back" :content="content">
            </el-page-header>
            <!--加入内容 日期、单选、多选、富文本、tree，配合校验等-->
            <el-form ref="form" :model="form" class="edit-el-form" :rules="rules" label-width="80px">
                <el-form-item label="账号" prop="username">
                    <el-input v-model="form.username"></el-input>
                </el-form-item>
                <el-form-item v-if="edit_type==1" label="密码" prop="password">
                    <el-input v-model="form.password"></el-input>
                </el-form-item>
                <el-form-item v-if="edit_type==2" label="新密码" prop="new_password">
                    <el-input v-model="form.new_password" placeholder="注意：如无需修改密码此项不要填写！！！"></el-input>
                </el-form-item>
                <el-form-item label="姓名" prop="realname">
                    <el-input v-model="form.realname"></el-input>
                </el-form-item>
                <el-form-item label="手机号" prop="phone">
                    <el-input v-model="form.phone"></el-input>
                </el-form-item>
                <el-form-item label="角色" prop="role">
                    <el-select v-model="form.role" placeholder="请选择角色">
                        <el-option
                                v-for="item in allrolelist"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="状态" prop="enabled">
                    <el-radio-group v-model="form.enabled">
                        <el-radio border label="0">禁用</el-radio>
                        <el-radio border label="1" >正常</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item v-if="edit_type!=0">
                    <el-button type="primary" @click="onSubmit('form')" :loading="loading">{{button_name}}</el-button>
                    <el-button @click="back">取消</el-button>
                </el-form-item>
            </el-form>
        </el-card>

    </div>
</template>

<script>
    export default {
        name:'AccountAdd',
        data() {
            return {
                form: {
                    username: '',
                    password: '',
                    new_password:'',
                    realname: '',
                    role: '',
                    phone: '',
                    enabled: '1',
                },
                rules:{
                    username: [
                        { required:true , message:'请输入账号',trigger:'blur' }
                    ],
                    password: [
                        { required:true , message:'请输入密码',trigger:'blur' }
                    ],
                    realname: [
                        { required:true , message:'请输入姓名',trigger:'blur' }
                    ],
                    role: [
                        { required:true , message:'请选择角色',trigger:'blur' }
                    ],
                    phone: [
                        { min: 10, max: 11, message: '请输入11位手机号', trigger: 'blur' }
                    ]
                },
                content:'用户添加',
                loading:false,
                button_name:'立即提交',
            }
        },
        methods: {
            onSubmit(formName) {
                let that = this;
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                            if(this.form.new_password!=''){
                                this.$confirm('是否确认修改原密码, 是否继续?', '提示', {
                                    confirmButtonText: '确定',
                                    cancelButtonText: '取消',
                                    type: 'warning'
                                }).then((e) => {
                                this.confirmSubmit(this.form.new_password);
                                })
                            }else{
                               this.confirmSubmit('');
                            }
                    }else{
                        return false;
                    }
                })
            },
            confirmSubmit(new_password){
                this.loading=true;
                this.button_name='正在提交';
                var send_data={
                    api_token:this.$store.getters.getSessionId,
                    username:this.form.username,
                    realname:this.form.realname,
                    phone:this.form.phone,
                    role:this.form.role,
                    enabled:this.form.enabled
                };
                //新增就取密码
                if(this.edit_type==1){
                    send_data.password=this.form.password;
                }else if(this.edit_type==2 && new_password!=''){
                    send_data.password=this.form.new_password;
                }
                if(this.id!=-1){
                    send_data.id=this.id;
                }
                this.$store.dispatch('editAccount',send_data);
            },
            back(){
                this.$router.go(-1);
            }
        },
        created(){
            this.$store.dispatch('loadAllRoleList');
            //查询记录
            if(this.id!=-1){
                var send_data={
                    api_token:this.$store.getters.getSessionId,
                    id:this.id
                }
                this.$store.dispatch('loadAccountInfo',send_data);
            }
            //修改标题
            if(this.edit_type==1){
                this.content='用户添加';
            }else if(this.edit_type==0){
                this.content='用户详情';
            }else if(this.edit_type==2){
                this.content='用户编辑';
            }
        },
        computed:{
            id(){
                return this.$route.params.id;
            },
            //是否可编辑
            edit_type(){
                return this.$route.params.edit_type;
            },
            allrolelist(){
                return this.$store.getters.getAllRoleList;
            },
            accountinfo(){
                return this.$store.getters.getAccountInfo;
            },
            editAccountStatus(){
                return this.$store.getters.getEditAccountStatus;
            }
        },
        watch:{
            editAccountStatus(val){
                let that=this;
                if(val==1){
                    //按钮置为失效
                    this.$message({
                        message:this.content+'成功',
                        type:'success',
                        duration:1000,
                        onClose:function(e){
                            that.loading=false;
                            that.$store.commit('setEditAccountStatus',-1);
                            that.$router.push('/accountlist');
                        }
                    });
                }else if(val==0){
                    this.$message({
                        message:this.content+'失败',
                        type:'error',
                        duration:2000
                    });
                    that.loading=false;
                    that.button_name='立即提交';
                    //初始化状态
                    that.$store.commit('setEditAccountStatus',-1);
                }
            },
            //加载到数据之后
            accountinfo(val){
                this.form.username=val.username;
                this.form.password=val.password;
                this.form.realname=val.realname;
                this.form.phone=val.phone;
                this.form.role=val.role;
                this.form.enabled=val.enabled.toString();
            }
        }
    }
</script>

<style>
    .edit-el-form{
        margin-top:30px;
    }
</style>
