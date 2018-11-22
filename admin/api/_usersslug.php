<?php 
require_once '../../config.php';
$slug = $_GET['slug'];
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql = "select id from users where slug = '$slug'";
$query = mysqli_query($link,$sql);
$result = mysqli_fetch_all($query,MYSQLI_ASSOC);
if(count($result) === 1) {
	echo '不能用';
} else {
	echo '可以使用';
}

 ?>