<?php

namespace app\index\controller;

use think\facade\Request;

class Cart extends Common
{
    //加入购物车
    public function cartAdd()
    {
        //接收购买的商品id
        $goods_id = input('post.goods_id',0,'intval');
        //接收购买的商品数量
        $buy_number = input('post.buy_number',0,'intval');
        //判断商品id是否为空
        if(empty($goods_id)){
            no('请至少选择一件商品');
        }
        //判断商品数量是否为空
        if(empty($buy_number)){
            no('请至少购买一件商品');
        }
        $goodsWhere = [
            ['goods_id','=',$goods_id],
            ['goods_up','=',1]
        ];
        //根据商品id查询商品表,判断商品是否存在或者是否下架
        $goodsInfo = model('Goods')->where($goodsWhere)->find();
        if(empty($goodsInfo)){
            no('您要购买的商品不存在或已经下架');
        }
        //判断是否登录
        if($this->checkLogin()){
            //登录状态下把购买的商品信息存入数据库 购物车表中
            $this->addCartDb($goods_id,$buy_number,$goodsInfo['goods_price']);
        }else{
            //未登录状态下把商品信息存入cookie
            $this->addCartCookie($goods_id,$buy_number,$goodsInfo['goods_price']);
        }
    }

    //将要购买的商品信息存入数据库购物车表中
    public function addCartDb($goods_id,$buy_number,$add_price)
    {
        //获取登录用户的id
        $user_id = $this->getUserId();
        $where = [
            ['goods_id','=',$goods_id],
            ['user_id','=',$user_id],
            ['is_del','=',1]
        ];
        //根据用户id，商品id，和是否删除查询购物车表
        $cartInfo = model('Cart')->where($where)->find();
        // 判断是否查到信息，查到说明已经加入过购物车，未查到说明第一次添加
        if(empty($cartInfo)){
            // 未加入购物车--添加
            // 检测库存
            $result = $this->checkGoodsNumber($goods_id,$buy_number);
            if($result){
                no('库存不足咯~~~');
            }
            $addCartInfo = ['goods_id'=>$goods_id,'buy_number'=>$buy_number,'user_id'=>$user_id,'add_price'=>$add_price];
            $res = model('Cart')->save($addCartInfo);
            if($res){
                ok('加入购物车成功');
            }else{
                no('加入购物车失败');
            }
        }else{
            //检测库存
            $result = $this->checkGoodsNumber($goods_id,$buy_number,$cartInfo['buy_number']);
            if($result){
                no('库存不足咯~~~');
            }
            // 加入过购物车--修改
            $updCartInfo = ['buy_number'=>$cartInfo['buy_number']+$buy_number];
            $res = model('Cart')->where($where)->update($updCartInfo);
            if($res){
                ok('加入购物车成功');
            }else{
                no('加入购物车失败');
            }
        }
    }

    //将要购买的商品信息存入cookie中
    public function addCartCookie($goods_id,$buy_number,$add_price)
    {
        $str = cookie('cartInfo');
        // dump($str);die;
        //判断cookie中是否有信息，有则是添加过，没有则是第一次添加
        if(empty($str)){
            // 检测库存
            $result = $this->checkGoodsNumber($goods_id,$buy_number);
            if($result){
                no('库存不足咯~~~');
            }
            $cartInfo = [
                ['goods_id'=>$goods_id,'buy_number'=>$buy_number,'add_price'=>$add_price,'create_time'=>time(),'update_time'=>time()]
            ];
            $carInfo_str = $this->setBase64($cartInfo);
            cookie('cartInfo',$carInfo_str);
            ok('添加成功');
        }else{
            $cartInfo = $this->jmBase64($str);
            // dump($cartInfo);die;
            foreach($cartInfo as $k=>$v){
                if($v['goods_id']==$goods_id){
                    // 检测库存
                    $result = $this->checkGoodsNumber($goods_id,$buy_number,$v['buy_number']);
                    if($result){
                        no('库存不足咯~~~');
                    }
                    $cartInfo[$k]['buy_number'] = $v['buy_number']+$buy_number;
                    $cart_str = $this->setBase64($cartInfo);
                    cookie('cartInfo',$cart_str);
                    ok('累加成功');
                }
            }
            // 检测库存
            $result = $this->checkGoodsNumber($goods_id,$buy_number);
            if($result){
                no('库存不足咯~~~');
            }
            $cartInfo[] = ['goods_id'=>$goods_id,'buy_number'=>$buy_number,'add_price'=>$add_price,'create_time'=>time(),'update_time'=>time()];
            $carInfo_str = $this->setBase64($cartInfo);
            cookie('cartInfo',$carInfo_str);
            ok('追加成功');
        }
    }

    //购物车列表
    public function cartList()
    {
        if($this->checkLogin()){
            $cartInfo = $this->getCartInfoDb();
        }else{
            $cartInfo = $this->getCartInfoCookie();
        }
        $this->assign('cartInfo',$cartInfo);
        return $this->fetch();
    }

    //从数据库中拿购物车列表数据--登录状态
    public function getCartInfoDb()
    {
        $where = [
            ['user_id','=',$this->getUserId()],
            ['is_del','=',1]
        ];
        $info = model('Cart')->alias('c')->join('goods g','c.goods_id=g.goods_id')->where($where)->select();
        if(empty($info)){
            return false;
        }else{
            return $info;
        }
    }

    //从cookie中拿购物车列表数据--未登录状态
    public function getCartInfoCookie()
    {
        $str = cookie('cartInfo');
        if(!empty($str)){
            $cartInfo = $this->jmBase64($str);
            // dump($cartInfo);die;
            foreach($cartInfo as $k=>$v){
                // echo $v['goods_id'];
                $where = [
                    ['goods_id','=',$v['goods_id']]
                ];
                $goodsInfo = model('Goods')->where($where)->find();
                // dump($goodsInfo);
                if(!empty($goodsInfo)){
                    $goodsInfo = $goodsInfo->toArray();
                    $cartInfo[$k] = array_merge($v,$goodsInfo);
                }
                
                // dump($cartInfo);die;
                }
                if(empty($cartInfo)){
                    return false;
                }else{
                    // dump($cartInfo);die;
                    return $cartInfo;
                }
        }
    }

    //修改购买数量
    public function changeGoodsNumber()
    {
        $goods_id = input('post.goods_id',0,'intval');
        $buy_number = input('post.buy_number',0,'intval');
        if($this->checkLogin()){
            $this->changeGoodsNumberDb($goods_id,$buy_number);
        }else{
            $this->changeGoodsNumberCookie($goods_id,$buy_number);
        }
    }

    //修改数据库中购买数量
    public function changeGoodsNumberDb($goods_id,$buy_number)
    {
        $where = [
            ['goods_id','=',$goods_id],
            ['user_id','=',$this->getUserId()],
            ['is_del','=',1]
        ];
        //检测库存
        $result = $this->checkGoodsNumber($goods_id,$buy_number);
        if($result){
            no('库存不足咯~~~');
        }
        $res = model('Cart')->where($where)->update(['buy_number'=>$buy_number]);
        if(empty($res)){
            no('不能再少了~~');
        }else{
            ok('');
        }
    }

    //修改cookie中的购买数量
    public function changeGoodsNumberCookie($goods_id,$buy_number)
    {
        $str = cookie('cartInfo');
        if(!empty($str)){
            $cartInfo = $this->jmBase64($str);
            foreach($cartInfo as $k=>$v){
                if($v['goods_id']==$goods_id){
                    $result = $this->checkGoodsNumber($goods_id,$buy_number);
                    if($result){
                        no('库存不足咯~~~');
                    }
                    $cartInfo[$k]['buy_number'] = $buy_number;
                }
            }
            $cart_str = $this->setBase64($cartInfo);
            cookie('cartInfo',$cart_str);
            ok('');
        }
    }
    
    //重新获取小计
    public function getSubtotal()
    {
        $goods_id = input('post.goods_id',0,'intval');
        if($this->checkLogin()){
           $where = [
                ['c.goods_id','=',$goods_id],
                ['user_id','=',$this->getUserId()],
                ['is_del','=',1]
           ]; 
           $info = model('Cart')->field('goods_price,buy_number')->alias('c')->join('goods g','c.goods_id=g.goods_id')->where($where)->find();
           if(!empty($info)){
                $suntotal = $info['goods_price']*$info['buy_number'];
                echo $suntotal;
           }
        }else{
            $str = cookie('cartInfo');
            if(!empty($str)){
                $cartInfo = $this->jmBase64($str);
                foreach ($cartInfo as $k => $v) {
                    if($v['goods_id']==$goods_id){
                        $buy_number = $v['buy_number'];
                    }
                }
            }
            $goods_price = model('Goods')->where('goods_id',$goods_id)->value('goods_price');
            echo $goods_price*$buy_number;
        }
    }

    //从新获取总价
    public function getTotalPrice()
    {
        $goods_id = input('post.gid');
        $goods_id = explode(',',rtrim($goods_id,','));
        if(empty($goods_id)){
            echo 0;die;
        }
        if($this->checkLogin()){
            $totalPrice = 0;
            $where = [
                ['c.goods_id','in',$goods_id],
                ['user_id','=',$this->getUserId()],
                ['is_del','=',1]
            ];
            $info = model('Cart')->field('goods_price,buy_number')->alias('c')->join('goods g','c.goods_id=g.goods_id')->where($where)->select();
            foreach($info as $k=>$v){
                $totalPrice += $v['goods_price']*$v['buy_number'];
            }
            echo $totalPrice;
        }else{
            $goodsInfo = model('Goods')->field('goods_id,goods_price')->where('goods_id','in',$goods_id)->select();
            $str = cookie('cartInfo');
            if(!empty($str)){
                $cartInfo = $this->jmBase64($str);
            }
            // dump($cartInfo);die;
            foreach ($goodsInfo as $k => $v) {
                foreach ($cartInfo as $key => $value) {
                    if($v['goods_id']==$value['goods_id']){
                        $goodsInfo[$k]['buy_number'] = $value['buy_number'];
                    }
                }
            }
            $totalPrice = 0;
            foreach ($goodsInfo as $k => $v) {
                $totalPrice += $v['goods_price']*$v['buy_number'];
            }
            echo $totalPrice;
        }
    }

    //点击删除
    public function cartDel()
    {
        $goods_id = input('post.goods_id');
        if($this->checkLogin()){
            $where = [
                ['goods_id','in',$goods_id],
                ['user_id','=',$this->getUserId()],
                ['is_del','=',1]
            ];
            $res = model('Cart')->where($where)->update(['is_del'=>2]);
            if(!empty($res)){
                echo 1;
            }else{
                echo 2;
            }
        }else{
            $str = cookie('cartInfo');
            if(!empty($str)){
                $cartInfo = $this->jmBase64($str);
            }
            $goods_id = explode(',', $goods_id);
            foreach ($cartInfo as $k => $v) {
                if(in_array($v['goods_id'],$goods_id)){
                    unset($cartInfo[$k]);
                }
            }
            if(empty($cartInfo)){
                cookie('cartInfo',null);
                echo 1;
            }else{
                $cart_str = $this->setBase64($cartInfo);
                cookie('cartInfo',$cart_str);
                echo 1;
            }
        }
    }

    //确认结算
    public function settlement()
    {
        $goods_id = input('get.goods_id');
        if(empty($goods_id)){
            $this->error('请至少选择一件商品');die;
        }
        if(!$this->checkLogin()){
            $this->error('请先登录','Login/login');die;
        }
        //获取商品信息
        $where = [
            ['c.goods_id','in',$goods_id],
            ['user_id','=',$this->getUserId()],
            ['is_del','=','1']
        ];
        $info = model('Cart')->alias('c')->join('goods g','c.goods_id=g.goods_id')->where($where)->select();
        $this->assign('info',$info);
        //获取总价
        $amount = 0;
        foreach ($info as $k => $v) {
            $amount += $v['buy_number']*$v['goods_price'];
        }
        $this->assign('amount',$amount);
        //获取收货地址信息
        $addressInfo = $this->getAddressInfo();
        $this->assign('addressInfo',$addressInfo);
        return $this->fetch();
    }
}
