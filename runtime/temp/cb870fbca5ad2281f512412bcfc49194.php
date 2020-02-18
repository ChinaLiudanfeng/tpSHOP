<?php /*a:1:{s:75:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\test\view\user\page.html";i:1559122595;}*/ ?>
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