<?php /*a:1:{s:78:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\login\login.html";i:1555386379;}*/ ?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="/static/login/css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="/static/login/css/demo.css" />
    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="/static/login/css/component.css" />
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <script src="/static/layui/layui.js"></script>
    <!--[if IE]>
    <script src="/static/admin/login/js/html5.js"></script>
    <![endif]-->
    <style>
        input::-webkit-input-placeholder{
            color:rgba(0, 0, 0, 0.726);
        }
        input::-moz-placeholder{   /* Mozilla Firefox 19+ */
            color:rgba(0, 0, 0, 0.726);
        }
        input:-moz-placeholder{    /* Mozilla Firefox 4 to 18 */
            color:rgba(0, 0, 0, 0.726);
        }
        input:-ms-input-placeholder{  /* Internet Explorer 10-11 */
            color:rgba(0, 0, 0, 0.726);
        }
    </style>
</head>
<body>
<div class="container demo-1">
    <div class="content">
        <div id="large-header" class="large-header">
            <canvas id="demo-canvas"></canvas>
            <div class="logo_box">
                <h3>登录</h3>
                <form  method="post"  class="layui-form">
                    <div class="input_outer">
                        <span class="u_user"></span>
                        <input id="username" name="a_name" class="text" lay-verify="required|checkName" style="color: #000000 !important" type="text" placeholder="请输入账户">
                    </div>
                    <div class="input_outer">
                        <span class="us_uer"></span>
                        <input id="pwd" name="a_pwd" class="text" lay-verify="required" style="color: #000000 !important; position:absolute; z-index:100;"value="" type="password" placeholder="请输入密码">
                    </div>
                    <div>
                        <input type="text" name="a_code" lay-verify="required" style="width: 120px;height: 50px;border-radius: 25px;border: 1px solid #ccc;">
                        <img src="<?php echo captcha_src(); ?>" alt="captcha"  id="code"/>
                    </div>
                    <div id="login" class="mb2">
                        <a class="act-but submit" lay-submit lay-filter="*" href="javascript:;"  style="color: #FFFFFF">登录</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- /container -->
<script src="/static/login/js/TweenLite.min.js"></script>
<script src="/static/login/js/EasePack.min.js"></script>
<script src="/static/login/js/rAF.js"></script>
<script src="/static/login/js/demo-1.js"></script>
<script src="/static/login/js/Longin.js"></script>
<div style="text-align:center;">
</div>
<script type="text/javascript">
    layui.use(['jquery','layer','form'],function(){
        var $ = layui.jquery,
        layer = layui.layer,
        form = layui.form;

        form.verify({
            checkName:function(value){
                var str = /^\w{5,24}$/;
                if(!str.test(value)){
                    // layer.msg("用户名为5-24位字母数字下划线",{icon:5});
                    return "用户名为5-24位字母数字下划线";
                }
            }
        })

        function changeCode(){
            $('#code').prop('src',$('#code').prop('src')+"?n="+Math.random());
        }
        $('#code').click(function(){
            changeCode();
        })

        form.on('submit(*)', function(data){
            $.post(
                "<?php echo url('login'); ?>",
                data.field,
                function(msg){
                    layer.msg(msg.msg,{icon:msg.icon,time:2000},function(){
                        if(msg.err == 1){
                            location.href = "<?php echo url('admin/list'); ?>";
                        }else{
                            changeCode();
                        }
                    });
                },
                "json",
                )
        });
    })
</script>
</body>
</html>
