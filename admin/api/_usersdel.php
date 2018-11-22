<?php 
require_once '../../config.php';
$id = $_GET['id'];
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql = "delete from users where id  in ($id)";
$query = mysqli_query($link,$sql);
if(mysqli_affected_rows($link) > 0) {
	echo '删除成功';
} else {
	echo '删除失败';
}

 ?>