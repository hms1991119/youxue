<template>
    <div>
        <el-card class="box-card" shadow="never">
            <!--导航栏-->
            <el-page-header @back="back" :content="content">
            </el-page-header>
            <el-form ref="role_form" class="edit-el-form"  :model="role_form" :rules="rules" label-width="80px">
                <el-form-item label="角色名称" prop="name">
                    <el-input v-model="role_form.name" value="123" required></el-input>
                </el-form-item>
                <el-form-item label="状态">
                    <el-radio-group v-model="role_form.enabled">
                        <el-radio border label="0">禁用</el-radio>
                        <el-radio border label="1">正常</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="权限">
                <el-tree ref="role_tree"
                        :data="menulist"
                        show-checkbox
                        default-expand-all
                        :default-checked-keys="checked_keys"
                        node-key="id"
                        :props="defaultProps">
                </el-tree>
                </el-form-item>
                <!--查看不展示按钮-->
                <el-form-item v-if="edit_type!=0">
                    <el-button type="primary" @click="submitForm('role_form')" :loading="loading">{{button_name}}</el-button>
                    <el-button @click="back">取消</el-button>
                </el-form-item>
            </el-form>
        </el-card>

    </div>
</template>

<script>
    export default {
        name:'RoleEdit',
        data() {
            return {
                role_form: {
                    name: '',
                    enabled: '1',
                },
                //校验规则
                rules:{
                    name: [
                        { required:true , message:'请输入角色名称',trigger:'blur' }
                    ]
                },
                //树形图默认属性
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                //加载组件
                loading: false,
                button_name:'立即提交',
                checked_keys : [],
                content:'角色添加'
            }
        },
        methods: {
            submitForm(formName){
                //获取树状图选中id数组
                var selectIds=this.$refs['role_tree'].getCheckedKeys();
                var selectIds_str=JSON.stringify(selectIds);
                let that = this;
                    this.$refs[formName].validate((valid) => {
                            if (valid) {
                                this.loading=true;
                                this.button_name='正在提交';
                                var send_data={
                                    api_token:this.$store.getters.getSessionId,
                                    name:this.role_form.name,
                                    enabled:this.role_form.enabled,
                                    power_str:selectIds_str
                                };
                                if(this.id!=-1){
                                    send_data.id=this.id;
                                }
                                this.$store.dispatch('editRole',send_data);
                            }else{
                                return false;
                            }
                    })
            },
            back(){
                this.$router.go(-1);
            }
        },
        created(){
            this.$store.dispatch('loadAllMenuList');
            //查询记录
            if(this.id!=-1){
                var send_data={
                    api_token:this.$store.getters.getSessionId,
                    id:this.id
                }
                this.$store.dispatch('loadRoleInfo',send_data);
            }
            //修改标题
            if(this.edit_type==1){
                this.content='角色添加';
            }else if(this.edit_type==0){
                this.content='角色详情';
            }else if(this.edit_type==2){
                this.content='角色编辑';
            }
        },
        computed:{
            menulist(){
                return this.$store.getters.getAllMenuList;
            },
            editRoleStatus(){
                return this.$store.getters.getEditRoleStatus;
            },
            roleinfo(){
                return this.$store.getters.getRoleInfo;
            },
            id(){
                return this.$route.params.id;
            },
            //是否可编辑
            edit_type(){
                return this.$route.params.edit_type;
            }
        },
        watch:{
            editRoleStatus(val){
                let that=this;
                if(val==1){
                    //按钮置为失效
                    this.$message({
                        message:this.content+'成功',
                        type:'success',
                        duration:1000,
                        onClose:function(e){
                            that.loading=false;
                            that.$store.commit('setEditRoleStatus',-1);
                            that.$router.push('/rolelist');
                        }
                    });
                }else{
                    this.$message({
                        message:this.content+'失败',
                        type:'error',
                        duration:2000
                    });
                    that.loading=false;
                    that.button_name='立即提交';
                    //初始化状态
                    that.$store.commit('setEditRoleStatus',-1);
                }
            },
            //加载到数据之后
            roleinfo(val){
                this.role_form.name=val.name;
                this.role_form.enabled=val.enabled.toString();
                this.checked_keys=val.power_str;
            }
        }
    }
</script>

<style>
    .edit-el-form{
        margin-top:30px;
    }
</style>
