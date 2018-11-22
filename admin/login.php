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
	      <input type="button" class="btn btn-primary btn-block" value="登 录" id="login">
	    </form>
  	</div>
 <script src="/static/assets/vendors/jquery/jquery.js"></script>
 <script>
// 1.   获取元素
	$errorBox = $('#errorBox');
	$password = $('#password');
	$login = $('#login');
  $email = $('#email');
	$form = $('#form'); 
// 2.   点击的登录按钮时,对表单内容进行验证
  	$login.on('click',function(){
  		// 对用户名进行正则匹配
  		if(!/^[a-zA-Z0-9]{3,10}@\w+\.\w+$/.test($email.val())) {
  		 $errorBox.show().children('strong').text('用户名不符合规则');
  			return;
  		};
  		// 对密码进行正则匹配
  		if(!/^[a-zA-Z0-9]{6,10}$/.test($password.val())) {
  			$errorBox.show().children('strong').text('密码不符合规则');
  			return;
  		}
  		console.log(123);

  		// 通过检测发送请求检测账户密码是否正确
  		$.ajax({
  			type : 'POST',
  			url : '/admin/api/_login.php',
  			data : $form.serialize(),
  			dataType : 'json',
  			success : function(datas) {
  				// 如果成功就跳转页面 失败就进行错误提示
  				console.log(datas);
  				if(datas.status === '成功') {
  					location.href = datas.path ?  datas.path : './index.php';
  				} else {
  					$errorBox.show().find('strong').text('用户名或密码不正确');
  				}
  			}
  		});

  	})

  	// 2.当邮箱和密码输入框获取焦点时，隐藏错误提示框
  	$form.find('input').on('focus',function(){
  		$errorBox.hide();
  	})
 </script>
</body>
</html>
