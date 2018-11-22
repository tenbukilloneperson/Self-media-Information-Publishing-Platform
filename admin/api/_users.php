<?php 
require_once '../../config.php';
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql = 'select * from users';
$query = mysqli_query($link,$sql);
$result = mysqli_fetch_all($query,MYSQLI_ASSOC);
header('content-Type:application/json');
echo json_encode($result);


 ?>