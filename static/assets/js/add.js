require.config({
	baseUrl : '/static/assets/vendors/',
	paths : {
		'jquery' : 'jquery/jquery',
		'ckeditor' : 'ckeditor/ckeditor',
		'bootstrap' :'bootstrap/js/bootstrap'
	},
	shim : {
		'ckeditor' : {
			dps : ['jquery'],
			exports : '$.fn.CKEDITOR'
		},
		'bootstrap' : {
			dps : ['jquery']
		}
	}
});

require(['jquery','ckeditor','bootstrap'],function($){

	  CKEDITOR.replace('content'); // 将文本域设置为富文本域
    // 1.动态创建分类下来菜单
    $category = $('#category');
    $form = $('#form');
    $btn = $('#btn');
    // 动态生成分类列表
    $.ajax({
      url : '/admin/api/_cate.php',
      dataType :'json',
      success:function(datas) {
        $.each(datas,function(i,ele){
          $('<option value = "'+ ele.id+'">'+ ele.name+'</option>').appendTo($category);
        })
      }
    });

    // 2.提交信息
    $btn.on('click',function(){
      // 先将信息返回给文本域,否则content的内容始终为空
      CKEDITOR.instances.content.updateElement();
      var arr = $form.serializeArray()
      console.log($form.serializeArray());
      $.each(arr,function(i,ele){
        if(ele.value === ''){
          alert('写完!!!!');
          return false; //结束循环
        }
      });

      var fd = new FormData($form[0]);
      $.ajax({
        type:'POST',
        url:'/admin/api/_postadd.php',
        data:fd,
        contentType:false,
        processData:false,
        success:function(datas) {
          console.log(datas);
          if(datas === '成功') {
            location.href = '/admin/posts.php';
          } else {
            alert('网络开小车..')
          }
        }
      })
    })
})