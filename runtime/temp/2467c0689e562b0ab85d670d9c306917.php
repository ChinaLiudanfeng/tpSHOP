<?php /*a:2:{s:77:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\zuoye\view\node\index.html";i:1558775064;s:80:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\zuoye\view\layout\layout.html";i:1557546989;}*/ ?>
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
          
<table border="1" align="center">
	<tr>
		<th></th>
		<th>节点</th>
		<th>控制器</th>
		<th>方法</th>
		<th>操作</th>
	</tr>
	<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
	<tr pid="<?php echo htmlentities($v['pid']); ?>" node_id="<?php echo htmlentities($v['id']); ?>">
		<?php if($v['pid']==0): ?>
		<td width="20" align="center"><b class="list">+</b></td>
		<?php else: ?>
		<td width="20" align="center"><b class="list"></b></td>
		<?php endif; ?>
		<td><?php echo htmlentities($v['node']); ?></td>
		<td><?php echo htmlentities($v['controller']); ?></td>
		<td><?php echo htmlentities($v['method']); ?></td>
		<td>
			<a href="javascript:;" class="del" nid="<?php echo htmlentities($v['id']); ?>">删除</a>&ensp;
			<a href="<?php echo url('edit'); ?>?id=<?php echo htmlentities($v['id']); ?>">修改</a>
		</td>
	</tr>
	<?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<script type="text/javascript">
	$('.del').click(function(){
		var _this = $(this);
		var id = _this.attr('nid');
		$.post(
			"<?php echo url('delete'); ?>",
			{id:id},
			function(msg){
				alert(msg.msg);
				if(msg.err == 1){
					_this.parents('tr').remove();
				}
			},
			'json'
		);
	});
	$('.edit').click(function(){
		
	});

	$('tr:gt(0)').each(function(i){
		var tr = $(this);
		if(tr.attr('pid')!=0){
			tr.hide();
		}
	});

	$(document).on('click','.list',function(){
		var _this = $(this);
		var node_id = _this.parents('tr').attr('node_id');
		if(_this.text()=="+"){
			_this.text('-');
			showTr(node_id);
		}else{
			_this.text('+');
			hideTr(node_id);
		}
	});
	function showTr(node_id){
		$("tr:gt(0)").each(function(i){
			var _this = $(this);
			if(_this.attr('pid')==node_id){
				_this.show();
			}
		});
	}
	function hideTr(node_id){
		$("tr:gt(0)").each(function(i){
			var _this = $(this);
			if(_this.attr('pid')==node_id){
				_this.hide();
				// hideTr(_this.attr('node_id'));
			}
		});
	}
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
          