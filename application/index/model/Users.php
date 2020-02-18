<?php

namespace app\index\model;

use think\Model;

class Users extends Model
{
    protected $pk = "user_id";
    protected function setUserPwdAttr($value)
    {
    	return md5($value);
    }
}