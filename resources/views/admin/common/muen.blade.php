<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="nav-close">
		<i class="fa fa-times-circle"></i>
	</div>
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			<li class="nav-header">
				<div class="dropdown profile-element">
					<span><img alt="image" class="img-circle top_img"
						style="height: 64px; width: 64px" src="{{$headimgurl}}" /></span>
					<a data-toggle="dropdown" class="dropdown-toggle" href="#"> <span
						class="clear"> <span class="block m-t-xs"><strong
								class="font-bold">{{$realname}}</strong></span> <span
							class="text-muted text-xs block">个人操作<b class="caret"></b></span>
					</span>
					</a>
					<ul class="dropdown-menu animated fadeInRight m-t-xs">
						<li><a href="javascript:adv()">修改头像</a></li>
						<li><a href="javascript:savepwd()">修改密码</a></li>
						<li><a class="J_menuItem" href="javascript:;">联系我们</a></li>
						<li><a class="J_menuItem" href="javascript:;">信箱</a></li>
						<li class="divider"></li>
						<li><a href="{{route('admin_logout')}}">安全退出</a></li>
					</ul>
				</div>
				<div class="logo-element">Menu</div>
			</li> 
			@foreach($menu_list as $key=>$item)
			<li><a href="#"> <i class="{{$item->icon_class}}"></i> <span class="nav-label">{{$item->module_name}}</span>
					<span class="fa arrow"></span>
			</a>
			<ul class="nav nav-second-level">
				@if(!empty($item->child_items))
    				 @foreach($item->child_items as $child)
    					<li>
    						 <a class="J_menuItem" href="{{$child->url}}" data-index="0">{{$child->module_name}}</a>
    					</li>
    				@endforeach
    			@endif
            </ul>
			</li> 
			@endforeach
		</ul>
	</div>
</nav>
<!--修改头像框-->
<div id="adv" style="display: none">
	<div class="col-md-12" style="margin-top: 10px;">
		<div class="form-group">
			<label class="col-sm-3 control-label">头像：</label>
			<div class="col-sm-9" id="img">
				<img class="top_img" src="{{$headimgurl}}"
					style="height: 64px; width: 64px">
			</div>
		</div>
	</div>
	<div class="col-md-12" style="margin-top: 10px;">
		<div class="form-group">
			<label class="col-sm-3 control-label">选择文件：</label>
			<div class="col-sm-9">
				<input type="file" onchange="up(this)" class="form-control">
			</div>
		</div>
	</div>
</div>
<!--end-->
<!--修改密码框-->
<div id="pwd" style="display: none">
	<form onsubmit=" return sava_pwd_do(this)">
		{{csrf_field()}}
		<div class="col-md-12" style="margin-top: 10px">
			<div class="form-group">
				<label class="col-sm-3 control-label">旧密码：</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" name="old_password"
						placeholder="请输入旧密码">
				</div>
			</div>
		</div>
		<div class="col-md-12" style="margin-top: 10px">
			<div class="form-group">
				<label class="col-sm-3 control-label">新密码：</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" name="new_password"
						placeholder="请输入新密码">
				</div>
			</div>
		</div>
		<div class="col-md-12" style="margin-top: 10px">
			<div class="form-group">
				<div class="col-sm-9 col-sm-offset-3">
					<button class="btn btn-primary" type="submit">保存内容</button>
					<button onclick="layer.close(layer.index)" class="btn btn-white"
						type="submit">取消</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!--end-->
<script type="text/javascript">
function adv(){
    layer.open({
      type: 1,
      title:"修改头像",
      skin: 'layui-layer-rim', //加上边框
      area: ['420px', '240px'], //宽高
      content: $("#adv"),
    });
}
var xhr;
function createXMLHttpRequest()
{
    if(window.ActiveXObject)
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if(window.XMLHttpRequest)
    {
        xhr = new XMLHttpRequest();
    }
}
function UpladFile(my)
{
    var fileObj = my.files[0];//document.getElementById("file").files[0];
    var FileController = "{{route('admin_upload_headimg')}}"; //请求地址
    var form = new FormData();
    form.append("myfile", fileObj);
    createXMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4){
            if (xhr.status == 200 || xhr.status == 0){
                var response_json=xhr.responseText;
                var result=JSON.parse(response_json);
                layer.msg(result.errmsg)
                if(result.data!=''){
                	$(".top_img").attr("src",result['src'])
                }
            }
      };
    };
    xhr.open("post", FileController, true);
    xhr.send(form);
}
function up(my){
    //document.getElementById('textfield').value=my.value
    UpladFile(my);
}
function savepwd(){
    layer.open({
      type: 1,
      title:"修改密码",
      skin: 'layui-layer-rim', //加上边框
      area: ['500px', '300px'], //宽高
      content: $("#pwd"),
    });
}
function sava_pwd_do(obj){
    var data=$(obj).serialize();
    $.post("{{route('admin_save_password')}}",data,function(e){
        layer.msg(e.errmsg);
        if(e.errno==200){
            setTimeout(function(){
            	layer.closeAll();
            },1000)
        }
    })
    return false;
}
</script>