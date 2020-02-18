<?php

namespace app\index\controller;


class Order extends Common
{
    public function confirmOrder()
    {
    	$data = input('post.');
    	model('Order')->startTrans();
    	try{
    		$user_id = $this->getUserId();
    		//订单表添加信息
    		$info = [
    			'pay_type'=>$data['pay_type'],
    			'order_talk'=>$data['order_talk'],
    			'user_id'=>$user_id
    		];
    		$info['order_no'] = $this->getOrderNo();
    		$where = [
    			['g.goods_id','in',$data['goods_id']],
    			['goods_up','=',1],
    			['user_id','=',$user_id]
    		];
    		$goods_model = model('Goods');
    		$goodsInfo = $goods_model->field('buy_number,goods_price,goods_name,goods_img,g.goods_id')->alias('g')->join('Cart c','g.goods_id=c.goods_id')->where($where)->select();
    		$amount = 0;
    		foreach ($goodsInfo as $k => $v) {
    			$amount += $v['buy_number']*$v['goods_price'];
    		}
    		$info['order_amount'] = $amount;
    		$order_model = model('Order');
    		$res = $order_model->save($info);
    		if(empty($res)){
    			throw new \Exception('订单信息添加失败');
    		}
    		
    		
    		//订单收货地址表添加信息
    		$order_id = $order_model->order_id;
    		$addressInfo = model('Address')->where('address_id',$data['address_id'])->find();
    		if(empty($addressInfo)){
    			throw new \Exception('此收货地址不存在');
    		}
    		$addressInfo = $addressInfo->toArray();
    		$addressInfo['order_id'] = $order_id;
    		unset($addressInfo['create_time']);
    		unset($addressInfo['updale_time']);
    		$res1 = model('OrderAddress')->save($addressInfo);
    		if(empty($res1)){
    			throw new \Exception('订单收货地址信息添加失败');
    		}
    		//订单商品表添加信息
    		$goodsInfo = $goodsInfo->toArray();
    		foreach ($goodsInfo as $k => $v) {
    			$goodsInfo[$k]['order_id'] = $order_id;
    			$goodsInfo[$k]['user_id'] = $this->getUserId();
    		}
    		$res2 = model('OrderDetail')->saveAll($goodsInfo);
    		if(empty($res2)){
    			throw new \Exception('订单商品表信息添加失败');
    		}

    		//在购物车表删除已经购买的商品
    		$where = [
    			['goods_id','in',$data['goods_id']],
    			['user_id','=',$user_id]
    		];
    		$res3 = model('Cart')->where($where)->update(['is_del'=>2]);
    		if(empty($res3)){
    			throw new \Exception('购物车表清除信息失败');
    		}
    		//修改商品表的库存
    		foreach ($goodsInfo as $k => $v) {
    			$res4 = model('Goods')->where('goods_id',$v['goods_id'])->setDec('goods_num',$v['buy_number']);
    			// $res4 = false;
    			if(empty($res4)){
    				throw new \Exception('商品库存更改失败');
    			}
    		}
    		model('Order')->commit();
    		echo json_encode(['msg'=>'操作成功','err'=>1,'order_id'=>$order_id]);
    	}catch(\Exception $e){
    		model('Order')->rollback();
    		echo json_encode(['msg'=>$e->getMessage(),'err'=>2]);
    	}
    }

    //生成不重复的订单号
    public function getOrderNo()
    {
    	return time().rand(1000,9999).$this->getUserId();
    }

    //显示下单成功页面
    public function orderSuccess()
    {
    	$order_id = input('get.order_id');
    	$where = [
    		['order_id','=',$order_id],
    		['is_del','=',1]
    	];
    	$info = model('Order')->where($where)->find();
    	$this->assign('info',$info);
    	return $this->fetch();
    }

    //显示支付宝支付页面
    public function alipay()
    {
        $order_id = input('get.order_id');
        $config = config('alipay.');
        $info = model('Order')->where('order_id',$order_id)->find();
        if(empty($info)){
            $this->error('没有此订单信息');
        }
        include_once '../extend/alipay/pagepay/service/AlipayTradeService.php';
        include_once '../extend/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $info['order_no'];

        //订单名称，必填
        $subject = "网站支付宝支付";

        //付款金额，必填
        $total_amount = $info['order_amount'];

        //商品描述，可空
        $body = "暂无描述";

        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);

        $aop = new \AlipayTradeService($config);

        $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        //输出表单
        var_dump($response);
    }

    //同步通知
    public function returnUrl()
    {
        $data = input('get.');
        $res1 = model('Order')->where('order_no',$data['out_trade_no'])->find();
        if(empty($res1)){
            $this->error('没有此订单信息','index/index/index');die;
        }
        if($data['total_amount']!=$res1['order_amount']){
            $this->error('支付金额错误','index/index/index');die;
        }
        $config = config('alipay.');
        include_once "../extend/alipay/pagepay/service/AlipayTradeService.php";
        $aop = new \AlipayTradeService($config);
        $res2 = $aop->check($data);
        if(!$res2){
            $this->error('签名错误','index/index/index');
        }
        return $this->fetch();
        //charset=UTF-8
        //&out_trade_no=155857889739231
        //&total_amount=897.00
        //&sign=WT4SqwPZY5vkZnhI4Zj0%2BZ7KMUe95RY7FUrYyZXkq9Od%2FJXAmWxd0eGafhdNsIc6lX6qdeMJ9tfaGjhoWSkFr4bLRwcFXJc2PHT8ZZ5IGiD7g%2BT7hnhhAgAfF%2FrHaZcpnulZ9nPIA6LR99i2By%2FE0UelOQCAotMLI8iF%2Bun1hE9jHaxkukb2TYxbMFEvM%2BPt59aUVEZ%2BHxU6WuO%2FC2SAc0Z6AVCK2%2BGY5fnID5uLagUGrRIOJEBzK%2F89NPmnkND7cJG8jdmmq9dqVmJlSKP0X09jJpb9JyJ0nOH8x5GQBaSmiKX4ZmdBxw82dcYayWdLskzvbmk3c%2BJs%2FyjAjZbmxA%3D%3D
        //&trade_no=2019052322001418370500562536
        //&app_id=2016092900620874
        //&sign_type=RSA2
        //&seller_id=2088102177747994
        //&timestamp=2019-05-23+10%3A36%3A20
    }

    //异步通知
    //
}
