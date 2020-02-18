<?php /*a:2:{s:78:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\goods\index.html";i:1555921970;s:73:"F:\phpStudy\PHPTutorial\WWW\mouth5\tp5\application\admin\view\layout.html";i:1556108761;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>layout 后台大布局 - Layui</title>
  <link rel="stylesheet" href="/static/layui/css/layui.css">
  <script type="text/javascript" src="/static/layui/layui.js"></script>
  <script type="text/javascript" src="/static/jquery-3.3.1.js"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">layui 后台布局</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="">控制台</a></li>
      <li class="layui-nav-item"><a href="">商品管理</a></li>
      <li class="layui-nav-item"><a href="">用户</a></li>
      <li class="layui-nav-item">
        <a href="javascript:;">其它系统</a>
        <dl class="layui-nav-child">
          <dd><a href="">邮件管理</a></dd>
          <dd><a href="">消息管理</a></dd>
          <dd><a href="">授权管理</a></dd>
        </dl>
      </li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
          <?php echo htmlentities(app('session')->get('info.a_name')); ?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="">基本资料</a></dd>
          <dd><a href="">安全设置</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item"><a href="javascript:void(0)" id="logout">退了</a></li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <li class="layui-nav-item"><a href="<?php echo url('admin/category/index'); ?>">分类列表</a></li>
        <li class="layui-nav-item"><a href="<?php echo url('admin/brand/index'); ?>">品牌分类</a></li>
        <li class="layui-nav-item"><a href="<?php echo url('admin/goods/index'); ?>">商品管理</a></li>
        <li class="layui-nav-item"><a href="<?php echo url('admin/yqlink/index'); ?>">友情链接</a></li>
        <li class="layui-nav-item">
          <a href="javascript:;">解决方案</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;">列表一</a></dd>
            <dd><a href="javascript:;">列表二</a></dd>
            <dd><a href="">超链接</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item"><a href="">云市场</a></li>
        <li class="layui-nav-item"><a href="">发布商品</a></li>
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
      <a class="layui-btn layui-btn-radius layui-btn-normal" href="<?php echo url('create'); ?>">添加商品</a>
<div style="margin-top:10px;">
  <form class="layui-form" action="">
      <div class="layui-input-inline">
        <select name="cate_id">
          <option value="">请选择分类</option>
          <?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>
          <option value="<?php echo htmlentities($cate['cate_id']); ?>"><?php echo str_repeat("&ensp;",$cate['lev']*5); ?><?php echo htmlentities($cate['cate_name']); ?></option>
          <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
      </div>
      <div class="layui-input-inline">
        <select name="brand_id">
          <option value="">请选择品牌</option>
          <?php if(is_array($brand) || $brand instanceof \think\Collection || $brand instanceof \think\Paginator): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brand): $mod = ($i % 2 );++$i;?>
          <option value="<?php echo htmlentities($brand['brand_id']); ?>"><?php echo htmlentities($brand['brand_name']); ?></option>
          <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
      </div>
      <div class="layui-input-inline">
        <input type="text" name="goods_name" placeholder="请输入商品关键字" autocomplete="off" class="layui-input">
      </div>
      <div class="layui-input-inline">
        <button class="layui-btn" lay-submit lay-filter="search">搜索</button>
      </div>
  </form>
</div>
<table id="demo" lay-filter="test">
  <script type="text/html" id="cateTpl">
    {{d.cate.cate_name}}
  </script>
  <script type="text/html" id="brandTpl">
    {{d.brand.brand_name}}
  </script>
  <script type="text/html" id="imgTpl">
    <img src="{{d.goods_img}}" width="30" height="30">
  </script>
  <script type="text/html" id="czTpl">
      <div class="layui-btn-group">
        <button class="layui-btn layui-btn-sm" lay-event="edit">
          <i class="layui-icon">&#xe642;</i>
        </button>
        <button class="layui-btn layui-btn-sm" lay-event="del">
          <i class="layui-icon">&#xe640;</i>
        </button>
      </div>
  </script>
</table>
<script type="text/javascript">
  layui.use(['table','form','jquery'],function(){
    var table = layui.table,form = layui.form,$ = layui.jquery;
    var tableIns = table.render({
     elem:'#demo'
     ,url:"<?php echo url('indexData'); ?>"
     ,page:true
     ,limit:2
     ,limits:[2,4,6,8,10]
     ,cols:[[
        {field:'goods_id',title:'编号',width:50},
        {field:'goods_name',title:'商品名称'},
        {field:'goods_price',title:'价格'},
        {field:'goods_up',title:'是否上架'},
        {field:'goods_num',title:'库存'},
        {title:'封面图',templet: '#imgTpl'},
        {title:'分类',templet: '#cateTpl'},
        {title:'品牌',templet: '#brandTpl'},
        {title:'操作',templet: '#czTpl'},
     ]]
    });
    table.on('tool(test)', function(obj){
        var data = obj.data; //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
        var tr = obj.tr; //获得当前行 tr 的DOM对象
        if(layEvent === 'del'){ //删除
          layer.confirm('真的删除行么', function(index){
            obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
          });
        } else if(layEvent === 'edit'){ //编辑
          location.href = '<?php echo url("edit"); ?>?goods_id='+data.goods_id;
          
          //同步更新缓存对应的值
          obj.update({
            username: '123'
            ,title: 'xxx'
          });
        }
    });
    form.on("submit(search)",function(data){
      tableIns.reload({
        where: data.field
        ,page: {curr: 1 }
      });
      return false;
    });
  });
</script>
    </div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>
</div>
<script>
//JavaScript代码区域
layui.use(['element','jquery','layer'], function(){
  var element = layui.element
  ,layer = layui.layer
  ,$ = layui.jquery;

  $('#logout').click(function(){
      layer.confirm('确定退出吗？',{icon:3,title:'提示'},function(){
          location.href = "<?php echo url('admin/login/logout'); ?>";
      })
  })
  
});
</script>
</body>
</html>