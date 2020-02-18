<?php

namespace app\test\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
	    "user_name"=>"require|alpha|length:3,15|unique:user"
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        "user_name.require"=>"用户名必填",
        "user_name.alpha"=>"用户名由3-15位字符",
        "user_name.lenght"=>"用户名由3-15位字符",
        "user_name.unique"=>"用户名已存在",
    ];
}
