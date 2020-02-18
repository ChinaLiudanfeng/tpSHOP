<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Request;

class Login extends Controller
{
   public function login()
   {
        if(Request::isPost()&&Request::isAjax()){
            $data = Request::post();
            if(!captcha_check($data['a_code'])){
                no('验证码错误');die;
            }
            $user = db('user')->where(['a_name'=>$data['a_name']])->find();
            if(!$user){
                no('查无此人');die;
            }
            $pwd = md5($data['a_pwd'].$user['a_salt']);
            if($pwd != $user['a_pwd']){
                no('密码不正确');die;
            }else{
                $info = ['a_name'=>$user['a_name'],'id'=>$user['id']];
                session('info',$info);
                ok('登录成功');
            }
        }else{
            $this->view->engine->layout(false);
            return $this->fetch();
        }
   }

   public function logout()
   {
        session('info',null);
        $this->success('再见','admin/login/login');
   }
}
