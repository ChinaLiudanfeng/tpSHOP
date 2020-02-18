<?php /*a:2:{s:77:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\admin\list.html";i:1554987971;s:73:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\layout.html";i:1556108761;}*/ ?>
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
      <table class="layui-hide" id="test" lay-filter="test"></table>
 
<script type="text/html" id="toolbarDemo">
  <div class="layui-btn-container">
    <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>
    <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>
    <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button>
  </div>
</script>
 
<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 --> 
 
<script>
layui.use('table', function(){
  var table = layui.table;
  
  table.render({
    elem: '#test'
    ,url:'<?php echo url("list"); ?>'
    ,toolbar: '#toolbarDemo'
    ,title: '用户数据表'
    ,cols: [[
      {type: 'checkbox', fixed: 'left'}
      ,{field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
      ,{field:'a_name', title:'用户名', width:120, edit: 'text'}
      ,{field:'a_email', title:'邮箱', width:150, edit: 'text', templet: function(res){
        return '<em>'+ res.a_email +'</em>'
      }}
      ,{field:'status', title:'状态', width:80, edit: 'text', sort: true}
      ,{field:'create_time', title:'添加时间', width:200}
      ,{field:'update_time', title:'修改时间', width:200}
      ,{fixed: 'right', title:'操作', toolbar: '#barDemo', width:150}
    ]]
    ,page: true
  });
  
  //头工具栏事件
  table.on('toolbar(test)', function(obj){
    var checkStatus = table.checkStatus(obj.config.id);
    switch(obj.event){
      case 'getCheckData':
        var data = checkStatus.data;
        layer.alert(JSON.stringify(data));
      break;
      case 'getCheckLength':
        var data = checkStatus.data;
        layer.msg('选中了：'+ data.length + ' 个');
      break;
      case 'isAll':
        layer.msg(checkStatus.isAll ? '全选': '未全选');
      break;
    };
  });
  
  //监听行工具事件
  table.on('tool(test)', function(obj){
    var data = obj.data;
    //console.log(obj)
    if(obj.event === 'del'){
      layer.confirm('真的删除行么', function(index){
        


        $.ajax({
          url:'<?php echo url("delete"); ?>?id='+data.id,
          type:'get',
          dataType:'json',
          success:function(msg){
            
            if(msg.err == 1){
              // location.href='<?php echo url("list"); ?>';
              layer.msg(msg.msg,{icon:msg.err});
              obj.del();
            }
          }
        })



        layer.close(index);
      });
    } else if(obj.event === 'edit'){
      // layer.prompt({
      //   formType: 2
      //   ,value: data.email
      // }, function(value, index){
      //   obj.update({
      //     email: value
      //   });
      //   layer.close(index);
      // });
      $.ajax({
        url:'<?php echo url("update"); ?>',
        type:'get',
        dataType:'json',
        success:function(msg){
          location.href="<?php echo url('update'); ?>?id="+data.id;
        }
      })
    }
  });
 //监听单元格编辑
  table.on('edit(test)', function(obj){
    var value = obj.value //得到修改后的值
    ,data = obj.data //得到所在行所有键值
    ,field = obj.field; //得到字段
    $.ajax({
      url:'<?php echo url("field"); ?>',
      type:'post',
      data:{value:value,field:field,id:data.id},
      dataType:'json',
      success:function(msg){
        layer.msg(msg.msg,{icon:msg.err});
      }
    })
    // layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
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