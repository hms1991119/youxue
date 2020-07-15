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
                                <label class="col-sm-3 control-label">banner名称：</label>
                                <div class="col-sm-5">
                                    <input id="banner_name" name="banner_name" value="{{isset($info->banner_name)?$info->banner_name:''}}" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">点击链接：</label>
                                <div class="col-sm-5">
                                    <input id="click_url" name="click_url" value="{{isset($info->click_url)?$info->click_url:''}}" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">上传：</label>
                                <div class="col-sm-5">
                                        <button class="btn btn-success btn-sm"  type="button"><i class="fa fa-upload"></i>上传文件</button>
                                        <input type="file" onchange="showPreviewImg(this,'preview_img')" id="pic" name="pic" style="position: absolute;top:5px; width: 105px;height: 40px;opacity: 0">
                                        <img src="{{isset($info->src)?$info->src:''}}" id="preview_img"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">是否隐藏：</label>
                                <div class="col-sm-5">
                                   <input type="checkbox" name="enabled" id="enabled" value="" @if(isset($info->enabled) && $info->enabled==1) selected @endif>
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
        banner_name:{
            required:true,
        },
        pic:{
            required:true,
        },  
    },
    onkeyup:false,
    focusCleanup:true,
    success:"valid",
    submitHandler:function(form){
        //这里用formData
        var fd=new FormData();
        var banner_name=$('#banner_name').val();
        var click_url=$('#click_url').val();
        var pic=document.getElementById('pic').files[0];
        var enabled=$('#enabled').val();
        fd.append('banner_name',banner_name);
        fd.append('click_url',click_url);
        fd.append('pic',pic);
        fd.append('enabled',enabled);
        createXMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4){
                if (xhr.status == 200 || xhr.status == 0){
                    console.log(xhr.responseText);return;
                    var response_json=xhr.responseText;
                    var result=JSON.parse(response_json);
                    layer.msg(result.errmsg)
                    if(result.data!=''){
                    	$(".top_img").attr("src",result['src'])
                    }
                }
          };
        };
        xhr.open("post",'/admin/banner_add',true);
        xhr.send(fd); 
        /* $.post("/admin/banner_add",data,function(e){
        	layer.msg(e.errmsg)
            if(e.errno==200){
                setTimeout(function(){
                	window.parent.refresh();
                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    parent.layer.close(index); //再执行关闭 
                },1000)
            }
        }) */
 }
});
</script>
</html>
