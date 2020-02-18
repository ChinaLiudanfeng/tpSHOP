<?php
	//分类导航展示
	function getCateInfo($data,$pid=0){
		$arr = [];
		foreach ($data as $k => $v) {
			if($v['cate_pid']==$pid){
				$v['son'] = getCateInfo($data,$v['cate_id']);
				$arr[] = $v;
			}
		}
		return $arr;
	}
	//获取分类子类Id
	function getCateIds($data,$cate_id=0){
		static $ids = [];
		foreach($data as $k => $v){
			if($v['cate_pid']==$cate_id){
				$ids[] = $v['cate_id'];
				getCateIds($data,$v['cate_id']);
			}
		}
		return $ids;
	}
	//获取价格区间
	function getPriceQj($maxPrice,$n=7){
		$price = ceil($maxPrice/$n);
		$section = [];
		for ($i=0; $i < $n-1; $i++) { 
			$start = $price*$i;
			$end = $price*($i+1)-1;
			$section[] = $start."-".$end;
		}
		$section[] = ($end+1)."及以上";
		return $section;
	}

	/*
		function getPrice($goodsPrice,$n=7)
	{
		$price = ceil($goodsPrice/$n);
		$section = [];
		for ($i=0; $i < $n-1; $i++) { 
			$start = $price*$i;
			$end = $price*($i+1)-1;
			$section[] = $start."-".$end;
		}
		$section[] = ($end+1)."及以上";
		return $section;
	}
	 */