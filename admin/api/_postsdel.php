<?php 
	// ----------------删除功能的处理操作--------------------
	// 引入配置文件
	require_once '../../config.php';

	// 1.接收参数,用来作为删除数据的条件
	$id = $_GET['id'];

	// 2.进行数据库操作
	$link = mysqli_connect(AD,UN,PWD,NAME);
	// where id in (1,2,3); 删除多个也可以使用
	$sql = "delete from posts where id in ($id)";
	$query = mysqli_query($link,$sql);

	// 3.检测受影响行数
	if(mysqli_affected_rows($link) > 0) {
		// 方便接口化数据处理
		$result = '删除成功';
	} else {
		$result = '删除失败';
	};

	// 4.--为了删除时对分页功能造成影响,需要获取数据总条数并进行响应
	$where = ' where 1 = 1 '; // 避免出现错误

	// 分类参数的检测
	if(isset($_GET['category']) && $_GET['category'] !== 'all') {
		$where .= ' and posts.category_id ='.$_['category'];
	}

	//状态参数的检测 
	if(isset($_['status']) && $_GET['status'] !== 'all') {
		$where .= " and posts.status = '{$_GET['status']}'";
	}

	$sql = "select count(1) as num from posts $where";
	$query = mysqli_query($link,$sql);
	// [0=>['num'=>1003]];
	$count = mysqli_fetch_all($query,MYSQLI_ASSOC)[0]['num'];

	// 进行数据接口化操作,响应数据条数和操作结果
	echo '{"count":' . $count  .',"result":"' . $result . '"}';
