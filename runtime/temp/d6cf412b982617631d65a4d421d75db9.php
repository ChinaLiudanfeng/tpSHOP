<?php /*a:1:{s:80:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\zuoye\view\student\index.html";i:1557715287;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<script type="text/javascript" src="/static/jquery-3.3.1.js"></script>
</head>
<body>
	<table border="1">
		<tr>
			<th>姓名</th>
			<th>性别</th>
			<th>班级</th>
			<th>自我介绍</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
		<tr>
			<td><?php echo htmlentities($v['sname']); ?></td>
			<td><?php echo htmlentities($v['ssex']); ?></td>
			<td><?php echo htmlentities($v['cid']); ?></td>
			<td><?php echo htmlentities($v['belongsToClass']['cname']); ?></td>
			<td>
				<a href="javascript:;" class="del" sid="<?php echo htmlentities($v['sid']); ?>">删除</a>&ensp;&ensp;
				<a href="<?php echo url('edit'); ?>?id=<?php echo htmlentities($v['sid']); ?>">修改</a>
			</td>
		</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	<?php echo $data; ?>

	<script type="text/javascript">
		$(function(){
			$('.del').click(function(){
				var _this = $(this);
				var sid = _this.attr('sid');
				$.post(
					"<?php echo url('delete'); ?>",
					{sid:sid},
					function(msg){
						alert(msg.msg);
						if(msg.err==1){
							_this.parents('tr').remove();
						}
					},
					'json'
				);
			});
		});
	</script>
</body>
</html>