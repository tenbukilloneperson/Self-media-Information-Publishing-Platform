<?php 
// 1.引入配置文件
require_once '../../config.php';
// 2.连接数据库获取信息
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql  = 'select id,name,slug from categories';
$query = mysqli_query($link,$sql);
header('Content-type:application/json');
echo json_encode(mysqli_fetch_all($query,MYSQLI_ASSOC));
 ?>