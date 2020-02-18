<?php /*a:1:{s:75:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\test\view\user\file.html";i:1559181415;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="/static/jquery-3.3.1.js"></script>
</head>
<body>
    <form action="<?php echo url('uploads'); ?>" method="post" enctype="multipart/form-data">
        <table align="center">
            <tr>
                <td>上传文件</td>
                <td>
                    <input type="file" name="user_file">
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