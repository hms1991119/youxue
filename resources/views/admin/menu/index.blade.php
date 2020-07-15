<!DOCTYPE html>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/table_bootstrap.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:20:03 GMT -->
@include('admin.common.head')

<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<!-- 导航 -->
				<h5>系统设置-》菜单管理</h5>
			</div>
			<div class="ibox-content">
				<div class="col-sm-2 text-left">
					
				</div>
				<div class="col-sm-10 text-right">
					<form role="form" class="form-inline" id="form"
						data-url="/admin/menulist">
						<div class="form-group">
							<label for="exampleInputEmail2" >父级菜单：</label> 
							<select class="form-control" name="pid">
								<option value="0">全部</option>
								@if(!empty($parent_hash))
									@foreach($parent_hash as $key=>$item)
									<option value="{{$key}}">{{$item}}</option>
									@endforeach
								@endif
							</select>
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
    	{field:"module_name",title:"菜单名称"},
    	{field:"parent_name",title:"父级菜单"},
    	{field:"url",title:"url"},
    	{field:"status_name",title:"status_name"},
           ];
    ajax_table('/admin/menulist',array);
  })
  
  function operateFormatter(value, row, index){
        //所有的字段都在row这里面
        var array=new Array();
        //array.push('<button type="button"  data-url="/admin/menu_add?id='+row["id"]+'" data-content="修改" onclick="edit(this)" class="btn btn-primary btn-sm">修改</button>');
        //array.push('<button type="button"  data-url="/admin/menu_del?id='+row["id"]+'" onclick="del(this)" class="btn btn-sm btn-danger">删除</button>')
        return array.join(' ');
   }
</script>
</html>
