<?php /*a:2:{s:80:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\comment\index.html";i:1559204431;s:73:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\layout.html";i:1559201343;}*/ ?>
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
          <a href="javascript:;">用户评论</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('Comment/index'); ?>">评论列表</a></dd>
            <dd><a href="javascript:;">评论回复</a></dd>
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
      <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<table align="center" border="1">
		<tr>
			<th>编号</th>
			<th>用户名</th>
			<th>类型</th>
			<th>评论对象</th>
			<th>ID地址</th>
			<th>评论时间</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($info) || $info instanceof \think\Collection || $info instanceof \think\Paginator): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
		<tr c_id="<?php echo htmlentities($v['c_id']); ?>">
			<th><?php echo htmlentities($v['c_id']); ?></th>
			<th>
			<?php if($v['user_name']=="匿名用户"): ?>
				<?php echo htmlentities($v['user_name']); else: ?>
				<?php echo htmlentities($v['user_email']); ?>
			<?php endif; ?>
			</th>
			<th><?php echo htmlentities($v['type']); ?></th>
			<th><?php echo htmlentities($v['goods_name']); ?></th>
			<th><?php echo htmlentities($v['user_ip']); ?></th>
			<th><?php echo date("Y-m-d H:i:s",$v['create_time']); ?></th>
			<th class="status"><?php echo htmlentities($v['status']); ?></th>
			<th><a href="<?php echo url('revert'); ?>">回复</a></th>
		</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
		<tr>
			<td colspan="8"><?php echo $info; ?></td>
		</tr>
	</table>
</body>
</html>
<script type="text/javascript">
	$(document).on('click','.status',function(){
		var _this = $(this);
		var _status = _this.text();
		var status = 1;
		var c_id = _this.parents('tr').attr('c_id');
		if(_status=="显示"){
			_this.text('隐藏');
			status = 2;
		}else{
			_this.text('显示');
			status = 1;
		}
		$.post(
			"<?php echo url('upd'); ?>",
			{c_id:c_id,status:status},
			function(msg){
				console.log(msg);
			}
		);
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