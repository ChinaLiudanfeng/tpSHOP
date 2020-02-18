<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
	function ok($msg='操作成功',$icon=6,$err=1){
		echo json_encode(['msg'=>$msg,'icon'=>$icon,'err'=>$err]);die;
	}
	function no($msg='操作失败',$icon=5,$err=0){
		echo json_encode(['msg'=>$msg,'icon'=>$icon,'err'=>$err]);die;
	}

	function getNodeInfo($arr,$pid=0,$jb=1)
	{
		static $info = [];
		foreach ($arr as $k => $v) {
			if($v['pid']==$pid){
				$v['jb'] = $jb;
				$info[] = $v;
				getNodeInfo($arr,$v['id'],$jb+1);
			}
		}
		return $info;
	}