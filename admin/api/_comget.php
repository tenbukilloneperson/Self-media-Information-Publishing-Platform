<?php 
require_once '../../config.php';

// 1.分页功能处理 

$limit = 'limit 0,20';
if(isset($_GET['page'])) {
	$page = $_GET['page'];
	$limit = 'limit '. ($page - 1) * 20 . ',20';
};

// 2.数据库操作
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql = "select * from comments $limit";
$query = mysqli_query($link,$sql);
echo mysqli_error($link);
$result = mysqli_fetch_all($query,MYSQLI_ASSOC);

// 3.查询数据总条数


$sql = "select count(1) as num from comments";
$query = mysqli_query($link,$sql);
$count = mysqli_fetch_all($query,MYSQLI_ASSOC)[0]['num'];

// 数据接口话处理

echo '{"result" : '.json_encode($result).',"count" : '.$count.'}';
 ?>