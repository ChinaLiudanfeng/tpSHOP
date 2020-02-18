<?php /*a:1:{s:87:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\ooxx\view\goods\get_brand_goods.html";i:1557052365;}*/ ?>
<div class="list_c" id="div">
    
    <ul class="cate_list">
        <?php if(is_array($brand_goods) || $brand_goods instanceof \think\Collection || $brand_goods instanceof \think\Paginator): $i = 0; $__LIST__ = $brand_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$g): $mod = ($i % 2 );++$i;?>
        <li>
            <div class="img"><a href="#"><img src="<?php echo htmlentities($g['goods_img']); ?>" width="210" height="185" /></a></div>
            <div class="price">
                <font>￥<span><?php echo htmlentities($g['goods_price']); ?></span></font> &nbsp; 26R
            </div>
            <div class="name"><a href="#"><?php echo htmlentities($g['goods_name']); ?></a></div>
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
    
    
    
</div>