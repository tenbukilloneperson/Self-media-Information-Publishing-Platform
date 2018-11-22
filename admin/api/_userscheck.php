<?php 
require_once '../../config.php';
$email = $_GET['email'];
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql = "select id from users where email = '$email'";
$query = mysqli_query($link,$sql);
$result = mysqli_fetch_all($query,MYSQLI_ASSOC);
if(count($result) === 1) {
	echo 'no';
} else {
	echo 'yes';
}

 ?>