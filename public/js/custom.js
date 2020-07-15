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
// $(function(){
// 	$("[data-code]").css("display","none");
// 	//删除方法
// 	//检查权限方法
// 	var rbac_array=$("#rbac").val();
// 	if(rbac_array!="" && rbac_array!=undefined){
// 		rbac_array = rbac_array.split(",");
// 		$(rbac_array).each(function(index){
// 			var url = getURL()+"/admin/Comm/check_auth";
// 			var code=rbac_array[index];
// 			var codes="/"+code+".html";
// 			var obj=$(this);
// 			$.ajax({ 
// 		          type : "post", 
// 		          url : url, 
// 		          data : {code:code}, 
// 		          async : true, 
// 		          success : function(e){ 
// 		          		if(e['code']==100){
// 		          			$("[data-code='"+codes+"']").show(300);
// 		          		}else{
// 		          			$("[data-code='"+codes+"']").remove();
// 		          		}
// 		          } 
// 	        }); 
// 		})
// 	}
// })
//删除
function del(obj){
		var url=$(obj).attr("data-url");
		console.log(url);
		if(url=="" || url==undefined){
			alert("请填写自定义属性data-url");
			return false;
	}
	var index=layer.confirm('你确定要删除吗',function(){
		$.post(url,function(e){
			layer.msg(e.errmsg);
			if(e.errno==200){
				setTimeout(function(){
					layer.close(index);
					refresh();
				},1000);
			}
		})
	})
}
//操作
function action(obj){
	var title=$(obj).attr("data-title");
	var url=$(obj).attr("data-url");
	var index=layer.confirm(title,function(){
		$.post(url,function(e){
			if(e['code']==100){
				layer.close(index);
				refresh();
			}else{
				layer.msg("操作失败");
			}
		})
	})
}
//获取域名
function getURL(){
	return window.location.protocol+"//"+document.domain;
}
var config={".chosen-select":{},
			".chosen-select-deselect":{allow_single_deselect:!0},
			".chosen-select-no-single":{disable_search_threshold:10},
			".chosen-select-no-results":{no_results_text:"Oops, nothing found!"},
			".chosen-select-width":{width:"100%"}
		};
var chosen_len=$(".chosen-select").length
if(chosen_len!=0){
	for(var selector in config){
		$(selector).chosen(config[selector]);
	}
}

/*
* 速度最快， 占空间最多（空间换时间）
*
* 该方法执行的速度比其他任何方法都快， 就是占用的内存大一些。
* 现思路：新建一js对象以及新数组，遍历传入数组时，判断值是否为js对象的键，
* 不是的话给对象新增该键并放入新数组。
* 注意点：判断是否为js对象键时，会自动对传入的键执行“toString()”，
* 不同的键可能会被误认为一样，例如n[val]-- n[1]、n["1"]；
* 解决上述问题还是得调用“indexOf”。*/
function uniq(array){
    var temp = {}, r = [], len = array.length, val, type;
    for (var i = 0; i < len; i++) {
        val = array[i];
        type = typeof val;
        if (!temp[val]) {
            temp[val] = [type];
            r.push(val);
        } else if (temp[val].indexOf(type) < 0) {
            temp[val].push(type);
            r.push(val);
        }
    }
    return r;
}
/*
id
url 后台地址


*/

function ajax_table(url,data){
	var align;
	var html="{ checkbox: true,align: 'center'},";
	if(data.length>1){
		for(len in data){
			if(data[len]['align']==undefined){
				align="center";
			}else{
				align=data[len]['align'];
			}
			html+="{field:'"+data[len]['field']+"',title:'"+data[len]['title']+"',align:'"+align+"'}"+","
		}
	}
	html+="{field: 'op',title: '操作',align: 'center',valign: 'middle',formatter: operateFormatter},";
	html="["+html.substring(0,html.length-1)+"]";
	html=eval('(' + html + ')'); 
	$("#table").bootstrapTable({ // 对应table标签的id
	      url: url+"?ajxj_item=yes", // 获取表格数据的url
	      cache: false, // 设置为 false 禁用 AJAX 数据缓存， 默认为true
	      striped: true,  //表格显示条纹，默认为false
	      pagination: true, // 在表格底部显示分页组件，默认false
	      pageList: [10,20,50,'ALL'], // 设置页面可以显示的数据条数
	      pageSize: 10, // 页面数据条数
	      pageNumber: 1, // 首页页码
	      queryParams: queryParams, //参数  
	      queryParamsType:"limit",//请求服务器时所传的参数
	      sidePagination: 'server', // 设置为服务器端分页
	      sortName: 'id', // 要排序的字段
	      sortOrder: 'desc', // 排序规则
	      columns:html
	})
	function queryParams(params) {  //bootstrapTable自带参数 
		var param = {};
	   	 $('#form').find('[name]').each(function () {
	        var value = $(this).val();
	        if (value != '') {
	            param[$(this).attr('name')] = value;
	        }
	     });
	     param['pageSize'] = params.limit;   //页面大小
  	  	 param['pageNumber'] = params.offset;   //页码
	    return param;  
	}
}
//刷新表格
function refresh(){
  $("#table").bootstrapTable('refresh');
}
//编辑弹框方法
function edit(obj,type){
	var title=$(obj).attr("data-content");
	var url=$(obj).attr("data-url");
	if(type=="" || type==undefined){
		layer.open({
			type: 2,
			title: title,
			area: ['100%', '100%'],
			shade: 0.8,
			closeBtn: 1,
			shadeClose: true,
			content: url,
			maxmin: true,
			scrollbar: false,
		});
	}else{
			location.href=url;
	}
	
}

//onchange显示图片缩略图
function showPreviewImg(obj,id=""){
	var fileObj=obj.files[0];
	var tempUrl=window.URL.createObjectURL(fileObj);
	if(id!=""){
		$('#'+id).attr('src',tempUrl);
	}
}

//type 为2 表示多图上传
function upload(obj,type,id=""){
	var index = layer.load(1, {
		  shade: [0.1,'#fff'] //0.1透明度的白色背景
	});
	 var fileObj = obj.files[0];//document.getElementById("file").files[0];
    //fileObj.aa="123";
    //console.log(fileObj);
    var FileController = '/admin/Comm/upload'; //请求地址
    var form = new FormData();
    var len=obj.files.length
    if(len<=0){
    	layer.msg("未选择图片");
    	layer.close(index);
    	return false;
    }
    for(var i=0;i<=len;i++){
    	form.append("myfile[]", obj.files[i]);
    }
    createXMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4){
            if (xhr.status == 200 || xhr.status == 0){
                layer.close(index);
                var result = xhr.responseText;
                result=eval('(' + result + ')');
           		if(result['code']==100){
           			if(type==2){
           				for(a in result['data']){
           						html='<div class="img_info">'+
	                                   '<span onclick="img_del(this)">x</span>'+
	                                   '<input type="hidden" name="pic[]" value="'+result['data'][a]+'">'+
	                                    '<a  target="_BLANK" href="'+result['data'][a]+'"><img style="width: 50px;height: 50px" src="'+result['data'][a]+'"><a>"'+
                              	  '</div>';
                              	  if(id!=""){
                              	 	 $("#"+id).append(html)
                              	  }else{
                              	  	$("#preview_img_list").append(html)
                              	  }
           				}
           			}else{
           				$(obj).next().val(result['data'][0]);
           				//$("#img_value").val(result['data'][0]);
           				if(id!=""){
           					$("#"+id).html("<a target='_BLANK' href='"+result['data'][0]+"'><img style='width:50px;height:50px' src='"+result['data'][0]+"'></a>");
           				}else{
           					$("#preview_img").html("<a target='_BLANK' href='"+result['data'][0]+"'><img style='width:50px;height:50px' src='"+result['data'][0]+"'></a>");
           				}
           				
           			}
           		}else{
           			layer.msg(result['msg']);
           		}
            }
      };
    };
    xhr.open("post", FileController, true);
    xhr.send(form);
}
//删除图片
function img_del(obj){
 	$(obj).parent().remove();
}
//日期插件
$(function(){
	$(".ldate").each(function(){
			laydate.render({
			  elem: '#'+$(this).attr("id")
			   ,type: 'datetime'
			   ,theme: '#000'
			});
	})
})
$(".area").change(function(){
	var val=$(this).val();
	var id=$(this).attr("data-id");
	var url=$(this).attr("data-url");
	$.post(url,{id:val},function(e){
		var html="<option value=''>请选择</option>";
			for(a in e['data']){
				html+="<option value='"+e['data'][a]['id']+"'>"+e['data'][a]['area_name']+"</option>";
			}
		$("#"+id).html(html);
	})
})

function getItemid(tag,id){
	array=$("#"+tag).bootstrapTable('getOptions');
	var arrays=new Array();
	for(var index in array['data']){
		arrays[index]=array['data'][index][id];
	}
	return arrays.join(",");
}
//表格删除
function tabledel(tag,id){
	$("#"+tag).bootstrapTable('removeByUniqueId', id);
}





