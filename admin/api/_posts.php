<?php 
// --------用来处理页面数据获取和分页筛选操作-------

// 引入配置文件
require_once '../../config.php';

// 1.为了给筛选操作进行部分数据筛选,需要检测指定参数是否存在.

$where  = ' where 1 = 1'; //为了避免出错

// 2检测分类参数
if(isset($_GET['category']) && $_GET['category'] !== 'all') {
	$where .= ' and posts.category_id =' . $_GET['category'];
}

// 3.检测状态参数
if(isset($_GET['status']) && $_GET['status'] !== 'all') {
	$where .= " and posts.status= '{$_GET['status']}'";
}

// 4.分页功能设置 limit n,m 从索引为n的位置获取m条数据
	// 第n页的数据为 limit (页数-1) * 每页的数据数,每页的数据数	

$limit = ' limit 0,20';

// 考虑到可能会出现没currentPage(页数)参数,第一次打开页面. 	设置一个默认值获取第一页数据
if(isset($_GET['page'])) {
	$page = $_GET['page'];
	$limit = ' limit ' . ($page - 1) * 20 .',20';
}

// 5.数据库操作
$link = mysqli_connect(AD,UN,PWD,NAME);
$sql = "select posts.id,posts.title,users.slug,categories.name,	posts.created,posts.status from posts
	inner join categories on posts.category_id = categories.id
	inner join users on posts.user_id = users.id
	$where    
	$limit"; 
	// limit根据页数获取的每一页的数据,$where 是根据筛选条件
$query = mysqli_query($link,$sql);
header('Content-Type:application/json');
$result = json_encode(mysqli_fetch_all($query,MYSQLI_ASSOC));

// 获取数据同时获取数据总条数,方便分页操作

$sql = "select count(1) as num from posts $where";
$query = mysqli_query($link,$sql);
$count = mysqli_fetch_all($query,MYSQLI_ASSOC)[0]['num'];

// 6.进行数据接口化处理,将文章信息和总条数响应
echo '{"count" : ' . $count. ', "result" : ' . $result . '}';