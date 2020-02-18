<?php /*a:1:{s:87:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\index\view\goods\get_goods_info.html";i:1557390041;}*/ ?>
<ul class="cate_list">
    <?php if(is_array($goodsInfo) || $goodsInfo instanceof \think\Collection || $goodsInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $goodsInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
	<li>
    	<div class="img"><a href="<?php echo url('Goods/product'); ?>?goods_id=<?php echo htmlentities($v['goods_id']); ?>"><img src="/uploads1/<?php echo htmlentities($v['goods_img']); ?>" width="210" height="185" /></a></div>
        <div class="price">
            <font>￥<span><?php echo htmlentities($v['goods_price']); ?></span></font> &nbsp; 26R
        </div>
        <div class="name"><a href="<?php echo url('Goods/product'); ?>?goods_id=<?php echo htmlentities($v['goods_id']); ?>"><?php echo htmlentities($v['goods_name']); ?></a></div>
        <div class="carbg">
        	<a href="#" class="ss">收藏</a>
            <a href="#" class="j_car">加入购物车</a>
        </div>
    </li>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</ul>

<div class="pages">
	<?php echo $page_str; ?>
</div>