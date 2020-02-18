<?php /*a:1:{s:79:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\zuoye\view\student\edit.html";i:1557715024;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<script type="text/javascript" src="/static/jquery-3.3.1.js"></script>
</head>
<body>
	<form id="form">
		姓名： <input type="text" name="sname" value="<?php echo htmlentities($student['sname']); ?>"><p>
		性别： <input type="text" name="ssex" value="<?php echo htmlentities($student['ssex']); ?>"><p>
		自我介绍： <textarea name="sdesc"><?php echo htmlentities($student['sdesc']); ?></textarea> <p>
		班级： <select name="cid">
					<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo htmlentities($v['cid']); ?>" <?php if($v['cid']==$student['cid']): ?>selected<?php endif; ?>><?php echo htmlentities($v['cname']); ?></option>
					<?php endforeach; endif; else: echo "" ;endif; ?>
			   </select><p>
			   	<input type="hidden" name="sid" value="<?php echo htmlentities($student['sid']); ?>">
			   	<input type="submit" value="修改" id="sb">
	</form>
	<script type="text/javascript">
		$(function(){
			$('#sb').click(function(){
				var data = $('#form').serialize();
				console.log(data);
				$.post(
					"<?php echo url('update'); ?>",
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