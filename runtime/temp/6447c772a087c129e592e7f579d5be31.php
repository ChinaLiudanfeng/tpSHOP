<?php /*a:2:{s:78:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\zuoye\view\node\create.html";i:1558771644;s:80:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\zuoye\view\layout\layout.html";i:1557546989;}*/ ?>
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
          
<form id="form">
	<table align="center" border="1">
		<tr>
			<td align="center">
				节点:
			</td>
			<td>
				<input type="text" name="node"><p>
			</td>
		</tr>
		<tr>
			<td align="center">
				父节点:
			</td>
			<td>
				<select name="pid">
					<option value="0">顶级节点</option>
					<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($v['id']); ?>"><?php echo str_repeat("&ensp;",$v['jb']*2); ?><?php echo htmlentities($v['node']); ?></option>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				<p>
			</td>
		</tr>
		<tr>
			<td align="center">
				控制器:
			</td>
			<td>
				<input type="text" name="controller"><p>
			</td>
		</tr>
		<tr>
			<td align="center">
				方法:
			</td>
			<td>
				<input type="text" name="method"><p>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<input type="submit" value="添加" id="sb">
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	$("#sb").click(function(){
		var data = $('#form').serialize();
		$.post(
			"<?php echo url('save'); ?>",
			data,
			function(msg){
				alert(msg.msg);
				if(msg.err == 1){
					location.href = "<?php echo url('index'); ?>";
				}
			},
			'json'
		);
		return false;
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
          