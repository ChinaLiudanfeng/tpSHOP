<?php
	function create_salt()
	{
		$str = "qwetesdkamvasdtrencxbozpxkc#!*$@123456789";
		$len = strlen($str)-7;
		$start = rand(0,$len);
		return substr(str_shuffle($str),$start,6);
	}


	function getCateInfo($data,$pid=0,$lev=0){
		static $cate = [];
		foreach($data as $k => $v){
			if($v['cate_pid']==$pid){
				$v['lev'] = $lev;
				$cate[] = $v;
				getCateInfo($data,$v['cate_id'],$lev+1);
			}
		}
		return $cate;
	}
	// function getBrandInfo($data,$pid=0,$lev=0)
	// {
	// 	static $info = [];
	// 	foreach($data as $k => $v){
	// 		if($v['pid']==$pid){
	// 			$v['lev'] = $lev;
	// 			$info[] = $v;
	// 			getBrandInfo($data,$v['brand_id'],$lev+1);
	// 		}

	// 	}
	// 	return $info;
	// }