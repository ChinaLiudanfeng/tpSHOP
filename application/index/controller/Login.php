<?php

namespace app\index\controller;

use think\facade\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Login extends Common
{
    //登录
    public function login()
    {
        if(Request::isPost()&&Request::isAjax()){
            $account = Request::post('account');
            $pwd = Request::post('pwd');
            $time = time();
            $remember_me = Request::post('remember_me');
            if($account==""||$pwd==""){
                no("用户名密码必填");
            }
            $user = model('Users')->where(['user_email'=>$account])->find();
            // dump($user);die;
            if(empty($user)){
                no("该用户不存在");
            }
            if(md5($pwd)!=$user['user_pwd']){
                $second = $time-$user['error_time'];
                if($second > 86400){
                    $data = ['error_count'=>1,'error_time'=>$time,"user_id"=>$user['user_id']];
                    // echo $user['user_id'];die;
                    db('users')->update($data);
                    // model("Users")->save($data,["user_id"=>$user['user_id']]);
                    no("密码错误，还可以输入4次");
                }else{
                    if($user['error_count']>=5){
                        no('用户名已被锁定');
                    }else{
                        $data = ['error_count'=>$user['error_count']+1,"user_id"=>$user['user_id']];
                        db('users')->update($data);
                        no("密码错误，还可以输入".(4-$user['error_count'])."次");
                    }
                }
            }else{
                if($user['error_count']>=5&&$time-$user['error_time']<86400){
                    $time = date("Y-m-d H:i:s",$user['error_time']+86400);
                    no("用户已被锁定请与".$time."后登陆");////////
                }else{
                    $data = ['error_count'=>0,'error_time'=>null,'user_id'=>$user['user_id']];
                    db('users')->update($data);
                    if($remember_me == "true"){
                        $userInfo = serialize(['account'=>$account,'user_pwd'=>$pwd,'remember_me'=>$remember_me]);
                        cookie('userInfo',$userInfo,864000); 
                    }else{
                        cookie('userInfo',null);
                    }
                        $info = ['account'=>$account,'user_id'=>$user['user_id']];
                        session('info',$info); 
                        db('users')->update(['last_login_time'=>$time,'last_login_ip'=>Request::ip(),'user_id'=>$user['user_id']]);
                        //同步历史游览记录
                        $this->asyncHistory();
                        //同步加入购物车
                        $this->asyncCart();
                        ok('登陆成功');
                }
            }
        }else{
            $user = unserialize(cookie('userInfo'));
            $this->assign('userInfo',$user);
            return $this->fetch();            
        }

    }

    // 退出
    public function logout()
    {
        session('info',null);
        $this->success('再见','index/login/login');
    }

    //注册
    public function register()
    {
        if(Request::isPost()&&Request::isAjax()){
            $data = Request::post();
            if(!validate('Login')->check($data)){
                no(validate('Login')->getError());
            }
            if($data['user_code'] != session('body')){
                no('验证码错误');
            }
            $res = model('users')->save($data);
            $res ? ok() : no();

        }else{
            return $this->fetch();   
        }
    }

    //发送邮件
    public function sendEmail()
    {
        $email = Request::post('email');
        $mail = new PHPMailer(true);
        $subject = "验证码";
        $body = mt_rand(100000,999999);
        try {
            // 服务器设置
            $mail->SMTPDebug = 0;                                       // 启用详细调试输出
            $mail->isSMTP();                                            // 设置邮件程序使用SMTP
            $mail->Host       = 'smtp.qq.com';  // 指定主邮件和备份SMTP服务器
            $mail->SMTPAuth   = true;                                   // 启用S​​MTP身份验证
            $mail->Username   = '1261335491@qq.com';                     // SMTP 用户名
            $mail->Password   = 'jpaujnhslxuzjcib';                               // SMTP 密码
            $mail->SMTPSecure = 'ssl';                                  // 启用TLS加密，`ssl`也接受
            $mail->Port       = 465;                                    // 要连接的TCP端口

            // 收件人设置
            $mail->setFrom('1261335491@qq.com', 'dx');      // 发送人
            // $mail->addAddress('joe@example.net', 'Joe User');     // 添加收件人
            $mail->addAddress($email);               // 名称是可选的

            // 内容
            $mail->isHTML(true);                                  // 将电子邮件格式设置为HTML
            $mail->Subject = $subject;     // 邮件的主题
            $mail->Body    = $body;   // 邮件的主体

            $res = $mail->send();  // 发送邮件
            if($res){
                session('body',$body);
                ok("获取验证码成功，请注意查收");
            }else{
                no("获取验证码失败，请重新获取");
            }   // 输出文本
        } catch (Exception $e) {
            no("Message could not be sent. Mailer Error: {$mail->ErrorInfo}"); // 捕捉异常
        }
    }
}
