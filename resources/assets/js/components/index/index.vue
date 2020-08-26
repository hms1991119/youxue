<template>
    <div>
        <el-card class="box-card" shadow="never">
            <!--导航栏-->
            <el-breadcrumb separator-class="el-icon-arrow-right">
                <el-breadcrumb-item>教室管理</el-breadcrumb-item>
                <el-breadcrumb-item>教室列表</el-breadcrumb-item>
            </el-breadcrumb>
            <!--分割线-->
            <div class="yx_line"></div>
            <!--添加按钮  条件搜索区 总计24栏-->
            <el-row :gutter="20" class="yx_el_row">
                <el-col :span="4">
                    <el-button type="primary" plain @click="addUser">添加</el-button>
                </el-col>
                <el-col :span="8" style="text-align: right;">
                    <span>下拉框：</span>
                    <el-select v-model="value" placeholder="请选择">
                        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                        </el-option>
                    </el-select>
                </el-col>
                <el-col :span="8" style="text-align: right;">
                    <span>起始日期：</span>
                    <el-date-picker v-model="value1" type="date" placeholder="选择日期">
                    </el-date-picker>
                </el-col>
                <el-col :span="4" class="search_btn">
                    <el-button round type="primary">查询</el-button>
                </el-col>
            </el-row>
            <el-table class="yx_table" border :data="tableData">
                <el-table-column prop="id" label="序号" width="180">
                </el-table-column>
                <el-table-column prop="date" label="日期" width="180">
                </el-table-column>
                <el-table-column prop="name" label="姓名" width="180">
                </el-table-column>
                <el-table-column prop="address" label="地址" width="240">
                </el-table-column>
                <el-table-column  label="操作">
                    <template slot-scope="scope">
                        <el-tooltip class="item" effect="dark" content="编辑" placement="bottom-start">
                            <el-button type="primary" icon="el-icon-edit" circle></el-button>
                        </el-tooltip>
                        <el-tooltip class="item" effect="dark" content="查看" placement="bottom-start">
                            <el-button type="info" icon="el-icon-notebook-1" circle></el-button>
                        </el-tooltip>
                        <el-tooltip class="item" effect="dark" content="删除" placement="bottom-start">
                            <el-button type="warning" icon="el-icon-delete" circle></el-button>
                        </el-tooltip>
                    </template>
                </el-table-column>
            </el-table>
            <el-pagination class="yx_page"
                           background
                           layout="prev, pager, next"
                           :total="1000">
            </el-pagination>
        </el-card>

    </div>
</template>

<script>
    export default {
        name: 'Index',
        data() {
            return {
                value: '',
                value1: '',
                options: [{
                    value: '选项1',
                    label: '黄金糕'
                }, {
                    value: '选项2',
                    label: '双皮奶'
                }, {
                    value: '选项3',
                    label: '蚵仔煎'
                }, {
                    value: '选项4',
                    label: '龙须面'
                }, {
                    value: '选项5',
                    label: '北京烤鸭'
                }],
                cardStyle: {
                    height: '500px'
                },
                tableData: [{
                    id: 1,
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }, {
                    id: 2,
                    date: '2016-05-04',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1517 弄'
                }, {
                    id: 3,
                    date: '2016-05-01',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1519 弄'
                }, {
                    id: 4,
                    date: '2016-05-03',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1516 弄'
                }, {
                    id: 5,
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }, {
                    id: 6,
                    date: '2016-05-04',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1517 弄'
                }, {
                    id: 7,
                    date: '2016-05-01',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1519 弄'
                }]
            }
        },
        methods: {
            goBack() {
                console.log('go back');
            },
            addUser(){
                this.$router.push('/useradd');
            }
        },
        mounted() {
        }
    }
</script>

<style>
    @import url('../../../sass/css/table.css');
</style>
