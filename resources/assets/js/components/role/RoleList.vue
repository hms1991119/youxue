<template>
    <div>
        <el-card class="box-card" shadow="never">
            <!--导航栏-->
            <el-breadcrumb separator-class="el-icon-arrow-right">
                <el-breadcrumb-item>系统设置</el-breadcrumb-item>
                <el-breadcrumb-item>角色列表</el-breadcrumb-item>
            </el-breadcrumb>
            <!--分割线-->
            <div class="yx_line"></div>
            <!--添加按钮  条件搜索区 总计24栏-->
            <el-row :gutter="20" class="yx_el_row">
                <el-col :span="4">
                    <el-button type="primary" plain @click="add">添加</el-button>
                </el-col>
            </el-row>
            <el-table class="yx_table" border :data="list">
                <el-table-column prop="index" label="序号" width="100">
                </el-table-column>
                <el-table-column prop="name" label="角色名称" width="180">
                </el-table-column>
                <el-table-column prop="create_date" label="创建日期" width="180">
                </el-table-column>
                <el-table-column prop="enabled" label="状态" width="100">
                </el-table-column>
                <el-table-column  label="操作">
                    <template slot-scope="scope">
                        <el-tooltip class="item" effect="dark" content="编辑" placement="bottom-start">
                            <el-button type="primary" icon="el-icon-edit" @click="edit('/roleedit',scope.row.id,2)" circle></el-button>
                        </el-tooltip>
                        <el-tooltip class="item" effect="dark" content="查看"  placement="bottom-start">
                            <el-button type="info" icon="el-icon-notebook-1" @click="edit('/roleedit',scope.row.id,0)" circle></el-button>
                        </el-tooltip>
                        <el-tooltip class="item" effect="dark" content="删除" placement="bottom-start">
                            <el-button type="warning" icon="el-icon-delete" @click="del(scope.row.id)" circle></el-button>
                        </el-tooltip>
                    </template>
                </el-table-column>
            </el-table>
            <el-pagination class="yx_page"
                           background
                           @current-change="handle_current_change"
                           @size-change="handle_size_change"
                           :page-sizes="page_sizes"
                           :page-size="page_size"
                           layout="prev, pager, next,sizes, total"
                           :total="total_count">
            </el-pagination>
        </el-card>
    </div>
</template>

<script>
    export default {
        name: 'RoleList',
        inject:['reload'],
        data() {
            return {
                current_page:0,
                page_size:20
            }
        },
        methods: {
            //请求列表
            getList(){
                var send_data={
                    api_token:this.$store.getters.getSessionId,
                    current_page:this.current_page,
                    page_size:this.page_size
                }
                this.$store.dispatch('loadRoleList',send_data);
            },
            add(){
                this.$router.push('/roleedit/-1/1');
            },
            edit(url,id,edit_type){
                this.$router.push(url+'/'+id+'/'+edit_type);
            },
            del(id){
                let that=this;
                //弹框提示
                this.$confirm('确认删除, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then((e) => {
                    var send_data={
                        api_token : that.$store.getters.getSessionId,
                        id:id
                    };
                    that.$store.dispatch('delRole',send_data);
                })
            },
            //跳转页
            handle_current_change(current_page){
                //当前页码数
                this.current_page=current_page;
                this.getList();
            },
            //修改条数
            handle_size_change(page_size){
                this.page_size=page_size;
                this.getList();
            }
        },
        created() {
            this.getList();
        },
        computed:{
            list(){
                return this.$store.getters.getRoleList;
            },
            total_count(){
                return this.$store.getters.getRoleTotalCount;
            },
            page_sizes(){
                return this.$store.state.page_sizes;
            },
            delRoleStatus(){
                return this.$store.getters.getDelRoleStatus;
            }
        },
        watch:{
            delRoleStatus(val){
                let that=this;
                if(val==1){
                    this.$message({
                        message:'删除成功',
                        type:'success',
                        duration:1000,
                        onClose:function(e){
                            that.$store.commit('setDelRoleStatus',-1);
                            that.reload();
                        }
                    });
                }else if(val==0){
                    this.$message({
                        message:'删除失败',
                        type:'error',
                        duration:2000,
                        onClose:function(e){
                            that.reload();
                        }
                    });
                    //初始化状态
                    that.$store.commit('setDelRoleStatus',-1);
                }
            }
        }
    }
</script>

<style>
    @import url('../../../sass/css/table.css');
</style>
