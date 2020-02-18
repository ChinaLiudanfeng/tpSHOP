<?php /*a:1:{s:78:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\index\view\login\login.html";i:1556164000;}*/ ?>
<!DOCTYPE html>
<html>

	<head lang="en">
		<meta charset="UTF-8">
		<title>登录</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="format-detection" content="telephone=no">
		<meta name="renderer" content="webkit">
		<meta http-equiv="Cache-Control" content="no-siteapp" />

		<link rel="stylesheet" href="/static/index/login/amazeui.css" />
		<link href="/static/index/login/dlstyle.css" rel="stylesheet" type="text/css">
		<link href="/static/layui/css/layui.css" rel="stylesheet" type="text/css">


		<script src="/static/layui/layui.js"></script>
		<script src="/static/index/login/jquery-3.2.1.min.js"></script>

	</head>

	<body>

		<div class="login-boxtitle">
			<a href="home.html"><img alt="logo" src="/static/index/login/logobig.png" /></a>
		</div>

		<div class="login-banner">
			<div class="login-main">
				<div class="login-banner-bg"><span></span><img src="/static/index/login/big.jpg" /></div>
				<div class="login-box">

							<h3 class="title">登录商城</h3>

							<div class="clear"></div>

							<div class="login-form">
								<form>
									<div class="user-name">
										<label for="account"><i class="am-icon-user"></i></label>
										<input type="text" id="account" value="<?php echo isset($userInfo['account']) ? htmlentities($userInfo['account']) : ''; ?>" placeholder="手机号/邮箱">
									</div>
									<div class="user-pass">
										<label for="user_pwd"><i class="am-icon-lock"></i></label>
										<input type="password" id="user_pwd" value="<?php echo isset($userInfo['user_pwd']) ? htmlentities($userInfo['user_pwd']) : ''; ?>" placeholder="请输入密码">
									</div>
								</form>
							</div>
            
							<div class="login-links">
								<label for="remember_me">
									<input id="remember_me" type="checkbox" <?php if($userInfo['remember_me']??""): ?>checked<?php endif; ?>>账号密码记录10天
								</label>
								<a href="#" class="am-fr">忘记密码</a>
								<a href="<?php echo url('Login/register'); ?>" class="zcnext am-fr am-btn-default">注册</a>
								<br />
							</div>
							<div class="am-cf">
								<input type="button" name="" value="登 录" id="login" class="am-btn am-btn-primary am-btn-sm">
							</div>
							<div class="partner">
								<h3>合作账号</h3>
								<div class="am-btn-group">
									<li><a href="#"><i class="am-icon-qq am-icon-sm"></i><span>QQ登录</span></a></li>
									<li><a href="#"><i class="am-icon-weibo am-icon-sm"></i><span>微博登录</span> </a></li>
									<li><a href="#"><i class="am-icon-weixin am-icon-sm"></i><span>微信登录</span> </a></li>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="footer ">
						<div class="footer-hd ">
							<p>
								<a href="# ">恒望科技</a>
								<b>|</b>
								<a href="# ">商城首页</a>
								<b>|</b>
								<a href="# ">支付宝</a>
								<b>|</b>
								<a href="# ">物流</a>
							</p>
						</div>
						<div class="footer-bd ">
							<p>
								<a href="# ">关于恒望</a>
								<a href="# ">合作伙伴</a>
								<a href="# ">联系我们</a>
								<a href="# ">网站地图</a>
								<em>© 2015-2025 Hengwang.com 版权所有. 更多模板 <a href="#" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a></em>
							</p>
						</div>
					</div>
	</body>

</html>
<script>


	$(function(){
		layui.use(['jquery','layer'],function(){
			var $ = layui.jquery, layer = layui.layer;
			$('#login').click(function(){
				var account = $('#account').val(),
					pwd = $('#user_pwd').val(),
					remember_me = $('#remember_me').prop('checked');
				$.post(
					"<?php echo url('login'); ?>",
					{account:account,pwd:pwd,remember_me:remember_me},
					function(msg){
						layer.msg(msg.msg,{icon:msg.icon,time:2000},function(){
							if(msg.err == 1){
								location.href = "<?php echo url('index/index'); ?>";
							}
						});
					},
					'json'
				);

			});
		});
	})
</script>