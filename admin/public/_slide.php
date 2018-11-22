  <!-- 每个引入当前公共区域的页面都声明了一个$page 变量。用于检测当前显示的是哪个页面。从而设置高亮即可 -->
  <div class="aside">
    <div class="profile">
      <img class="avatar" src="/static/uploads/avatar.jpg">
      <h3 class="name">布头儿</h3>
    </div>
    <ul class="nav">
    <!-- 1.设置仪表盘高亮显示 -->
      <li class=" <?php echo $page === 'index' ? 'active' :'';?>">
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <!-- 2.设置文章部分 -->
      <?php 
      // 检测是否是文章的子页面
        $posts_arr = ['posts','post-add','categories'];
        $bool = in_array($page,$posts_arr);
       ?>
      <!-- 设置文章li高亮 -->
      <li class=" <?php echo $bool ? 'active' : '';?>">
      <!-- 设置箭头 -->
        <a href="#menu-posts" class="<?php echo $bool ? '' : 'collapsed'; ?> " data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <!-- 设置ul折叠与否 -->
        <ul id="menu-posts" class="collapse <?php echo $bool ? 'in' : '' ; ?>">
          <li class="<?php echo $page === 'posts' ? 'active' : ''; ?> "><a href="posts.php" >所有文章</a></li>
          <li class="<?php echo $page === 'post-add' ? 'active' : ''; ?> "><a href="post-add.php">写文章</a></li>
          <li class="<?php echo $page === 'categories' ? 'active' : ''; ?> "><a href="categories.php" >分类目录</a></li>
        </ul>
      </li>
      <!-- 3.设置评论部分高亮 -->
      <li class="<?php echo $page === 'comments' ? 'active':''; ?>">
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <!-- 4.设置用户部分高亮 -->
      <li class=" <?php echo $page === 'users' ? 'active':''; ?>">
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <!-- 5.设置部分高亮 -->
      <!-- 5.1 半盘是否是settings页面的子页面-->
      <?php 
        $setting_arr = ['nav-menus','slides','settings'];
        $bool = in_array($page,$setting_arr);
       ?>
       <!-- 5.2 设置li是否高亮-->
      <li class="<?php echo $bool ? 'active' : ''; ?> ">
      <!-- 5.3设置箭头方向 -->
        <a href="#menu-settings" class="collapsed" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
      <!-- 5.4设置ul是否折叠 -->
        <ul id="menu-settings" class="collapse<?php echo $bool ? 'in' : ''; ?>">
        <!-- 5.5设置子页面的li是否高亮 -->
          <li class=" <?php echo $page === 'nav-menus' ? 'active' : '';?>"><a href="nav-menus.php">导航菜单</a></li>
          <li class=" <?php echo $page === 'slides' ? 'active' : '';?>"><a href="slides.php">图片轮播</a></li>
          <li class=" <?php echo $page === 'settings' ? 'active' : '';?>"><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>