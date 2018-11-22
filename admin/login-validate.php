<?php 
$page = 'login';
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
   <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
  <link rel="stylesheet" href="/static/assets/css/admin.css">
</head>
<body>
    <div class="login">
	    <form class="login-wrap" id="form">
	      <img class="avatar" src="/static/assets/img/default.png">
	      <!-- 有错误信息时展示 -->
	      <div id="errorBox" class="alert alert-danger" style="display: none;">
	        <strong>错误！用户名或密码错误！</strong> 
	      </div>
	      <div class="form-group"> 
	        <label for="email" class="sr-only">邮箱</label>
	        <input id="email" name="email" type="text" class="form-control" placeholder="邮箱" autofocus>
	      </div>
	      <div class="form-group">
	        <label for="password" class="sr-only">密码</label>
	        <input id="password" name="password" type="password" class="form-control" placeholder="密码">
	      </div>
	 <!--      <input type="button" class="btn btn-primary btn-block" value="登 录" id="login">
 -->       <button class="btn btn-primary btn-block" id="login" >登录</button>
	    </form>
  	</div>
 <script src="/static/assets/vendors/jquery/jquery.js"></script>
 <script src="/static/assets/vendors/validate/jquery.validate.js"></script>
 <script>
     // 1.  获取元素
     $form = $('#form');
     $email = $('#email');
     $password = $('#password');
     $login = $('#login');
     $errorBox = $('#errorBox');


     // 3.自定义匹配规则
     $.validator.addMethod('psw',function(value,element,params){
        return this.optional(element) || /^[0-9a-zA-Z]{6,10}$/.test(value);
     },'北风那个吹,你那个凌乱');

     // 2.使用validate  rules匹配规则,messages错误提示信息。
     $form.validate({
      rules : {
        email :{
          required : true,
          maxlength : 15,
          minlength : 6,
          email : true
        },
        password : {
          required : true,
          //密码框自定义检测规则
          pws :  true
        }
      },
      messages : {
        email : {
          required : '必填信息',
          maxlength : '最少6位'
        },
        password : {
          required : '密码必须填写',
          pws : '密码格式不对'
        }
      },
      submitHandler : function () {
        console.log('113');
      }
     });
 </script>
</body>
</html>
