<?php 
// 为每一页设置一个标识
$page = 'categories';

// 引入配置文件来检测页面的登录状态
require_once '../config.php';
login_test();

 ?>
 
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <!-- 用于引入导航部分 -->
  <?php include_once './public/_nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="form">
            <h2 id="title">添加新分类目录</h2>
              <!-- 有错误信息时展示 -->
            <div class="alert alert-danger" id="errorBox" style="display:none";>
              <strong>错误！发生XXX错误</strong>
            </div>
            <div class="form-group">
            <!-- 设置隐藏域 传入id -->
             <input type="hidden" name="id">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group edit ">
              <button class="btn btn-primary" type="button" id="add">添加</button>
              <button class="btn btn-primary" type="button" id="edit" style="display:none">编辑</button>
              <button class="btn btn-primary" type="reset" id="reset">重置</button>
              <button class="btn btn-primary" type="button" id="cancel" style="display:none">取消编辑</button>

            </div>
          </form>
        </div>
        
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none; position:absolute; top:-30px;" id="delSome" >批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox" id="selectAll"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody id="tbody">
            <!-- 获取分类列表的数据,渲染到此处位置 -->
           </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
    <?php include_once './public/_slide.php'; ?>
  <!-- <script src="/static/assets/vendors/jquery/jquery.js"></script> -->
  <!-- <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script> -->
  <script src="/static/assets/vendors/require/require.js" data-main ="/static/assets/js/category"></script>
  <script>NProgress.done()</script>
  <script>

  </script>

</body>
</html>