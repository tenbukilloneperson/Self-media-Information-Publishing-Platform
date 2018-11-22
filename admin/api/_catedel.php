<?php 
// 删除数据页面(单个删除和批量删除用同一个页面);

// 1.引入配置文件
require_once '../../config.php';

// 2.接收参数
$id = $_GET['id'];

// 3.连接数据库，删除数据
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql  = "delete from categories where id in ($id)";
$query = mysqli_query($link,$sql);
// 批量删除时受影响行数会大于1
if(mysqli_affected_rows($link) > 0) {
	echo '删除成功';
} else {
	echo '删除失败';
}


 ?>