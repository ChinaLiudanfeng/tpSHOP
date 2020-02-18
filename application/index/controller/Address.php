<?php

namespace app\index\controller;

use think\facade\Request;

class Address extends Common
{
	//列表展示
    public function addressList()
    {
    	// $this->getAddressInfo();
    	// 根据当前用户ID查询此用户的收货地址信息
    	$addressInfo = $this->getAddressInfo();
    	$this->assign('addressInfo',$addressInfo);
    	//获取所有省信息
    	$province = $this->getAreaInfo(0);
    	$this->assign('province',$province);
    	return $this->fetch();
    }

    //三级联动获取区域信息
    public function getAreaInfo($id)
    {
    	$where = [
    		['pid','=',$id]
    	];
    	$info = model('Area')->where($where)->select();
    	return $info;
    }

    //获取区县信息
    public function getArea()
    {
    	$id = input('post.id');
    	if(!empty($id)){
    		$areaInfo = $this->getAreaInfo($id);
    		echo json_encode($areaInfo);
    	}
    }

    //添加地址到数据库
    public function addressAdd()
    {
    	if(Request::isPost()&&Request::isAjax()){
    		$data = input('post.');
    		$user_id = $this->getUserId();
    		$data['user_id'] = $user_id;
    		//验证器验证
    		//懒得做.....
    		if($data['is_default']==1){
    			$where = [
    				['user_id','=',$user_id],
    				['is_del','=',1]
    			];
    			model('Address')->where($where)->update(['is_default'=>2]);
    		}
    		$res = model('Address')->save($data);
    		if($res){
    			ok('添加成功');
    		}else{
    			no('添加失败');
    		}
    	}
    }

    //设置默认收货地址
    public function addressSetDefault()
    {
    	if(Request::isPost()&&Request::isAjax()){
    		$address_id = input('post.address_id',0,'intval');
    		if(empty($address_id)){
    			$this->error('请至少选择一个默认收货地址','Address/addressList');
    		}
    		$user_id = $this->getUserId();
    		$where = [
    			['address_id','=',$address_id],
    			['user_id','=',$user_id]
    		];
    		model('Address')->where('user_id',$user_id)->update(['is_default'=>2]);
    		$res = model('Address')->where($where)->update(['is_default'=>1]);
    		if(!empty($res)){
    			ok('设置成功');
    		}else{
    			no('设置失败');
    		}
    	}
    }

    //删除收货地址
    public function addressDel()
    {
    	if(Request::isPost()&&Request::isAjax()){
    		$address_id = input('post.address_id',0,'intval');
    		if(empty($address_id)){
    			$this->error('请至少选择一个收货地址');
    		}
    		$where = [
    			['user_id','=',$this->getUserId()],
    			['address_id','=',$address_id]
    		];
    		$res = model('Address')->where($where)->update(['is_del'=>2]);
    		if(empty($res)){
    			no('删除失败');
    		}else{
    			ok('删除成功');
    		}
    	}
    }

    //编辑页面
    public function addressEdit()
    {
        $address_id = input('address_id',0,'intval');
        if(empty($address_id)){
            $this->error('请选择一个收货地址');die;
        }
        $info = model('Address')->where('address_id',$address_id)->find();
        $this->assign('info',$info);
        $a = model('Area')->where('id',$info['province'])->find();
        $b = model('Area')->where('id',$info['city'])->find();
        $c = model('Area')->where('id',$info['area'])->find();
        $this->assign('a',$a);
        $this->assign('b',$b);
        $this->assign('c',$c);
        $province = $this->getAreaInfo(0);
        $this->assign('province',$province);
        return $this->fetch();
    }

    //执行编辑
    public function addressUpd()
    {
        if(Request::isPost()&&Request::isAjax()){
            $data = input('post.');
            $address_id = input('post.address_id');
            $user_id = $this->getUserId();
            $data['user_id'] = $user_id;
            //验证器验证
            //懒得做.....
            if($data['is_default']==1){
                $where = [
                    ['user_id','=',$user_id],
                    ['is_del','=',1]
                ];
                model('Address')->where($where)->update(['is_default'=>2]);
            }
            // dump($data);die;
            $res = model('Address')->save($data,['address_id'=>$address_id]);
            if(!empty($res)){
                ok('修改成功');
            }else{
                no('修改失败');
            }
        }
    }
}
