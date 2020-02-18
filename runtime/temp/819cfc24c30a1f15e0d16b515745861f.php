<?php /*a:1:{s:79:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\test\view\user\log_list.html";i:1559122529;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<script src="/static/jquery-3.3.1.js"></script>
	<style type="text/css">
		li{
			list-style: none;	
		}
		a{
			text-decoration : none;
		}
	</style>
</head>
<body>
	<table border="1" align="center">
		<tr>
			<th>ID</th>
			<th>用户名</th>
			<th>登录时间</th>
			<th>IP地址</th>
		</tr>
		<tbody id="tbody">
		<?php if(is_array($info) || $info instanceof \think\Collection || $info instanceof \think\Paginator): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
		<tr>
			<td><?php echo htmlentities($v['log_id']); ?></td>
			<td><?php echo htmlentities($v['user_name']); ?></td>
			<td><?php echo date('Y-m-d H:i:s',$v['log_time']); ?></td>
			<td><?php echo htmlentities($v['log_ip']); ?></td>
		</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
		<tr>
			<td colspan="4"><?php echo $str; ?></td>
		</tr>
		</tbody>
	</table>
</body>
</html>
<script type="text/javascript">
	$(document).on('click','.page',function(){
		var p = $(this).attr('p');
		$.post(
			"<?php echo url('page'); ?>",
			{p:p},
			function(msg){
				$('#tbody').html(msg);
			},
			'html'
		);
	});
</script>