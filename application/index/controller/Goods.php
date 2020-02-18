<?php

namespace app\index\controller;

class Goods extends Common
{
    //商品列表页
    public function index()
    {
        //接收分类ID
        $cate_id = input('get.cate_id',0,'intval');
        //判断分类ID是否有值
        if(empty($cate_id)){
            $where = [];
            session('where',null);
        }else{
            //查询分类表数据
            $cateInfo = model('Category')->select();
            //获取每一级子类ID
            $c_id = getCateIds($cateInfo,$cate_id);
            $where = [
                ['cate_id','in',$c_id]
            ];
            session('where',$where);
        }


        //获取品牌
        // dump($where);die;
        $brand_id = array_unique(model('Goods')->where($where)->column('brand_id'));
        $brandInfo = model('Brand')->where('brand_id','in',$brand_id)->select();
        //分配品牌
        $this->assign('brandInfo',$brandInfo);


        //获取价格
        $maxPrice = model('Goods')->where($where)->order('goods_price','desc')->value('goods_price');
        //获取价格区间
        $price = $this->getPriceSection($maxPrice);
        //分配价格区间
        $this->assign('price',$price);


        //商品查询条件
        $where[] = ['goods_up','=',1];
        //获取商品
        $goodsInfo = model('Goods')->where($where)->order('goods_num','desc')->page(1,2)->select();
        //分配商品
        $this->assign('goodsInfo',$goodsInfo);

        
        //获取分页
        $count = model('Goods')->where($where)->count();
        $page_obj = new \page\AjaxPage();
        $page_str = $page_obj->ajaxpager(1,$count,2);
        $this->assign('page_str',$page_str);

        //获取游览历史记录
        if($this->checkLogin()){
            //获取登录的游览历史记录
            $historyInfo = $this->getLogOnHistoryInfo();
        }else{
            //获取未登录的游览历史记录
            $historyInfo = $this->getLogOutHistoryInfo();
        }
        $this->assign('historyInfo',$historyInfo);

        //展示视图
        return view();
    }

    //获取登录的游览历史记录
    public function getLogOnHistoryInfo()
    {
        $user_id = $this->getUserId();
        $where = [
            ['user_id','=',$user_id]
        ];
        $goods_id = model('History')->where($where)->order('look_time','desc')->column('goods_id');
        if(empty($goods_id)){
            return false;
        }else{
            $goodsId = implode(',',array_slice($goods_id,0,3));
            // dump($goodsId);die;
            // 指定排序方式
            $where = [
                ['goods_up','=',1],
                ['goods_id','in',$goodsId]
            ];
            $exp = new \think\db\Expression("field(goods_id,$goodsId)");
            $historyInfo = model('Goods')->where($where)->order($exp)->select();
            // dump($historyInfo);die;
            return $historyInfo;
        }
        
        
    }

    //获取未登录的游览历史记录
    public function getLogOutHistoryInfo()
    {
        $str = cookie('goodsInfo');
        if(empty($str)){
            return false;
        }else{
            $goods_id = $this->jmBase64($str);
            $newGoods_id = array_reverse($goods_id);
            $g_id = [];
            foreach ($newGoods_id as $k => $v) {
                $g_id[] = $v['goods_id'];
            }
            $g_id = implode(',',array_slice(array_unique($g_id),0,3));
            $where = [
                ['goods_up','=',1],
                ['goods_id','in',$g_id]
            ];
            $exp = new \think\db\Expression("field(goods_id,$g_id)");
            $historyInfo = model('Goods')->where($where)->order($exp)->select();
            return $historyInfo;
        }
    }

    //更新价格
    public function getNewPrice()
    {
        //接收ajax传入的品牌id
        $brand_id = input('post.brand_id',0,'intval');
        //判断品牌是否为空，用于更新点击关闭面包屑导航上的品牌
        if(empty($brand_id)){
            $where = [
                ['goods_up','=',1]
            ];
        }else{
            //查询品牌下商品的查询条件
            $where = [
                ['brand_id','=',$brand_id],
                ['goods_up','=',1]
            ];
        }
        // print_r($where);
        //获取session中子级分类的id查询条件
        $cate_where = session('where');
        //判断点击为全部商品还是分类下商品,全部商品session为空,点击分类下商品则取出点击分类的子类ID
        if(!empty($cate_where)){
            $where[] = $cate_where[0];
        }
        //查询最大商品价格
        $maxPrice = model('Goods')->where($where)->order('goods_price','desc')->value('goods_price');
        //获取价格区间
        $goodsPrice = $this->getPriceSection($maxPrice);
        //返回json类型价格区间
        echo json_encode($goodsPrice);
    }

    //获取价格区间
    public function getPriceSection($maxPrice)
    {
        $price = $maxPrice/7;
        $priceSection = [];
        for ($i=0; $i < 6; $i++) { 
            $start = $price*$i;
            $end = $price*($i+1)-0.01;
            $priceSection[] = number_format($start,2)."-".number_format($end,2);//number_format("处理的字符串",'保留的小数')   去除多余小数
        }
        $priceSection[] = number_format($end+0.01,2)."及以上";
        return $priceSection;
    }

    //更新商品数据
    public function getGoodsInfo()
    {
        $p = input('post.p',1,'intval');
        $brand_id = input('brand_id',0,'intval');
        // echo $brand_id;die;
        $price = input('post.price');
        $order_field = input('post.order_field');
        $order_type = input('post.order_type');
        $field = input('post.field');
        // echo $order_field;die;
        $where = session('where');
        
        $goods_where = [];
        if(!empty($brand_id)){
            $goods_where[] = ['brand_id','=',$brand_id];
        }

        if(!empty($price)){
            if(substr_count($price,'-')>0){
                $price = explode("-", str_replace(",", '', $price));
                $goods_where[] = ['goods_price','between',$price];
            }else{
                $price = (int)str_replace(",", '', $price);
                $goods_where[] = ['goods_price','>=',$price];
            }
        }

        if(!empty($field)){
            $goods_where[] = [$field,'=',1];
        }

        if(!empty($where)){
            $goods_where[] = $where[0];
        }
        // print_r($goods_where);die;
        $goodsInfo = model('Goods')->where($goods_where)->order($order_field,$order_type)->page($p,2)->select();
        // echo model('Goods')->getLastSql();die;

        $count = model('Goods')->where($goods_where)->count();
        // echo $count;die;
        $page_obj = new \page\AjaxPage();
        $page_str = $page_obj->ajaxpager($p,$count,2);
        $this->assign('page_str',$page_str);

        $this->assign('goodsInfo',$goodsInfo);
        echo $this->fetch();
    }


    //商品详情页
    public function product()
    {
        $goods_id  = input('get.goods_id',0,'intval');
        if(empty($goods_id)){
            $this->error('请至少选择一件商品','index/index');
        }
        $where = [
            ['goods_up','=',1],
            ['goods_id','=',$goods_id]
        ];
        $goodsInfo = model('Goods')->where($where)->find();
        if(empty($goodsInfo)){
            $this->error('没有此商品信息','index/index');
        }

        //游览历史记录
        if($this->checkLogin()){
            //登录状态，把游览记录存入数据库
            $this->saveHistoryDb($goods_id);
        }else{
            //未登录状态，把游览记录存入Cookie
            $this->saveHistoryCookie($goods_id);
        }
        $this->assign('goodsInfo',$goodsInfo);
        //获取登录状态显示
        $user_name = model('Users')->field('user_email')->where('user_id',$this->getUserId())->find();
        $this->assign('user_name',$user_name);
        return $this->fetch();
    }

    //评论添加
    public function comment()
    {
        $data = input('post.');
        //验证验证码
        if(!captcha_check($data['user_code'])){
            echo json_encode(['font'=>"验证码错误",'err'=>2]);die;
        };
        //判断是否登录
        if($this->checkLogin()){
            $data['user_id'] = $this->getUserId();
        }else{
            $data['user_name'] = "匿名用户";
        }
        $data['user_ip'] = request()->ip();
        $res = model('Comment')->save($data);
        if($res){
            echo json_encode(['font'=>"发布成功",'err'=>1]);
        }else{
            echo json_encode(['font'=>"发布失败",'err'=>2]);
        }

    }




    //游览历史记录存入数据库
    public function saveHistoryDb($goods_id)
    {
        $user_id = $this->getUserId();
        $historyInfo = ['goods_id'=>$goods_id,'look_time'=>time(),'user_id'=>$user_id];
        $res = model('History')->save($historyInfo);
    }
    //游览历史记录存入Cookie
    public function saveHistoryCookie($goods_id)
    {
        $info = cookie('goodsInfo');
        if(empty($info)){
            $goodsInfo = [
                ['goods_id'=>$goods_id,'look_time'=>time()]
            ];
            $goodsInfo = $this->setBase64($goodsInfo);
            cookie('goodsInfo',$goodsInfo);
        }else{
            $goodsInfo = $this->jmBase64($info);
            $goodsInfo[] = ['goods_id'=>$goods_id,'look_time'=>time()];
            $goodsInfo = $this->setBase64($goodsInfo);
            cookie('goodsInfo',$goodsInfo);
        }
    }






    //测试session cookie
    public function test()
    {
        $info = cookie('cartInfo');
        dump($this->jmBase64($info));
        // $where = session('where');
        // dump($where);
    }
}