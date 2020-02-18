<?php /*a:1:{s:79:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\test\view\user\register.html";i:1559119254;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="/static/jquery-3.3.1.js"></script>
</head>
<body>
    <form id="myform">
        <table align="center">
            <tr>
                <td>用户名</td>
                <td>
                    <input type="text" name="user_name" id="user_name">
                    <span id="span_name">字符3-15位</span>
                </td>
            </tr>
            <tr>
                <td>密码</td>
                <td>
                    <input type="text" name="user_pwd">
                </td>
            </tr>
            <tr>
                <td>确认密码</td>
                <td>
                    <input type="text" name="user_repwd">
                </td>
            </tr>
            <tr>
                <td>邮箱</td>
                <td>
                    <input type="text" name="user_email">
                </td>
            </tr>
            <tr>
                <td>验证码</td>
                <td>
                    <input type="text" name="user_code">
                    <img src="<?php echo captcha_src(); ?>" alt="captcha" id="code" />
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="注册">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
<script>
    //点击切换验证码
    $('#code').click(function(){
        $(this).prop('src','<?php echo captcha_src(); ?>?r='+Math.random());
    });


    //失去焦点验证用户名
    var flag = false;
    $('#user_name').blur(function(){
        var _this = $(this);
        var user_name = _this.val();
        var reg = /^[a-z]{3,15}$/;
        if(user_name==""){
            $('#span_name').html('<font color="red">用户名必填<font>');
            flag = false;
        }else if(!reg.test(user_name)){
            $('#span_name').html('<font color="red">用户名格式不正确<font>');
            flag = false;
        }else{
            $.ajax({
                url:"<?php echo url('user/checkName'); ?>",
                method:'post',
                data:{user_name:user_name},
                async:false,
                success:function(res){
                    if(res==1){
                        $('#span_name').html('<font color="red">用户已存在<font>');
                        flag = false;
                    }else {
                        $('#span_name').html('<font color="green">OK<font>');
                        flag = true;
                    }
                }
            });
            return flag;
        }
    });

    //点击提交表单
    $('#myform').submit(function(){
        var user_name = $('input[name="user_name"]').val();
        $('#user_name').trigger('blur');
        if(flag==false){
            return false;
        }
        if($('input[name="user_pwd"]').val()==""){
            alert('密码必填');
            return false;
        }
        if($('input[name="user_repwd"]').val()==""){
            alert('确认密码必填');
            return false;
        }
        if($('input[name="user_email"]').val()==""){
            alert('邮箱必填');
            return false;
        }
        if($('input[name="user_code"]').val()==""){
            alert('验证码必填');
            return false;
        }
        var data = $('#myform').serialize();
        $.post(
            "<?php echo url('user/registerDo'); ?>",
            data,
            function(msg){
                alert(msg.font);
                if(msg.code==1){
                    location.href = "<?php echo url('login'); ?>";
                }
            },
            'json'
        );
        return false;
    });
</script>