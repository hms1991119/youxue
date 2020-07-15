<!DOCTYPE html>
<html>
@include('admin.common.head')

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form class="form-horizontal m-t" id="signupForm">
                           <div class="form-group">
                                <label class="col-sm-3 control-label">账号：</label>
                                <div class="col-sm-5">
                                    <input id="username" name="username" value="{{isset($info->username)?$info->username:''}}" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">姓名：</label>
                                <div class="col-sm-5">
                                    <input id="realname" name="realname" value="{{isset($info->realname)?$info->realname:''}}" class="form-control" type="text">
                                </div>
                            </div>
                            @if(empty($info))
                            <div class="form-group">
                                <label class="col-sm-3 control-label">密码：</label>
                                <div class="col-sm-5">
                                    <input id="password" name="password"  class="form-control" type="text">
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="col-sm-3 control-label">角色：</label>
                                <div class="col-sm-5">
                                        <select class="chosen-select" name="role">
                                            @if(!empty($role_list))
                                                @foreach($role_list as $item)
                                                   <option value="{{$item->id}}" {{(isset($info->role) && $item->id==$info->role)?'selected':''}}>{{$item->role_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">是否禁用：</label>
                                <div class="col-sm-5">
                                   <input type="checkbox" name="enabled" value="" @if(isset($info->enabled) && $info->enabled==1) selected @endif>
                                </div>
                            </div>
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
</body>
<script type="text/javascript">
$("#signupForm").validate({
    rules:{
        password:{
            required:true,
        },
        username:{
            required:true,
        },  
    },
    onkeyup:false,
    focusCleanup:true,
    success:"valid",
    submitHandler:function(form){
        var data=$(form).serialize();   
        $.post("/admin/user_add",data,function(e){
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
</script>
</html>
