<!DOCTYPE html>
<html>
@include('admin.common.head')
<head>
  <meta charset="UTF-8">
  <!-- import CSS -->
  <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
</head>
<body>
  <div id="app">
    <el-button @click="visible = true">Button</el-button>
    <el-dialog :visible.sync="visible" title="Hello world">
      <p>Try Element</p>
    </el-dialog>
  </div>
  
  
  <!-- v-bind -->
  <div id="app_2">
  	 <span v-bind:title="message">
    鼠标悬停几秒钟查看此处动态绑定的提示信息！
  	</span>
  </div>
  
  <!-- 绑定事件 与laravel中blade模板冲突就加@ -->
  <div id="app-5">
  <p>@{{ message }}</p>
  	<button v-on:click="reverseMessage">反转消息</button>
  </div>
  
  <!-- v-model -->
  <div id="app-6">
     <p>@{{ message }}</p>
     <input v-model="message">
  </div>
  
  <!-- 测试v-for v-if等 -->
  <div id="app-8" v-if="is_male">
  	 <ul>
  	 	<li v-for="item in banks">@{{item}}</li>
  	 </ul>
  </div>
  
  <!-- 组件模板 -->
  <div id="app-7">
     <todo-item></todo-item>
  </div>

@include('admin.common.foot')
</body>
  <!-- import JavaScript -->
  <script src="https://unpkg.com/element-ui/lib/index.js"></script>
  <script>
    var app=new Vue({
      el: '#app',
      data: function() {
        return { visible: false }
      }
    })

    //绑定弹出文字
    var app2 = new Vue({
  	  el: '#app_2',
  	  data: {
  	    message: '页面加载于 ' + new Date().toLocaleString()
  	  }
  	})

  	//绑定事件
    var app5 = new Vue({
  	  el: '#app-5',
  	  data: {
  	    message: 'Hello Vue.js!'
  	  },
  	  methods: {
  	    reverseMessage: function () {
  	      this.message = this.message.split('').reverse().join('')
  	    }
  	  }
  	})

  	//v-model
    var app6 = new Vue({
  	  el: '#app-6',
  	  data: {
  	    message: 'Hello Vue!'
  	  }
  	})

  	//v-for v-if
  	var app8 =new Vue({
		el : '#app-8',
		data : {
			is_male : true,
			banks : ['中国银行','中国工商银行','中国建设银行','中国农业银行']
		}
  	})

  	//创建一个组件
    Vue.component('todo-item', {
  	  template: '<li>这是个待办项</li>'
  	})
	
	var app7 = new Vue({
		el : '#app-7',
		data : {}
	})
  	

  </script>
</html>
