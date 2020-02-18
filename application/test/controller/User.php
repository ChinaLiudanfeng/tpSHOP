<?php

namespace app\test\controller;

use think\Controller;

class User extends Controller
{
    //显示注册视图
    public function register()
    {
        return $this->fetch();
    }
    //验证用户名唯一
    public function checkName()
    {
        $user_name = input('post.user_name');
        $res = model('User')->where('user_name',$user_name)->count();
        if($res>0){
            echo 1;
        }else{
            echo 2;
        }

    }
    //注册
    public function registerDo()
    {
        $data = input('post.');
        //验证器验证
        if(!validate('User')->check($data)){
            echo json_encode(['font'=>validate('User')->getError(),'code'=>2]);die;
        }
        //验证 验证码
        if(!captcha_check($data['user_code']))
        {
            echo json_encode(['font'=>"验证码错误",'code'=>2]);die;
        }
        //入库
        $res1 = model('User')->save($data);
        $user_id = model('User')->user_id;
        $info = [
            'user_id'=>$user_id,
            'user_email'=>$data['user_email']
        ];
        $res2 = model('UserDetail')->save($info);
        if($res1&&$res2){
            echo json_encode(['font'=>"注册成功",'code'=>1]);
        }
    }
    //显示登录视图
    public function login()
    {
        return $this->fetch();
    }
    //登录
    public function loginDo()
    {
        $data = input('post.');
        $userInfo = model('User')->where('user_name',$data['user_name'])->find();
        if(empty($userInfo)){
            echo json_encode(['font'=>"用户名错误",'code'=>2]);die;
        }else if($userInfo['user_pwd']!=$data['user_pwd']){
            echo json_encode(['font'=>"密码错误",'code'=>2]);die;
        }else{
            $info = ['user_name'=>$userInfo['user_name'],'log_time'=>time(),'log_ip'=>request()->ip()];
            model('UserLog')->save($info);
            echo json_encode(['font'=>"登陆成功",'code'=>1]);
        }
    }
    //展示日志页面
    public function logList()
    {
        $info = model('UserLog')->page(1,2)->select();
        $count = model('UserLog')->count();
        $this->assign('info',$info);
        $obj = new \page\AjaxPage();
        $str = $obj->ajaxpager(1,$count,2);
        $this->assign('str',$str);
        return $this->fetch();
    }

    //分页
    public function page()
    {
        $p = input('post.p');
        $info = model('UserLog')->page($p,2)->select();
        $count = model('UserLog')->count();
        $this->assign('info',$info);
        $obj = new \page\AjaxPage();
        $str = $obj->ajaxpager($p,$count,2);
        $this->assign('str',$str);
        echo $this->fetch();
    }

    public function file()
    {
        return $this->fetch();
    }

    public function uploads()
    {
        $file = input('file.user_file');
        $info = $file->move('./uploads/');
        if($info){
            $path = $info->getSaveName();
            echo $path;
        }else{
            echo "上传失败";
        }
    }
}
