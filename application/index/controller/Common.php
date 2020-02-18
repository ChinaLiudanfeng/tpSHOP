<?php

namespace app\index\controller;

use think\Controller;

class Common extends Controller
{
    public function initialize()
    {
    	$controller = request()->controller();
        if($controller == "Member"||$controller == "Address"){
            if(!session('?info')){
                $this->error('请先登录','Login/login');
            }
        }else if($controller == "Index"){
    		$leftNav = "leftNav";
            $this->assign('leftNav',$leftNav);
    	}else{
    		$leftNav = "leftNav none";
            $this->assign('leftNav',$leftNav);
    	}
    	$data = model('Category')->where(['cate_show'=>1])->select()->toArray();
    	$cate = getCateInfo($data);
    	$this->assign('cate',$cate);
    	$nav = model('Category')->where(['cate_nav'=>1])->select();
    	$this->assign('nav',$nav);
        $yqlink = model('Yqlink')->limit(5)->select();
        $this->assign('yqlink',$yqlink);
        // cookie('cartInfo',null);
    }

    //检查是否登录
    public function checkLogin()
    {
        return session('?info');
    }

    //获取登录用户的id
    public function getUserId()
    {
        return session('info.user_id');
    }

    //同步游览历史记录
    public function asyncHistory()
    {
        $histroyInfo = cookie('goodsInfo');
        if(!empty($histroyInfo)){
            $goodsInfo = array_slice(array_reverse($this->jmBase64($histroyInfo)),0,3);
            $user_id = $this->getUserId();
            foreach($goodsInfo as $k=>$v){
                $goodsInfo[$k]['user_id'] = $user_id;
            }
            $res = model('History')->saveAll($goodsInfo);
            if($res){
                cookie('goodsInfo',null);
            }
        }
    }

    //同步加入购物车
    public function asyncCart()
    {
        $str = cookie('cartInfo');
        if(!empty($str)){
            $cartInfo = $this->jmBase64($str);
            $user_id = $this->getUserId();
            foreach($cartInfo as $k=>$v){
                $v['user_id'] = $user_id;
                $where = [
                    ['goods_id','=',$v['goods_id']],
                    ['user_id','=',$user_id],
                    ['is_del','=',1]
                ];
                $info = model('Cart')->where($where)->find();
                if(!empty($info)){
                    $res = $this->checkGoodsNumber($v['goods_id'],$v['buy_number'],$info['buy_number']);
                    if($res){
                        continue;
                    }
                    model('Cart')->where($where)->update(['buy_number'=>$v['buy_number']+$info['buy_number']]);
                }else{
                    $res = $this->checkGoodsNumber($v['goods_id'],$v['buy_number']);
                    if($res){
                        continue;
                    }
                    model('Cart')->insert($v);
                }
            }
            cookie('cartInfo',null);
        }
    }
    
     //加密cookie
    public function setBase64($arr)
    {
        $goodsInfo = base64_encode(serialize($arr));
        return $goodsInfo;
    }

     //解密cookie
    public function jmBase64($str)
    {
        $goodsInfo = unserialize(base64_decode($str));
        return $goodsInfo;
    }

    // 检测库存
    public function checkGoodsNumber($goods_id,$buy_number,$cartNumber=0)
    {
        $goodsNumber = model('Goods')->where('goods_id',$goods_id)->value('goods_num');
        if($buy_number+$cartNumber>$goodsNumber){
            return true;
        }else{
            return false;
        }
    }

    //获取用户收货地址信息
    public function getAddressInfo()
    {
        $user_id = $this->getUserId();
        $where = [
            ['user_id','=',$user_id],
            ['is_del','=',1]
        ];
        $info = model('Address')->where($where)->select();
        if(!empty($info)){
            foreach($info as $k=>$v){
                $province = model('Area')->where('id',$v['province'])->find();
                $city = model('Area')->where('id',$v['city'])->find();
                $area = model('Area')->where('id',$v['area'])->find();
                $info[$k]['province'] = model('Area')->where('id',$v['province'])->find();
                $$info[$k]['city'] = model('Area')->where('id',$v['city'])->find();
                $$info[$k]['area'] = model('Area')->where('id',$v['area'])->find();
                $info[$k]['address'] = $province['name']."-".$city['name']."-".$area['name'];
            }
        }
        // dump(empty($info));die;
        if(count($info)==0){
            return false;
        }else{
             return $info;
        }
    }
}
