<?php 
// 引入配置文件
require_once '../../config.php';
// 2.接收参数
$title = $_POST['title'];
$content = $_POST['content'];
$slug = $_POST['slug'];
$category = $_POST['category'];
$created = $_POST['created'];
$status = $_POST['status'];

// 3.对文件进行处理
$name =uniqid() . time() . rand(1000,9999) . strrchr($_FILES['file']['name'],'.');
$path = 'static/uploads'.$name ;
move_uploaded_file($_FILES['file']['tmp_name'], '../../static/uploads/'.$name);

// 4.进行数据库操作
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql = "insert into posts values(null,'$slug','$title','$path','$created','$content',0,0,'$status',1,$category)";
$query = mysqli_query($link,$sql);
if(mysqli_affected_rows($link) === 1) {
	echo '成功';
} else {
	echo '失败';
};

 ?>