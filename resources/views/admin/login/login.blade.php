<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.zi-han.net/theme/hplus/login_v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:19:49 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title>登录</title>
    <meta name="keywords" content="登录">
    <meta name="description" content="登录">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min93e3.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.min.css') }}" rel="stylesheet">
    
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>
        if(window.top!==window.self){window.top.location=window.location};
    </script>

</head>
@if ($errors->any())  
  <div class="alert alert-danger">     
     <ul>
       @foreach ($errors->all() as $error)                
       <li>{{ $error }}</li>
            @endforeach
      </ul>    
   </div>
 @endif
<body class="signin">
    <div class="signinpanel">
        <div class="row">
            <div class="col-sm-7">
                <div class="signin-info">
                    <div class="logopanel m-b">
                        <h1>优学教育</h1>
                    </div>
                    <div class="m-b"></div>
                    <h4>欢迎使用 <strong>后台管理系统</strong></h4>
                    <ul class="m-b">
                   
                    </ul>
                </div>
            </div>
            <div class="col-sm-5">
                <form method="post" action="{{url()->current()}}">
                	{{csrf_field()}}
                    <h4 class="no-margins">登录：优学教育</h4>
                    <p class="m-t-md">后台登录</p>
                    <input type="text" class="form-control uname" name="username" placeholder="用户名" />
                    <input type="password" class="form-control pword m-b" name="password" placeholder="密码" />
                    <button class="btn btn-success btn-block">登录</button>
                </form>
            </div>
        </div>
        <div class="signup-footer">
            <div class="pull-left">
		优学教育
            </div>
        </div>
    </div>
</body>
<script>
</script>

<!-- Mirrored from www.zi-han.net/theme/hplus/login_v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:19:52 GMT -->
</html>
