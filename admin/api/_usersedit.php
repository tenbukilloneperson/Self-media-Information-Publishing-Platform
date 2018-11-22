<?php 
require_once '../../config.php';
$id = $_POST['id'];
$email = $_POST['email'];
$slug = $_POST['slug'];
$nickname = $_POST['nickname'];
$status = $_POST['password'];

$link = mysqli_connect(AD,UN,PWD,NAME);
// 设置多个字段之间用逗号隔开
$sql = "update users set email = '$email', slug = '$slug',nickname= '$nickname' where id = $id";
$query = mysqli_query($link,$sql);
echo mysqli_error($link);
if(mysqli_affected_rows($link) === 1) {
	echo '修改成功';
} else {
	echo '修改失败';
}

 ?>