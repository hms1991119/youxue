<!DOCTYPE html>
<html>
@include('admin.common.head')

<link rel="stylesheet" href="/js/plugins/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form class="form-horizontal m-t" id="signupForm">
                           <div class="form-group">
                                <label class="col-sm-3 control-label">角色名称：</label>
                                <div class="col-sm-5">
                                    <input id="role_name" name="role_name" value="{{isset($info->role_name)?$info->role_name:''}}" class="form-control" type="text">
                                </div>
                            </div>
                            
                            <!-- 这里引入一个ztree -->
                            <div class="form-group">
								<label class="col-sm-3 control-label">权限：</label>
								<div class="col-sm-8">
									 <ul id="treeDemo" class="ztree"></ul>
								</div>
							</div>
                            <input type="hidden" name="menus" id="menus" value=""/>
							<input type="hidden" name="id" value="{{isset($info->id)?$info->id:''}}">
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <button class="btn btn-primary" type="submit">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('admin.common.foot')
<script type="text/javascript" src="/js/plugins/ztree/js/jquery.ztree.all.js"></script>
</body>
<script type="text/javascript">
$("#signupForm").validate({
    rules:{
        role_name:{
            required:true,
        },
    },
    onkeyup:false,
    focusCleanup:true,
    success:"valid",
    submitHandler:function(form){
        var checked_nodes=zTreeObj.getCheckedNodes(true);
        var checked_length=checked_nodes.length;
        var menus='';
        if(checked_length>0){
			for(var i=0;i<checked_length;i++){
				menus+=checked_nodes[i]['id']+',';
			}
        }
        $('#menus').val(menus);
        var data=$(form).serialize();
        $.post("/admin/role_add",data,function(e){
        	layer.msg(e.errmsg)
            if(e.errno==200){
                setTimeout(function(){
                	window.parent.refresh();
                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    parent.layer.close(index); //再执行关闭 
                },1000)
            }
        })
 }
});

var zTreeObj;
//zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
var setting = {
  check: {  
			enable: true, //显示复选框  
			chkStyle: "checkbox",
			chkboxType: { "Y": "ps", "N": "ps" },
			nocheckInherit:true
		}, 
  view: {
      showIcon: false
  },
		data: {
			simpleData: {
				enable:true,	
				idKey: "id",
				pIdKey: "pId",
				rootPId: ""
			}
		}, 
};
//zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）  1->277

var zNodes = [
		@foreach($menu_list as $item)
		  {id:"{{$item->id}}",pId:"{{$item->pid}}",name:"{{$item->module_name}}",open:true,checked:{{(isset($item->checked))?1:0}} },
		@endforeach
];
$(document).ready(function(){
    zTreeObj = $.fn.zTree.init($(".ztree"), setting, zNodes);
 });
</script>
</html>
