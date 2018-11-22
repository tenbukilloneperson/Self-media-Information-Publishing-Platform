<?php 
// 编辑页面

// 1.引入配置文件
require_once '../../config.php';
// 判断参数是否存在
// if (!isset($_GET['id']) || !isset($_GET['name']) || !isset($_GET['slug'])) {
// 		echo '失败';
// 		return;
// 	}
// 2.接收参数
$id = $_POST['id'];
$name = $_POST['name'];
$slug = $_POST['slug'];
// 3.连接数据表
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql = "update categories set name = '$name',slug = '$slug' where id = $id";
$query = mysqli_query($link,$sql);
if(mysqli_affected_rows($link) === 1) {
	echo '编辑成功';
 } else {
 	echo '编辑失败';
 }
