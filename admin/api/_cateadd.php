<?php 
// 根据上传的信息。提交至数据库

// 1.引入配置文件
require_once '../../config.php';
// 判断是否存在参数
// if(!isset($_POST['name'])||!(isset($_POST['slug'])){
// 	echo '添加失败';
// 	return;
// }
// 2.接收参数
$name = $_POST['name'];
$slug = $_POST['slug'];
// 3.连接数据库,上传至数据库
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql = "insert into categories values(null,'$slug','$name',null)";
$query = mysqli_query($link,$sql);
if(mysqli_affected_rows($link) === 1) {
	echo '添加成功';
} else {
	echo '添加失败';
}

 ?>