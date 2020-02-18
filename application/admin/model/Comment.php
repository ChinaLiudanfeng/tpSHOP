<?php

namespace app\admin\model;

use think\Model;

class Comment extends Model
{
    protected $pk = "c_id";

    public function getStatusAttr($value){
    	return $value==1?"显示":"隐藏";
    }
}
