<?php

namespace app\admin\model;

use think\Model;

class Cate extends Model
{
    protected $pk = 'cate_id';
    protected $table = 'category';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'cate_time';
    protected function getCateShowAttr($value){
    	return $value=='1'?'是':'否';
    }
    protected function getCateNavAttr($value){
    	return $value=='1'?'是':'否';
    }
}
