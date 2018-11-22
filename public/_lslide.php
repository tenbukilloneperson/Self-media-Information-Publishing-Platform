<?php 
// 连接数据库、数据查询，动态创建
$sql = 'select * from categories where id > 1';
$query = mysqli_query($link,$sql);
$slide_result = mysqli_fetch_all($query,MYSQLI_ASSOC);
 ?>

    <div class="header">
      <h1 class="logo"><a href="index.html"><img src="/static/assets/img/logo.png" alt=""></a></h1>
      <ul class="nav">
      <!-- 遍历数据 -->
      <?php foreach($slide_result as $val) {?>
        <!-- 将数据渲染到页面 -->
      <li>
          <a href="/list.php?id=<?php echo $val['id']; ?>">
              <i class="fa <?php echo $val['classname']; ?>" ></i>
              <?php echo $val['name']; ?>
          </a>
      </li>
      <?php }?>
  <!--       <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事123</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li> -->
      </ul>
      <div class="search">
        <form>
          <input type="text" class="keys" placeholder="输入关键字">
          <input type="submit" class="btn" value="搜索">
        </form>
      </div>
      <div class="slink">
        <a href="javascript:;">链接01</a> | <a href="javascript:;">链接02</a>
      </div>
    </div>