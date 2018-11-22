<?php 
require_once '../../config.php';

$email = $_POST['email'];
$slug = $_POST['slug'];
$nickname = $_POST['nickname'];
$password = $_POST['password'];

$link = mysqli_connect(AD,UN,PWD,NAME);
$sql = "insert into users values(null,'$slug','$email','$password','nickname','',null,'')";
$query = mysqli_query($link,$sql);
if(mysqli_affected_rows($link) === 1) {
	echo '添加成功';
} else {
	echo '添加失败';
}
