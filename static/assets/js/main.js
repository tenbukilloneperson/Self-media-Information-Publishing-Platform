// 1.使用require.config({}) 来配置
require.config({
	baseUrl : '/static/assets/vendors/',
	paths : {
		'jquery' : 'jquery/jquery',
		'template' : 'art-template/template-web',
		'twbsPagination' : 'twbs-pagination/jquery.twbsPagination'
	},
	shim : {
		twbsPagination : {
			dps : ['jquery'],
			exports : '$.fn.twbsPagination'
		}
	}
});

// 2.使用require([],function(){}) 来加载具有依赖关系的模块
require(['jquery','template','twbsPagination'],function($,template){

	//此回调函数主要用来放置当前模块的主体代码
  	var $tbody = $('#tbody');  
     var $list = $('#list');
     $.ajax({
         url : '/admin/api/_comget.php',
         dataType : 'json',
         success : function (datas) {
           // 参数1 ： 模板id   参数2 ：模板需要的数据   返回值 : 处理完毕的字符串
           var str = template('comments',datas.result);
           $tbody.html(str);
           var count = datas.count;
           totalPages = Math.ceil(count / 20);
           // 使用twbsPagination插件制作分页的效果
           $list.twbsPagination({
             totalPages : totalPages,
             visiblePages : 3,
             first : '首页',
             last  : '尾页',
             prev : '上一页',
             next : '下一页',
             onPageClick : function(event,page) {
                 $.ajax({
                   url : '/admin/api/_comget.php',
                   dataType : 'json',
                   data : {page : page},
                   success : function (datas) {
                     var str = template('comments',datas.result);
                     $tbody.html(str);
                   }
                 })
             }
           })
         }
     });
})