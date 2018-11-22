require.config({
  baseUrl : '/static/assets/vendors/',
  paths : {
    'jquery' : 'jquery/jquery',
    'bootstrap' : 'bootstrap/js/bootstrap',
    'template' : 'art-template/template-web'
  },
  shim : {
    'bootstrap' : {
      dps : ['jquery']
    }
  }
});
require(['jquery','template','bootstrap'],function($,template) {

  // 1.页面加载 查询数据渲染页面 
  // 使用模板引擎时,状态栏的英文怎么转换为中文???????????  {{obj.status}}
      $tbody = $('#tbody');
      renderData();
      function renderData () {
         $.ajax({
          url : '/admin/api/_users.php',
          dataType : 'json',
          success : function (datas) {
            var str = template('template',datas);
            $tbody.html(str);
          }
        });
      }

    // 2. 删除功能

      // 2.1单个删除功能
      $tbody.on('click','a.del',function () {
          var id = $(this).data('id');
          $.ajax({
            url : '/admin/api/_usersdel.php',
            data : {id : id},
            success : function (datas) {
              if(datas === '删除成功') {
                renderData();
              } else {
                alert('您的网络开小差了~');
              }
            }
          })
      });

      // 2.2 批量删除功能
      var $selectAll = $('#selectAll');
      var $delSome = $('#delSome');

      // 设置全选和反选
      var idArr = [];
      $selectAll.on('click',function () {
        var bool = $(this).prop('checked');
        var $cbs = $tbody.find('input');
        $cbs.prop('checked',bool);
        idArr = [];
        if(bool) {
          $delSome.show();
          $.each($cbs,function (i,ele) {
            idArr.push($(ele).data('id'));
          });
        } else {
          $delSome.hide();
        }
      });

      // 设置单个单选按钮时
        $tbody.on('click','input',function () {
          var bool = $(this).prop('checked');
          var $cbs = $tbody.find('input');
          var id = $(this).data('id');
          if(bool) {
            idArr.push(id);
          } else {
            idArr.splice(idArr.indexOf(id),1);
          };
          idArr.length >= 2 ? $delSome.show() : $delSome.hide();
          if(idArr.length === $cbs.length) {
            $selectAll.prop('checked',true);
          } else {
            $selectAll.prop('checked',false);
          }
        });

        // 点击批量删除按钮
        $delSome.on('click',function () {
          $.ajax({
            url : '/admin/api/_usersdel.php',
            data : {id : idArr.join()},
            success : function (datas) {
              if(datas === '删除成功') {
                renderData();
              } else {
                alert('您的网络开小差了..')
              }
            }
          })
        });

  // 3.添加用户
    $email = $('#email');
    $slug = $('#slug');
    $nickname = $('#nickname');
    $password = $('#password');
    $add = $('#add');
    var flag = [false,false,false,false];
    // 3.1 邮箱验证
    $email.on('blur',function () {
        // 检测内容不能为空
      if($(this).val() === '') {
        alert('邮箱不能为空');
        return;
      };
      // 检测邮箱有效性
      if(!/^\w+@\w+\.\w+$/.test($(this).val())) {
        alert('邮箱格式不正确');
        return;
      }
      // 通过检测后发送请求检测是邮箱否重复
      $.ajax({
        url : '/admin/api/_userscheck.php',
        data : {email : $(this).val()},
        success : function (datas) {
          if(datas === 'yes') {
            // 为什么下面这个修改数组元素无效???????????????????????????????????????????
            flag[0] = true;
          } else {
            alert('用户名已存在');
          }
        }
      });
    });

    // 别名验证
    $slug.on('blur',function () {
      var $val = $(this).val()
      if($val === '') {
        alert('内容不能为空');
        return;
      };
      $.ajax({
        url : '/admin/api/_usersslug.php',
        data : {slug : $val},
        success : function (datas) {
          if(datas === '可以使用') {
            flag[1] = true;
          } else {
            alert('用户名已存在');
            flag[1] = false;
          }
        }
      });
    });

    // 昵称验证
    $nickname.on('blur',function () {
      if($(this).val() === '') {
        alert('昵称不能为空');
        flag[2] = false;
      } else {
        flag[2] = true;
      }
    });

    // 密码验证
    $password.on('blur',function () {
      if(!/^[0-9a-zA-Z]{6,15}$/.test($(this).val())) {
        alert('密码不符合规则');
        flag[3] = false;
      } else  {
        flag[3] = true;
      }
    });

    // 提交按钮  
    // 关于数组,异步事件永远晚于同步事件触发。
    $add.on('click',function () {
      console.log(123);
      if(flag.indexOf(false) !== -1) {
        alert('某·个元素不符合规则');
        return;
      };
      var datas = $('#form').serialize();
      $.ajax({
        type : 'POST',
        url : '/admin/api/_usersadd.php',
        data : datas,
        success : function (datas) {
          console.log(datas);
          if(datas === '添加成功') {
            renderData();
          } else {
            alert('稍后再试');
          }
        }
      })
    });

    // 4.编辑按钮 动态创建。事件委托
    var $reset = $('#reset');
    var $cancel = $('#cancel');
    var $edit = $('#edit');
    var $reset = $('#reset');
    $tbody.on('click','a.edit',function () {
      var id = $(this).data('id');
      var $email = $(this).parents('tr').children().eq(2).text();
      var $slug = $(this).parents('tr').children().eq(3).text();
      var $nickname = $(this).parents('tr').children().eq(4).text();
      var $password = $(this).parents('tr').children().eq(5).text();
      $('#form').find('input').eq(0).val(id);
      $('#form').find('input').eq(1).val($email);
      $('#form').find('input').eq(2).val($slug);
      $('#form').find('input').eq(3).val($nickname);
      $('#form').find('input').eq(4).val($password);
      $('#edit').show();
      $('#cancel').show();
      $('#add').hide();
    });
    $('#cancel').on('click',function(){
      $('#reset').on('click');
      $('#edit').hide();
      $('#cancel').hide();
      $('#add').show();
    });

    $('#edit').on('click',function () {
      $.ajax({
        url : '/admin/api/_usersedit.php',
        data : $('#form').serialize(),
        success : function (datas) {
          if(datas === '修改成功') {
              renderData();
          } else {
            alert('你的网络有问题');
          }
        }
      })
    })
});