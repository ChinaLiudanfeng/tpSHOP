<?php /*a:1:{s:86:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\ooxx\view\index\get_next_goods.html";i:1557394000;}*/ ?>
<div cate_id="<?php echo htmlentities($info['topInfo']['cate_id']); ?>">
    <div class="i_t mar_10">
        <span class="floor_num"><?php echo htmlentities($floor_num); ?>F</span>
        <span class="fl"><?php echo htmlentities($info['topInfo']['cate_name']); ?></span>                
        <span class="i_mores fr">
            <?php if(is_array($info['sonInfo']) || $info['sonInfo'] instanceof \think\Collection || $info['sonInfo'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['sonInfo'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <a href="#"><?php echo htmlentities($v['cate_name']); ?></a> &nbsp;
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </span>
    </div>
    <div class="content">

        <div class="fresh_mid">
            <ul>
                <?php if(is_array($info['goodsInfo']) || $info['goodsInfo'] instanceof \think\Collection || $info['goodsInfo'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['goodsInfo'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <li>
                    <div class="name"><a href="<?php echo url('Goods/product'); ?>?goods_id=<?php echo htmlentities($v['goods_id']); ?>"><?php echo htmlentities($v['goods_name']); ?></a></div>
                    <div class="price">
                        <font>￥<span><?php echo htmlentities($v['goods_price']); ?></span></font> &nbsp; 26R
                    </div>
                    <div class="img"><a href="<?php echo url('Goods/product'); ?>?goods_id=<?php echo htmlentities($v['goods_id']); ?>"><img src="<?php echo htmlentities($v['goods_img']); ?>" width="185" height="155" /></a></div>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>                                                          
            </ul>
        </div>

    </div>
</div>