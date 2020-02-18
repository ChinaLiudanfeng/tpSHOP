<?php /*a:1:{s:79:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\zuoye\view\staff\create.html";i:1558926677;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<script type="text/javascript" src="/static/jquery-3.3.1.js"></script>
</head>
<body>
	<form id="form">
		<table border="1">
			<tr>
				<td>
					员工账号
				</td>
				<td>
					<input type="text" name="s_email">
				</td>
			</tr>
			<tr>
				<td>
					所属部门
				</td>
				<td>
					<select name="d_id">
						<?php if(is_array($info) || $info instanceof \think\Collection || $info instanceof \think\Paginator): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
						<option value="<?php echo htmlentities($v['d_id']); ?>"><?php echo htmlentities($v['d_name']); ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					出生日期
				</td>
				<td>
					<input type="text" name="s_birth">
				</td>
			</tr>
			<tr>
				<td>
					学历
				</td>
				<td>
					<input type="radio" name="s_education" value="1">本科
					<input type="radio" name="s_education" value="2">专科
				</td>
			</tr>
			<tr>
				<td>
					性别
				</td>
				<td>
					<input type="radio" name="s_sex" value="1">男
					<input type="radio" name="s_sex" value="2">女
				</td>
			</tr>
			<tr>
				<td>
					姓名
				</td>
				<td>
					<input type="text" name="s_name">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="添加" id="sb">
				</td>
			</tr>
		</table>
	</form>
	<script type="text/javascript">
		$('#sb').click(function(){
			var data = $('#form').serialize();
			$.post(
				"<?php echo url('save'); ?>",
				data,
				function(msg){
					if(msg==1){
						location.href = "<?php echo url('index'); ?>";
					}
				}
			);
			return false;
		});
	</script>
</body>
</html>