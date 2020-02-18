<?php /*a:2:{s:81:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\category\index.html";i:1555488462;s:73:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\layout.html";i:1556108761;}*/ ?>
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
      <a href="<?php echo url('admin/category/create'); ?>" class="layui-btn layui-btn-radius layui-btn-normal">添加分类</a>
<table class="layui-table">
  <thead>
    <tr>
      <th>展开/收起</th>
      <th>名称</th>
      <th>是否显示</th>
      <th>导航显示</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>
    <tr cate_id="<?php echo htmlentities($data['cate_id']); ?>" pid="<?php echo htmlentities($data['cate_pid']); ?>">
      <td><button class="layui-btn layui-btn-sm layui-btn-normal"><a class="bt" href="javascript:void(0)">展开</a></button></td>
      <td class="td"><?php echo str_repeat('&ensp;',$data['lev']*8); ?><?php echo htmlentities($data['cate_name']); ?></td>
      <td><?php echo htmlentities($data['cate_show']); ?></td>
      <td><?php echo htmlentities($data['cate_nav']); ?></td>
      <td>
        [<a href="<?php echo url('edit',['id'=>$data['cate_id']]); ?>">编辑</a>]
        [<a href="javascript:void(0)" class="del">删除</a>]
      </td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </tbody>
  <script type="text/javascript">
    layui.use(['jquery','layer'],function(){
      var $ = layui.jquery, layer = layui.layer;
      $(".td").click(function(){
          var _this = $(this), 
              cate_id = _this.parent('tr').attr('cate_id');
              _text = _this.text(),
              _input = $('<input type="text" name="cate_name">').css({'border':'0','background-color':_this.css('background-color')}).val(_text);
          if(_this.children('input').length>0){
            return false;
          }
          _this.html(_input);
          _input.select();
          _input.blur(function(){
            $.ajax({
              url:'<?php echo url("editTable"); ?>',
              method:'post',
              data:{cate_id:cate_id,cate_name:_input.val()},
              dataType:'json',
              success:function(msg){
                layer.msg(msg.msg,{icon:msg.icon,time:2000},function(){
                  if(msg.err == 1){
                    _this.text(_input.val());
                  }else{
                    _this.text(_text);
                  }
                });
              }
            })
          })

      })
      $('.del').click(function(){
        var del = $(this);
        layer.confirm('确定要删除吗？',function(){
          $.post(
          "<?php echo url('delete'); ?>",
          {cate_id:del.parents('tr').attr('cate_id')},
          function(msg){
            layer.msg(msg.msg,{icon:msg.icon,time:2000},function(){
                if(msg.err == 1){
                  del.parents('tr').remove();
                }
            })
          },
          'json',
          )
        })
      });
    })
    $('tr:gt(0)').each(function(){
        var tr = $(this);
        if(tr.attr('pid')!=0){
          tr.hide();
        }
    })
    $('.bt').click(function(){
        var bt = $(this);
        var cate_id = bt.parents('tr').attr('cate_id');
        if(bt.text()=="展开"){
          bt.text('收起');
          showTr(cate_id);
        }else{
          bt.text('展开');
          hideTr(cate_id);
        }
    })
    function showTr(cate_id){
      $('tr').each(function(){
        var tr = $(this);
        if(tr.attr('pid') == cate_id){
          tr.show();
        }
      })
    }
    function hideTr(cate_id){
      $('tr').each(function(){
        var tr = $(this);
        if(tr.attr('pid') == cate_id){
          tr.hide();
          hideTr(tr.attr('cate_id'));
        }
      })
    }
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