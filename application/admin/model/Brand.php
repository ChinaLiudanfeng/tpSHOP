<?php

namespace app\admin\model;

use think\Model;

class Brand extends Model
{
    protected $pk = 'brand_id';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'brand_time';
    protected function getBrandShowAttr($value){
    	return $value==1 ? "是" : '否';
    }
}
