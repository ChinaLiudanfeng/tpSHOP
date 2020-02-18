<?php

namespace app\admin\model;

use think\Model;
use think\model\concern\SoftDelete;

class User extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
    protected $autoWriteTimestamp = true;
    protected $insert = ['a_salt'];
    protected $salt;
    protected function setASaltAttr(){
    	return $this->salt;
    }
    protected function setAPwdAttr($value){
    	// $this->salt = rand(1000,99999999);
    	$this->salt = create_salt();
    	$pwd = $value.$this->salt;
    	return md5($pwd);
    }
    protected function getStatusAttr($value){
        $arr = [1=>'正常',2=>'冻结'];
        return $arr[$value];
    }
}
