<?php /*a:1:{s:78:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\kaoshi\view\index\list.html";i:1559028907;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<script type="text/javascript" src="/static/jquery-3.3.1.js"></script>
</head>
<body>
	<form action="<?php echo url('list'); ?>" method="post">
		
		<select name="cid">
			<option value="">请选择</option>
			<?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>
			<option value="<?php echo htmlentities($cate['cid']); ?>"><?php echo htmlentities($cate['cname']); ?></option>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
		<input type="text" name="name" value="<?php echo htmlentities($name); ?>">
		<input type="submit" value="搜索">
	</form>
	<table border="1">
		<tr>
			<th>编号</th>
			<th>标题</th>
			<th>分类</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
		<tr>
			<td><?php echo htmlentities($v['id']); ?></td>
			<td><?php echo htmlentities($v['name']); ?></td>
			<td><?php echo htmlentities($v['cate']['cname']); ?></td>
			<td><?php echo htmlentities($v['status']); ?></td>
			<td>[<a href="javascript:;" class="del" qid="<?php echo htmlentities($v['id']); ?>">删除</a>]</td>
		</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	<script type="text/javascript">
		$(function(){
			$('.del').click(function(){
				var _this = $(this);
				var id = $(this).attr('qid');
				$.post(
					"<?php echo url('delete'); ?>",
					{id:id},
					function(msg){
						if(msg == 1){
							alert('删除成功');
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