<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Request;
use app\admin\model\User;

class Admin extends Common
{
    public function add_admin()
    {
    	return $this->fetch();
    }
    public function create()
    {
    	$data = Request::post();
    	$m = new User;
    	$res = $m->save($data);
    	if($res){
    		$msg = ['err'=>1,'msg'=>'添加成功'];
    	}else{
    		$msg = ['err'=>0,'msg'=>'添加失败'];
    	}
    	echo json_encode($msg);
    }

    public function list()
    {
        if(Request::isGet()&&Request::isAjax()){
            $page = Request::get('page');
            $limit = Request::get('limit');
            $data = User::page($page,$limit)->all();
            $count = User::count();
            echo json_encode(['code'=>0,'msg'=>'成功','data'=>$data,'count'=>$count]);
        }else{
             return $this->fetch();
        }
    }

    public function update()
    {
        if(Request::isPost()&&Request::isAjax()){
            $data = Request::post();
            $res = User::update($data);
            if($res){
                $msg = ['err'=>1,'msg'=>'修改成功'];
            }else{
                $msg = ['err'=>0,'msg'=>'修改失败'];
            }
            echo json_encode($msg);
        }else{
            $id = Request::get('id');
            $data = User::find($id);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }

    public function delete()
    {
        $id = Request::get('id');
        $res = User::destroy($id);
        if($res){
            $msg = ['err'=>1,'msg'=>'删除成功'];
        }else{
            $msg = ['err'=>0,'msg'=>'删除失败'];
        }
        echo json_encode($msg);
    }

    public function field()
    {
        $data = Request::post();
        $field = [$data['field']=>$data['value'],'id'=>$data['id']];
        
        $res = User::update($field);
        if($res){
            $msg = ['err'=>1,'msg'=>'编辑成功'];
        }else{
            $msg = ['err'=>0,'msg'=>'编辑失败'];
        }
        echo json_encode($msg);
    }
}
