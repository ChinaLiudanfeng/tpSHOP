<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Common extends Controller
{
    public function initialize()
    {
        if(!session("?info")){
            $this->error('请先登录','admin/login/login');
        }
    }
}
