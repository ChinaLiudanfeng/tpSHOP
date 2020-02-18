<?php

namespace app\admin\model;

use think\Model;

class Goods extends Model
{
    protected $pk = "goods_id";

    public function Cate()
    {
    	return $this->belongsTo('Cate','cate_id','cate_id');
    }
    public function Brand()
    {
    	return $this->belongsTo('Brand','brand_id','brand_id');
    }
}
