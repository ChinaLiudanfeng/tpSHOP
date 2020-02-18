<?php /*a:2:{s:79:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\yqlink\index.html";i:1556116336;s:73:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\layout.html";i:1556108761;}*/ ?>
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
      <a class="layui-btn layui-btn-normal" href="<?php echo url('create'); ?>">添加友情</a>
<table id="demo" lay-filter="test">
  <script type="text/html" id="imgTpl">
    <img src="{{d.path}}" width="50">
  </script>
  <script type="text/html" id="czTpl">
    <a class="layui-btn layui-btn-xs" lay-event="edit" id="upd">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
  </script>
</table>
<script src="/layui/layui.js"></script>
<script>
layui.use('table', function(){
  var table = layui.table;
  
  //渲染表格
  table.render({
    elem: '#demo'
    ,height: 312
    ,url: '<?php echo url("info"); ?>' //数据接口
    ,page: true //开启分页
    ,limit: 2
    ,cols: [[ //表头
      {field: 'id', title: 'ID'}
      ,{field: 'name', title: '用户名'}
      ,{title: '友情logo', templet: '#imgTpl'}
      ,{title: '操作', templet: '#czTpl'}
    ]]
  });
  
  //删除
  table.on('tool(test)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
      var data = obj.data; //获得当前行数据
      var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
      var tr = obj.tr; //获得当前行 tr 的DOM对象
     
      if(layEvent === 'del'){ //删除
        layer.confirm('真的删除行么', function(index){
          $.get(
            "<?php echo url('delete'); ?>",
            {id:data.id},
            function(msg){
              layer.msg(msg.msg,{icon:msg.icon,time:2000},function(){
                if(msg.err == 1){
                  obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                  layer.close(index);
                  //向服务端发送删除指令
                }
              });
            },
            'json'
          );
          
        });
      } else if(layEvent === 'edit'){ //编辑
        // $('#upd').click(function(){
        //       location.href = "<?php echo url('edit'); ?>?id="+data.id;
        // });
        $.get(
            "<?php echo url('edit'); ?>",
            function(msg){
              location.href = "<?php echo url('edit'); ?>?id="+data.id;
            }
        );








        //do something
        
        //同步更新缓存对应的值
        // obj.update({
        //   name: '123'
        //   ,path: 'xxx'
        // });
      }
    });
});
</script>
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