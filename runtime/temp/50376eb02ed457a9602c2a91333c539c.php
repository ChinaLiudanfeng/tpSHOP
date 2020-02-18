<?php /*a:2:{s:77:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\zuoye\view\role\index.html";i:1557540327;s:80:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\zuoye\view\layout\layout.html";i:1557546989;}*/ ?>
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <title>layout 后台大布局 - Layui</title>
      <link rel="stylesheet" href="/static/layui/css/layui.css">
      <script src="/static/layui/layui.js"></script>
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
              贤心
            </a>
            <dl class="layui-nav-child">
              <dd><a href="">基本资料</a></dd>
              <dd><a href="">安全设置</a></dd>
            </dl>
          </li>
          <li class="layui-nav-item"><a href="">退了</a></li>
        </ul>
      </div>
      
      <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
          <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
          <ul class="layui-nav layui-nav-tree"  lay-filter="test">
            <li class="layui-nav-item layui-nav-itemed">
              <a class="" href="javascript:;">角色管理</a>
              <dl class="layui-nav-child">
                <dd><a href="<?php echo url('Role/create'); ?>">添加角色</a></dd>
                <dd><a href="<?php echo url('Role/index'); ?>">角色列表</a></dd>
              </dl>
            </li>
            <li class="layui-nav-item">
              <a href="javascript:;">节点管理</a>
              <dl class="layui-nav-child">
                <dd><a href="<?php echo url('Node/create'); ?>">添加节点</a></dd>
                <dd><a href="<?php echo url('Node/index'); ?>">节点列表</a></dd>
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
          
<a href="<?php echo url('create'); ?>"><i class="layui-icon layui-icon-face-surprised" style="font-size: 50px; color: #1E9FFF;"></i>添加</a>
<table id="demo" lay-filter="test">
  <script type="text/html" id="czTpl">
    <i class="layui-icon layui-icon-edit" style="font-size: 30px; color: #1E9FFF;" lay-event="edit"></i>
    &ensp;
    &ensp;
    <i class="layui-icon layui-icon-delete" style="font-size: 30px; color: #1E9FFF;" lay-event="del"></i>
  </script>
</table>
<script>
    layui.use('table', function(){
      var table = layui.table;
      
      //第一个实例
      table.render({
        elem: '#demo'
        ,url: '<?php echo url("list"); ?>' //数据接口
        ,page: true //开启分页
        ,limit: 2
        ,cols: [[ //表头
          {field: 'name', title: '角色名'}
          ,{field: 'desc', title: '角色描述'}
          ,{title: '操作',templet: '#czTpl',width: 120}
        ]]
      });
});
</script>
<script type="text/javascript">
  layui.use(['table','jquery'],function(){
    var table = layui.table,$ = layui.jquery;
    //监听工具条
    table.on('tool(test)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
      var data = obj.data; //获得当前行数据
      var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
      var tr = obj.tr; //获得当前行 tr 的DOM对象
     
      if(layEvent === 'del'){ //删除
        layer.confirm('真的删除行么', function(index){
          $.post(
            "<?php echo url('delete'); ?>",
            {id:data.id},
            function(msg){
              layer.msg(msg.msg,{icon:msg.icon,time:2000},function(){
                if(msg.err == 1){
                  obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                }
              });
            },
            'json'
          );
        });
      }else if(layEvent === 'edit'){ //编辑
        location.href = "<?php echo url('edit'); ?>?id="+data.id;
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
    layui.use('element', function(){
      var element = layui.element;
      
    });
    </script>
    </body>
    </html>
          