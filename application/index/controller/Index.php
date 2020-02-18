<?php

namespace app\index\controller;


class Index extends Common
{
    public function index()
    {	
    	$cate_id = 1;
    	$info = $this->getGoodsFloor($cate_id);
    	$this->assign('info',$info);
        return $this->fetch();
    }

    public function getGoodsFloor($cate_id)
    {
    	$Floor['topInfo'] = model('Category')->field('cate_name,cate_id')->where('cate_id',$cate_id)->find();
    	$Floor['sonInfo'] = model('Category')->field('cate_name,cate_id')->where('cate_pid',$cate_id)->select();
    	$cateInfo = model('Category')->select();
    	$cateIds = getCateIds($cateInfo,$cate_id);
    	$where = [
    		['cate_id','in',$cateIds]
    	];
    	$Floor['goodsInfo'] = model('Goods')->where($where)->select();
    	// print_r($Floor['goodsInfo']);die;
    	return $Floor;
    }


    public function getNextFloor()
    {
    	$cate_id = input('post.cate_id');
    	$floor_num = input('post.floor_num');
    	$floor_num += 1;
        $topCount = model('Category')->where('cate_pid',0)->count();
        if($floor_num>$topCount){
            echo 1;die;
        }
    	$this->assign('floor_num',$floor_num);
    	$where[] = [
    		['cate_id','>',$cate_id],
    		['cate_pid','=',0]
    	];
    	$sonid = model('Category')->where($where)->order('cate_id','asc')->value('cate_id');
    	$info = $this->getGoodsFloor($sonid);
    	$this->assign('info',$info);
    	echo $this->fetch();
    }
}
