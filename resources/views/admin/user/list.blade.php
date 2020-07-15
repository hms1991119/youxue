<!DOCTYPE html>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/table_bootstrap.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:20:03 GMT -->
@include('admin.common.head')

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<!-- 导航 -->
				<h5>系统设置-》用户管理</h5>
			</div>
			<div class="ibox-content">
				<div class="col-sm-2 text-left">
					<button data-url="/admin/user_add" data-content="添加"
						onclick="edit(this)" type="button" class="btn  btn-success">添加</button>
				</div>
				<div class="col-sm-10 text-right">
					<form role="form" class="form-inline" id="form"
						data-url="/admin/userlist">
						<div class="form-group">
							<label for="exampleInputEmail2" class="sr-only">用户名</label> <input
								type="text" name="username" placeholder="请输入用户名"
								id="exampleInputEmail2" class="form-control">
						</div>
						<button type="button" style="margin-top: 5px"
							onclick="refresh('form')" class="btn btn-outline btn-success ">查询</button>
					</form>
				</div>
				<div class="row row-lg">
					<div class="col-sm-12">
						<!-- Example Toolbar -->
						<div class="example-wrap">
							<div class="example">
								<table id="table"></table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
@include('admin.common.foot')
<script type="text/javascript">
  $(function(){
    var array=[
    	{field:"index",title:"序号"},
    	{field:"realname",title:"姓名"},
            {field:"username",title:"用户名"},
            {field:"addtime",title:"添加日期"},
            {field:"role_name",title:"角色"},
            {field:"enabled_name",title:"状态"}
           ];
    ajax_table('/admin/userlist',array);
  })
  
  function operateFormatter(value, row, index){
        //所有的字段都在row这里面
        var array=new Array();
        if(row['enabled']==0){
           array.push('<button type="button"  data-content="禁用" onclick="changeStatus('+row["id"]+','+'1'+')" class="btn btn-primary btn-sm">禁用</button>');
        }else{
           array.push('<button type="button"  data-content="启用" onclick="changeStatus('+row["id"]+','+'0'+')" class="btn btn-primary btn-sm">启用</button>');
        }
        array.push('<button type="button"  data-url="/admin/user_add?id='+row["id"]+'" data-content="修改" onclick="edit(this)" class="btn btn-primary btn-sm">修改</button>');
        array.push('<button type="button"  data-url="/admin/user_del?id='+row["id"]+'" onclick="del(this)" class="btn btn-sm btn-danger">删除</button>')
        return array.join(' ');
   }
   
   function changeStatus(id,status){
      layer.confirm("你确定要进行此操作吗",function(){
        $.post("/admin/change_user_status",{id:id,status:status},function(e){
        	layer.msg(e.errmsg);
            if(e.errno==200){
              setTimeout(function(){
            	  layer.closeAll();
                  refresh();
              },1000)
            }
        })
      })
   }
</script>
</html>
