<?php /*a:1:{s:76:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\test\view\user\login.html";i:1559120770;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<script src="/static/jquery-3.3.1.js"></script>
</head>
<body>
	<form id="myform">
        <table align="center">
            <tr>
                <td>用户名</td>
                <td>
                    <input type="text" name="user_name">
                </td>
            </tr>
            <tr>
                <td>密码</td>
                <td>
                    <input type="text" name="user_pwd">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="登录">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
<script type="text/javascript">
	$('#myform').submit(function(){
		var data = $(this).serialize();
		$.post(
            "<?php echo url('user/loginDo'); ?>",
            data,
            function(msg){
                alert(msg.font);
                if(msg.code==1){
                    location.href = "<?php echo url('logList'); ?>";
                }
            },
            'json'
        );
		return false;
	});
</script>