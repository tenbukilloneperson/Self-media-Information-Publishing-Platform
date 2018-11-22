<?php 
$page = 'users';
// 引入配置文件来检测页面的登录状态
require_once '../config.php';
login_test();
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
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
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display: none">
        <strong>错误！</strong>发生XXX错误
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="form">
            <h2>添加新用户</h2>
            <input type="hidden" name="hidden" id="id">
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="button" id="add">添加</button>
              <button class="btn btn-primary" type="reset" id="reset">重置</button>
              <button class="btn btn-primary" type="button" id="edit" style="display: none">编辑</button>
              <button class="btn btn-primary" type="button" id="cancel" style="display: none">取消编辑</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none; position : absolute; top: -30px" id="delSome">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40"><input type="checkbox" id="selectAll"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody id="tbody">
                <!-- 用来放置动态创建的表格 -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
   
  <?php include_once './public/_slide.php'; ?>

  <!-- <script src="/static/assets/vendors/jquery/jquery.js"></script> -->
  <!-- <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script> -->
  <script>NProgress.done()</script>
  <!-- 以下为此页面的主要功能：数据的增删该查 -->

  <!-- 1.使用art-template模板引擎来渲染页面 引入文件,此模板依赖jquery。之前要先引入jquery -->
  <!-- <script src="/static/assets/vendors/art-template/template-web.js"></script> -->
  <!-- 2.制作模板 type设置为非js类型,同时给script设置一个id值 -->
  <script type="text/template" id="template">
    {{each $data obj}}
      <tr>  
        <td class="text-center"><input type="checkbox" data-id = "{{obj.id}}"></td>
        <td class="text-center"><img class="avatar" src="{{obj.avatar}}"></td>
        <td>{{obj.email}}</td>
        <td>{{obj.slug}}</td>
        <td>{{obj.nickname}}</td>
        <td>{{obj.status}}</td>
        <td class="text-center">
          <a href="javascript:;" class="btn btn-default btn-xs edit" data-id = "{{obj.id}}">编辑</a>
          <a href="javascript:;" class="btn btn-danger btn-xs del" data-id = "{{obj.id}}">删除</a>
        </td>
     </tr>
     {{/each}}
  </script>
  <script src="/static/assets/vendors/require/require.js" data-main = "/static/assets/js/user"></script>
  <script>
  // 下面为功能主体代码,使用模块化把js文件单独保存

  // // 1.页面加载 查询数据渲染页面 
  // // 使用模板引擎时,状态栏的英文怎么转换为中文???????????  {{obj.status}}
  //     $tbody = $('#tbody');
  //     renderData();
  //     function renderData () {
  //        $.ajax({
  //         url : '/admin/api/_users.php',
  //         dataType : 'json',
  //         success : function (datas) {
  //           var str = template('template',datas);
  //           $tbody.html(str);
  //         }
  //       });
  //     }

  //   // 2. 删除功能

  //     // 2.1单个删除功能
  //     $tbody.on('click','a.del',function () {
  //         var id = $(this).data('id');
  //         $.ajax({
  //           url : '/admin/api/_usersdel.php',
  //           data : {id : id},
  //           success : function (datas) {
  //             if(datas === '删除成功') {
  //               renderData();
  //             } else {
  //               alert('您的网络开小差了~');
  //             }
  //           }
  //         })
  //     });

  //     // 2.2 批量删除功能
  //     var $selectAll = $('#selectAll');
  //     var $delSome = $('#delSome');

  //     // 设置全选和反选
  //     var idArr = [];
  //     $selectAll.on('click',function () {
  //       var bool = $(this).prop('checked');
  //       var $cbs = $tbody.find('input');
  //       $cbs.prop('checked',bool);
  //       idArr = [];
  //       if(bool) {
  //         $delSome.show();
  //         $.each($cbs,function (i,ele) {
  //           idArr.push($(ele).data('id'));
  //         });
  //       } else {
  //         $delSome.hide();
  //       }
  //     });

  //     // 设置单个单选按钮时
  //       $tbody.on('click','input',function () {
  //         var bool = $(this).prop('checked');
  //         var $cbs = $tbody.find('input');
  //         var id = $(this).data('id');
  //         if(bool) {
  //           idArr.push(id);
  //         } else {
  //           idArr.splice(idArr.indexOf(id),1);
  //         };
  //         idArr.length >= 2 ? $delSome.show() : $delSome.hide();
  //         if(idArr.length === $cbs.length) {
  //           $selectAll.prop('checked',true);
  //         } else {
  //           $selectAll.prop('checked',false);
  //         }
  //       });

  //       // 点击批量删除按钮
  //       $delSome.on('click',function () {
  //         $.ajax({
  //           url : '/admin/api/_usersdel.php',
  //           data : {id : idArr.join()},
  //           success : function (datas) {
  //             if(datas === '删除成功') {
  //               renderData();
  //             } else {
  //               alert('您的网络开小差了..')
  //             }
  //           }
  //         })
  //       });

  // // 3.添加用户
  //   $email = $('#email');
  //   $slug = $('#slug');
  //   $nickname = $('#nickname');
  //   $password = $('#password');
  //   $add = $('#add');
  //   var flag = [false,false,false,false];
  //   // 3.1 邮箱验证
  //   $email.on('blur',function () {
  //       // 检测内容不能为空
  //     if($(this).val() === '') {
  //       alert('邮箱不能为空');
  //       return;
  //     };
  //     // 检测邮箱有效性
  //     if(!/^\w+@\w+\.\w+$/.test($(this).val())) {
  //       alert('邮箱格式不正确');
  //       return;
  //     }
  //     // 通过检测后发送请求检测是邮箱否重复
  //     $.ajax({
  //       url : '/admin/api/_userscheck.php',
  //       data : {email : $(this).val()},
  //       success : function (datas) {
  //         if(datas === 'yes') {
  //           // 为什么下面这个修改数组元素无效???????????????????????????????????????????
  //           flag[0] = true;
  //         } else {
  //           alert('用户名已存在');
  //         }
  //       }
  //     });
  //   });

  //   // 别名验证
  //   $slug.on('blur',function () {
  //     var $val = $(this).val()
  //     if($val === '') {
  //       alert('内容不能为空');
  //       return;
  //     };
  //     $.ajax({
  //       url : '/admin/api/_usersslug.php',
  //       data : {slug : $val},
  //       success : function (datas) {
  //         if(datas === '可以使用') {
  //           flag[1] = true;
  //         } else {
  //           alert('用户名已存在');
  //           flag[1] = false;
  //         }
  //       }
  //     });
  //   });

  //   // 昵称验证
  //   $nickname.on('blur',function () {
  //     if($(this).val() === '') {
  //       alert('昵称不能为空');
  //       flag[2] = false;
  //     } else {
  //       flag[2] = true;
  //     }
  //   });

  //   // 密码验证
  //   $password.on('blur',function () {
  //     if(!/^[0-9a-zA-Z]{6,15}$/.test($(this).val())) {
  //       alert('密码不符合规则');
  //       flag[3] = false;
  //     } else  {
  //       flag[3] = true;
  //     }
  //   });

  //   // 提交按钮  
  //   // 关于数组,异步事件永远晚于同步事件触发。
  //   $add.on('click',function () {
  //     console.log(123);
  //     if(flag.indexOf(false) !== -1) {
  //       alert('某·个元素不符合规则');
  //       return;
  //     };
  //     var datas = $('#form').serialize();
  //     $.ajax({
  //       type : 'POST',
  //       url : '/admin/api/_usersadd.php',
  //       data : datas,
  //       success : function (datas) {
  //         console.log(datas);
  //         if(datas === '添加成功') {
  //           renderData();
  //         } else {
  //           alert('稍后再试');
  //         }
  //       }
  //     })
  //   });

  //   // 4.编辑按钮 动态创建。事件委托
  //   var $reset = $('#reset');
  //   var $cancel = $('#cancel');
  //   var $edit = $('#edit');
  //   var $reset = $('#reset');
  //   $tbody.on('click','a.edit',function () {
  //     var id = $(this).data('id');
  //     var $email = $(this).parents('tr').children().eq(2).text();
  //     var $slug = $(this).parents('tr').children().eq(3).text();
  //     var $nickname = $(this).parents('tr').children().eq(4).text();
  //     var $password = $(this).parents('tr').children().eq(5).text();
  //     $('#form').find('input').eq(0).val(id);
  //     $('#form').find('input').eq(1).val($email);
  //     $('#form').find('input').eq(2).val($slug);
  //     $('#form').find('input').eq(3).val($nickname);
  //     $('#form').find('input').eq(4).val($password);
  //     $('#edit').show();
  //     $('#cancel').show();
  //     $('#add').hide();
  //   });
  //   $('#cancel').on('click',function(){
  //     $('#reset').on('click');
  //     $('#edit').hide();
  //     $('#cancel').hide();
  //     $('#add').show();
  //   });

  //   $('#edit').on('click',function () {
  //     $.ajax({
  //       url : '/admin/api/_usersedit.php',
  //       data : $('#form').serialize(),
  //       success : function (datas) {
  //         if(datas === '修改成功') {
  //             renderData();
  //         } else {
  //           alert('你的网络有问题');
  //         }
  //       }
  //     })
  //   })
  </script>


</body>
</html>  















