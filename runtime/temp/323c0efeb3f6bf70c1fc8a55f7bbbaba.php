<?php /*a:2:{s:78:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\brand\index.html";i:1556260676;s:73:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\layout.html";i:1556108761;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>layout 后台大布局 - Layui</title>
  <link rel="stylesheet" href="/static/layui/css/layui.css">
  <script type="text/javascript" src="/static/layui/layui.js"></script>
  <script type="text/javascript" src="/static/jquery-3.3.1.js"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">layui 后台布局</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="">控制台</a></li>
      <li class="layui-nav-item"><a href="">商品管理</a></li>
      <li class="layui-nav-item"><a href="">用户</a></li>
      <li class="layui-nav-item">
        <a href="javascript:;">其它系统</a>
        <dl class="layui-nav-child">
          <dd><a href="">邮件管理</a></dd>
          <dd><a href="">消息管理</a></dd>
          <dd><a href="">授权管理</a></dd>
        </dl>
      </li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
          <?php echo htmlentities(app('session')->get('info.a_name')); ?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="">基本资料</a></dd>
          <dd><a href="">安全设置</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item"><a href="javascript:void(0)" id="logout">退了</a></li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <li class="layui-nav-item"><a href="<?php echo url('admin/category/index'); ?>">分类列表</a></li>
        <li class="layui-nav-item"><a href="<?php echo url('admin/brand/index'); ?>">品牌分类</a></li>
        <li class="layui-nav-item"><a href="<?php echo url('admin/goods/index'); ?>">商品管理</a></li>
        <li class="layui-nav-item"><a href="<?php echo url('admin/yqlink/index'); ?>">友情链接</a></li>
        <li class="layui-nav-item">
          <a href="javascript:;">解决方案</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;">列表一</a></dd>
            <dd><a href="javascript:;">列表二</a></dd>
            <dd><a href="">超链接</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item"><a href="">云市场</a></li>
        <li class="layui-nav-item"><a href="">发布商品</a></li>
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
      <a href="<?php echo url('create'); ?>" class="layui-btn layui-btn-radius layui-btn-warm">添加品牌</a>
<table class="layui-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>商品名称</th>
      <th>商品介绍</th>
      <th>商品logo</th>
      <th>是否显示</th>
      <th>添加时间</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>
    <tr brand_id="<?php echo htmlentities($data['brand_id']); ?>">
      <td align="center"><?php echo htmlentities($data['brand_id']); ?></td>
      <td class="td"><?php echo htmlentities($data['brand_name']); ?></td>
      <td><?php echo htmlentities($data['brand_describe']); ?></td>
      <td><img src="<?php echo htmlentities($data['brand_logo']); ?>" width="60" height="60"></td>
      <td><?php echo htmlentities($data['brand_show']); ?></td>
      <td><?php echo htmlentities($data['brand_time']); ?></td>
      <td>
        [<a href="<?php echo url('edit',['id'=>$data['brand_id']]); ?>">编辑</a>]
        [<a href="javascript:void(0)" class="del">删除</a>]
      </td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </tbody>
  <script type="text/javascript">
    layui.use(['jquery'],function(){
        var $ = layui.jquery;
        $('.td').click(function(){
          var td = $(this),text = td.text(),input = $('<input type="text">').css({'border':0}).val(text),id = td.parent('tr').attr('brand_id');
          if(td.children('input').length>0){
            return false;
          }
          td.html(input);
          input.select();
          input.blur(function(){
            $.ajax({
              url:"<?php echo url('editTable'); ?>",
              type:"post",
              data:{brand_name:input.val(),brand_id:id},
              dataType:'json',
              success:function(msg){
                layer.msg(msg.msg,{icon:msg.icon,time:2000},function(){
                  if(msg.err == 1){
                    td.text(input.val());
                  }else{
                    td.text(text);
                  }
                });
              }
            });
          });
        });
        $('.del').click(function(){
          var del = $(this);
          var id = del.parents('tr').attr('brand_id');
          layer.confirm('确定要删除吗？',function(){
            $.get(
                "<?php echo url('delete'); ?>",
                {id:id},
                function(msg){
                  layer.msg(msg.msg,{icon:msg.icon,time:2000},function(){
                    if(msg.err == 1){
                      del.parents('tr').remove();
                    }
                  })
                },
                'json'
              )
          });
        });
    });
    // //隐藏不是顶级分类的其他分类
    // $('tr:gt(0)').each(function(){
    //   var tr = $(this);
    //   if(tr.attr('pid')!=0){
    //     tr.hide();
    //   }
    // });
    // //点击事件
    // $('.a').click(function(){
    //   var a = $(this),
    //   brand_id = a.parents('tr').attr('brand_id');
    //   if(a.text()=="+"){
    //     a.text('-');
    //     showTr(brand_id);
    //   }else{
    //     a.text('+');
    //     hideTr(brand_id);
    //   }
    // });

    // //显示其他行函数
    // function showTr(brand_id)
    // {
    //   $('tr').each(function(){
    //     var tr = $(this);
    //     if(tr.attr('pid')==brand_id){
    //       tr.show();
    //     }
    //   });
    // }
    // //隐藏其他行函数
    // function hideTr(brand_id)
    // {
    //   $('tr').each(function(){
    //     var tr = $(this);
    //     if(tr.attr('pid')==brand_id){
    //       tr.hide();
    //       hideTr(tr.attr('brand_id'));
    //     }
    //   });
    // }
    // //隐藏不是顶级的所有分类
    // $('tr:gt(0)').each(function(){
    //   var tr = $(this);
    //   if(tr.attr('pid')!=0){
    //     tr.hide();
    //   }
    // })
    // //点击事件
    // $('.a').click(function(){
    //   var a = $(this),brand_id = a.parents('tr').attr('brand_id');
    //   if(a.text()=="+"){
    //     a.text('-');
    //     showTr(brand_id);
    //   }else{
    //     a.text('+');
    //     hideTr(brand_id);
    //   }
    // });
    // //显示函数
    // function showTr(brand_id){
    //   $('tr').each(function(){
    //     var tr = $(this);
    //     if(tr.attr('pid')==brand_id){
    //       tr.show();
    //     }
    //   });
    // }
    // //隐藏函数
    // function hideTr(brand_id){
    //   $('tr').each(function(){
    //     var tr = $(this);
    //     if(tr.attr('pid')==brand_id){
    //       tr.hide();
    //       hideTr(tr.attr('brand_id'));
    //     }
    //   });
    // }
  </script>
</table>
    </div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>
</div>
<script>
//JavaScript代码区域
layui.use(['element','jquery','layer'], function(){
  var element = layui.element
  ,layer = layui.layer
  ,$ = layui.jquery;

  $('#logout').click(function(){
      layer.confirm('确定退出吗？',{icon:3,title:'提示'},function(){
          location.href = "<?php echo url('admin/login/logout'); ?>";
      })
  })
  
});
</script>
</body>
</html>