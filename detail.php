<?php 
// 引入公共配置，连接数据库
require_once './config.php';
$link = mysqli_connect(AD,UN,PWD,NAME);
// 检测是否有参数，如果有参数就根据参数获取数据渲染到页面
// 否则就跳转到首页
$id = $_GET['id'];
if(isset($id)===false) {
  header('Location:index.php');
};
// 如果有参数，根据参数查询信息
$sql = "select posts.id,posts.title,posts.feature,posts.created,posts.content,posts.views,posts.likes,
        categories.name,users.slug from posts
        inner join categories on posts.category_id = categories.id
        inner join users on posts.user_id = users.id
        where posts.id = $id";
$query = mysqli_query($link,$sql);
$detail_result = mysqli_fetch_all($query,MYSQLI_ASSOC);
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="/static/assets/css/style.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>
    <!-- 左侧侧边栏的公共区域引入 -->
    <?php include_once './public/_lslide.php'; ?>
    <!-- 右侧侧边栏的公共区域引入 -->
    <?php include_once './public/_rslide.php'; ?>
      <div class="content">
    <?php foreach($detail_result as $val): ?>
            <div class="article">
              <div class="breadcrumb">
                <dl>
                  <dt>当前位置：</dt>
                  <dd><a href="javascript:;"><?php echo $val['name']; ?></a></dd>
                  <dd><?php echo $val['title']; ?></dd>
                </dl>
              </div>
              <h2 class="title">
                <a href="javascript:;"><?php echo $val['title']; ?></a>
              </h2>
              <div class="meta">
                <span><?php echo $val['slug']; ?> <?php echo $val['created']; ?></span>
                <span>分类: <a href="javascript:;"><?php echo $val['name']; ?></a></span>
                <span>阅读: (<?php echo $val['views']; ?>)</span>
                <span>评论: (143)</span>
                <p style="font-size: 20px;margin-top: 10px;color:black;line-height:30px;"><?php echo $val['content']; ?></p>
              </div>
      </div>
    <?php endforeach; ?>
      <div class="panel hots">
        <h3>热门推荐</h3>
        <ul>
          <li>
            <a href="javascript:;">
              <img src="/static/uploads/hots_2.jpg" alt="">
              <span>星球大战:原力觉醒视频演示 电影票68</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="/static/uploads/hots_3.jpg" alt="">
              <span>你敢骑吗？全球第一辆全功能3D打印摩托车亮相</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="/static/uploads/hots_4.jpg" alt="">
              <span>又现酒窝夹笔盖新技能 城里人是不让人活了！</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="/static/uploads/hots_5.jpg" alt="">
              <span>实在太邪恶！照亮妹纸绝对领域与私处</span>
            </a>
          </li>
        </ul>
      </div>
    </div>

  <!-- ---------------------------------------------------------------------------------------------------------------- -->
     
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
</body>
</html>
