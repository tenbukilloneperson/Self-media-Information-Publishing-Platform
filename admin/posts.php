<?php 
$page = 'posts';
// 引入配置文件来检测页面的登录状态
require_once '../config.php';
login_test();

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline" id="form">
        <!-- 1.分类下拉菜单 -->
          <select name="category" class="form-control input-sm" id="category">
            <option value="all">所有分类</option>
          </select>
          <!-- 2.状态下拉菜单 -->
          <select name="status" class="form-control input-sm">
            <option value="all">所有状态</option>
            <option value="drafted">草稿</option>
            <option value="published">已发布</option>
            <option value="trashed">未发布</option>
          </select>
            <!--3. 发送ajax请求不能使用button  会提交注册筛选按钮 -->
          <input type="button" value="筛选" class="btn btn-default btn-sm" id="select">
        </form>
        <!-- 4. 显示页数-->

        <ul class="pagination pagination-sm pull-right" id="fenYe">
        li
<!--           <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul> -->
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody id="tbody">
        <!-- 5.页面加载用来放置所有文章的内容 -->
<!--           <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
 -->        </tbody>
      </table>
    </div>
  </div>

  <!-- 用于引入侧边栏部分 -->
  <?php include_once './public/_slide.php'; ?>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>
  // 1.页面加载,获取数据设置分页显示..创建分类下拉菜单
    var $tbody = $('#tbody');
    var $fenYe = $('#fenYe');
    var obj = {
      published:'已发布',
      trashed:'未发布',
      drafted:'草稿'
    };
    $.ajax({
      url:'/admin/api/_posts.php',
      dataType:'json',
      success:renderData
      });
  // 2.筛选操作
      var $form = $('#form');
      var $selectAll = $('#selectAll');
      var $category = $('#category');
      // 2.1动态生成分类下来选项
        $.ajax({
          url:'/admin/api/_cate.php',
          success:function(datas){
            $.each(datas,function(i,ele){
              $('<option value="'+ele.id+'">'+ele.name+'</option>').appendTo($category);
            })
          }
        }) 
      // 2.2 给筛选按钮注册事件
      $('#select').on('click',function(){
        page = 1;
        $.ajax({
          url:'/admin/api/_posts.php',
          success:renderData,
          dataType:'json',
          data:$form.serialize()
        })
      });
  // 2设置单个删除按钮
    $tbody.on('click','a.del',function(){
        var id = $(this).data('id');
        $.ajax({
          method:'GET',
          url:'/admin/api/_postsdel.php?'+$form.serialize(),
          dataTyep:'json',
          data:{id:id},
          success:function(datas){
            console.log(datas);
            var count  = datas.count;
            // 删除后如果当前页数大于最大显示页数,将
            if(Math.ceil(count/20) < currentPage) {
              page = Math.ceil(count/20);
            }
            $.ajax({
              url:'/admin/api/_posts.php?' + $form.serialize(),
              data:{page:currentPage},
              dataType:'json',
              success:renderData
            })
          }
        })
    })
  // 3.设置批量删除
  // 4.设置页数跳转
  function renderData(datas){
        var str = '';
        var result = datas.result;
        $.each(result,function(i,ele){
            str += '<tr>\
                <td class="text-center"><input type="checkbox" data-id = "'+ele.id+'" id = "selectAll"></td>\
                <td>'+ele.title+'</td>\
                <td>'+ele.name+'</td>\
                <td>'+ele.slug+'</td>\
                <td class="text-center">'+ele.created+'</td>\
                <td class="text-center">'+obj[ele.status]+'</td>\
                <td class="text-center">\
                  <a href="javascript:;" class="btn btn-default btn-xs edit" data-id = "'+ele.id+'">编辑</a>\
                  <a href="javascript:;" class="btn btn-danger btn-xs del" data-id = "'+ele.id+'">删除</a>\
                </td>\
              </tr>';
            })
        $tbody.html(str);
    // --------------------------------------------------------
      //下面为分页功能
      var totalcounts = datas.count  // 总数据条数
      var num = 20 ;                // 每页显示的条数
      var totalPages =Math.ceil(totalcounts/num) ; // 总页数 
      // 显示结构中的起始页码
      var begin = currentPage - 2;
      if(begin < 1) {
        begin = 1;
      }
      // 显示结构中的结束页。
      var end = begin + 4;
      if(end > totalPages) {
        end = totalPages;
      }

      // 设置页码的显示效果
      var str = '';
        // 设置上一页
      if(currentPage !== 1) {
        str += '<li><a class = "page" href="javascript:;" data-page = "'+(currentPage - 1)+'">上一页</a></li>'
      };

      // 固定的五个页码创建
      for(var i = begin; i <= end ; i ++) {
        str += '<li class = "'+ (currentPage === i ? 'active' : '')+'"><a href="javascript:;" class = "page" data-page = "'+ i +'">'+ i +'</a></li>'
      };

      // 设置下一页
       if(currentPage !== totalPages) {
        str += '<li><a class = "page" href="javascript:;" data-page = "'+(currentPage + 1)+'">下一页</a></li>'
      };
     
      $fenYe.html(str);
    }
     var currentPage = 1; // 默认当前页数为第一页
     // 选择a标签时一般需要加类名来选择
     $fenYe.on('click','a.page',function(){
        // 获取当前页号
        currentPage = $(this).data('page');
        $.ajax({
          method : 'GET',
          url : '/admin/api/_posts.php?' + $form.serialize(),
          data:{page:currentPage},
          dataType:'json',
          success : renderData
        })
     })
     
  </script>
</body>
</html>
