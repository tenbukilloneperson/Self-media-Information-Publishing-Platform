<?php 
// 检测新添加的名称是否存在

// 1.引入配置文件
require_once '../../config.php';
// 2.接收参数
$name = $_GET['name'];
// 3.连接数据库检测名称是否存在
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql = "select id from categories where name = '$name'";
$query = mysqli_query($link,$sql);
$result =mysqli_fetch_all($query);
if(count($result) === 0) {
	echo '不存在';
 } else {
 	echo '已存在';
 }
