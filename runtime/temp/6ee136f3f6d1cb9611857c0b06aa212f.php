<?php /*a:1:{s:81:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\zuoye\view\student\create.html";i:1557712492;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<script type="text/javascript" src="/static/jquery-3.3.1.js"></script>
</head>
<body>
	<form id="form">
		姓名： <input type="text" name="sname"><p>
		性别： <input type="text" name="ssex"><p>
		自我介绍： <textarea name="sdesc"></textarea> <p>
		班级： <select name="cid">
					<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($v['cid']); ?>"><?php echo htmlentities($v['cname']); ?></option>
					<?php endforeach; endif; else: echo "" ;endif; ?>
			   </select><p>
			   	<input type="submit" value="添加" id="sb">
	</form>
	<script type="text/javascript">
		$(function(){
			$('#sb').click(function(){
				var data = $('#form').serialize();
				console.log(data);
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
		})
	</script>
</body>
</html>