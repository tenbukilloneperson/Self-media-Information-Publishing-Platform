<?php 
// 此配置文件用来保存项目中的一些公共的信息。

// 1  用于保存baixiu项目中公共的信息，数据库的信息
define('AD','127.0.0.1');
define('UN','root');
define('PWD','root');
define('NAME','baixiu');

// 2.用于检测用户状态同时获取用于信息
function login_test() {
	// 首先检测登录状态,如果登录可以继续访问。未登录跳转到登录页面同时将当前访问页面的路径保存到session中。
	session_start();
	if(!isset($_SESSION['login_status'])) {
		$_SESSION['current_path'] = $_SERVER['PHP_SELF'];
		header('Location:./login.php');
	}
	// 从session中获取用户的头像和slug的信息
	// 为了引入此文件的页面可以访问到session中的信息
	// $global $user_info;
	// $user_info = $_SESSION['user_info'];

	  $GLOBALS['user_info'] = $_SESSION['user_info'];

};
























?>
