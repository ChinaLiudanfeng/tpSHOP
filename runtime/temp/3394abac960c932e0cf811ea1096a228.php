<?php /*a:2:{s:78:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\zuoye\view\role\create.html";i:1557538163;s:80:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\zuoye\view\layout\layout.html";i:1557546989;}*/ ?>
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
          
<form class="layui-form layui-form-pane">
  <div class="layui-form-item">
    <label class="layui-form-label">角色名称</label>
    <div class="layui-input-block">
      <input type="text" name="name" required  lay-verify="required|checkName" placeholder="请输入标题" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">角色描述</label>
    <div class="layui-input-block">
      <textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo" id="bt">立即提交</button>
    </div>
  </div>
</form>
 
<script>
//Demo
layui.use(['form','layer','jquery'], function(){
  var form = layui.form,layer = layui.layer,$ = layui.jquery;
  
  form.verify({
    checkName:function(value){
      var reg = /^\w+$/;
      if(value.length>30){
        return "名称最长长度为30";
      }
      if(!reg.test(value)){
        return "名称由字母数字下划线组成";
      }
    }
  }); 
  //验证名称唯一性
  $("input[name='name']").blur(function(){
    var name = $(this).val();
      $.post(
        "<?php echo url('checkNameOnly'); ?>",
        {name:name},
        function(msg){
          if(msg>=1){
            layer.msg('该名称已存在',{icon:5,time:2000});
            $("#bt").prop('disabled',true);
          }else{
            $("#bt").prop('disabled',false);
          }
        }
      );
  });


  //监听提交
  form.on('submit(formDemo)', function(data){
    $.post(
      "<?php echo url('save'); ?>",
      data.field,
      function(msg){
        layer.msg(msg.msg,{icon:msg.icon,time:2000},function(){
          if(msg.err == 1){
            location.href = "<?php echo url('index'); ?>";
          }
        });
      },
      'json'
    );
    return false;
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
          