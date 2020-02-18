<?php /*a:1:{s:79:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\kaoshi\view\index\index.html";i:1556590981;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<script type="text/javascript" src="/static/jquery-3.3.1.js"></script>
</head>
<body>
	<form id="text">
		标题<input type="text" name="name"><p>
		分类<select name="cid">
			<?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>
				<option value="<?php echo htmlentities($cate['cid']); ?>"><?php echo htmlentities($cate['cname']); ?></option>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			</select><p>
		状态<input type="radio" name="status" value="显示">显示
		<input type="radio" name="status" value="隐藏">隐藏<p>
		内容<textarea name="content"></textarea><p>
		<input type="button" value="提交" id="btn">
	</form>
	<script type="text/javascript">
		$(function(){
			$('input[name="name"]').blur(function(){
				var val = $(this).val();
				if(val == ""){
					alert('标题必填');
					$('#btn').prop('disabled',true);
					return false;
				}else{
					$.ajax({
						url:"<?php echo url('checkName'); ?>",
						method:"post",
						data:{name:val},
						success:function(msg){
							if(msg){
								$('#btn').prop('disabled',true);
								alert('分类名称已存在');
								return false;
							}else{
								$('#btn').prop('disabled',false);
							}
						},
						dataType:'json'
					});
				}
			});

			$('#btn').click(function(){
				var data = $('#text').serialize();
				$.ajax({
					url:"<?php echo url('save'); ?>",
					method:"post",
					data:data,
					dataType:'json',
					success:function(msg){
						if(msg==1){
							alert('添加成功');
							location.href = "<?php echo url('list'); ?>";
						}
					}
				});

			});
		});
	</script>
</body>
</html>