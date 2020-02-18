<?php

namespace app\index\controller;

use think\Controller;

class Member extends Common
{
    public function index()
    {
    	return $this->fetch();
    }

    public function memberOrder()
    {
    	return $this->fetch();
    }
}
