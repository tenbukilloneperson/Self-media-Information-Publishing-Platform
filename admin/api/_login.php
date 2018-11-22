<?php 
// 引入配置文件
require_once '../../config.php';

// 1.检测参数
if(!isset($_POST['email']) || !(isset($_POST['password']))) {
	echo '失败';
}
// 2.接收参数
$email = $_POST['email'];
$password = $_POST['password'];

// 3.数据操作
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql  = "select * from users where email = '$email' and password = '$password'";
$query = mysqli_query($link,$sql);
$result = mysqli_fetch_all($query,MYSQLI_ASSOC);
if(count($result) === 1) {
	// 如果响应成功,保存用户的登录状态。让其他页面进行检测
	session_start();
	$_SESSION['login_status'] = 'succsee';
	if(isset($_SESSION['current_path)'])) {
	echo '{"status":"成功","path" : "'. $_SESSION['current_path'].'" }';
	} else {
		echo '{"status" : "成功" ,"path" : ""}';
	}

	// 将后台需要的的信息保存在session中
	// $_SESSION = Array(
	// 	'avatar' => $result[0]['avatar'],
	// 	'slug' => $result[0]['slug']
	// 	);
} else {
	echo '{"status":"失败","path" : ""}';
}















 ?>