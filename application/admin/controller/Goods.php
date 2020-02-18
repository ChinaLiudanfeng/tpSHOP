<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Request;

class Goods extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $cate = getCateInfo(model('Cate')->select());
        $brand = model('Brand')->select();
        $this->assign('cate',$cate);
        $this->assign('brand',$brand);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $cate = getCateInfo(model('Cate')->select());
        $brand = model('Brand')->select();
        $this->assign('cate',$cate);
        $this->assign('brand',$brand);
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save()
    {
        if(Request::isPost()&&Request::isAjax()){
            $data = Request::post();
            if(!validate('Goods')->check($data)){
                no(validate('Goods')->getError());
            }
            $res = model('Goods')->save($data);
            $res ? ok() : no();
        }
    }

    public function indexData()
    {
        $cate_id = Request::param('cate_id');
        $brand_id = Request::param('brand_id');
        $goods_name = Request::param('goods_name');
        $where = [];
        if(!empty($cate_id)){
            $where [] = ['cate_id','=',$cate_id];
        }
        if(!empty($brand_id)){
            $where [] = ['brand_id','=',$brand_id];
        }
        if(!empty($goods_name)){
            $where [] = ['goods_name','like',"%$goods_name%"];
        }
        $page = Request::Get('page');
        $limit = Request::Get('limit');
        $data = model('Goods')->with('cate,brand')->where($where)->page($page,$limit)->select();
        // dump($data);die;
        $count = model('Goods')->where($where)->count();
        // dump($count);die;
        $indexData = [
            "code" => 0,
            "msg" => '',
            "count" => $count,
            "data" => $data
        ];
        echo json_encode($indexData);
        // "code": res.status, //解析接口状态
        // "msg": res.message, //解析提示文本
        // "count": res.total, //解析数据长度
        // "data": res.data.item //解析数据列表
    }
    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit()
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }

    // public function upload()
    // {
    //     $file = Request::file('file');
    //     $info = $file->validate(['size'=>204800,'ext'=>'jpg,png,jpeg'])->move( 'uploads/goods');
    //     if($info){
    //         $saveName = $info->getSaveName();
    //         $path = str_replace('\\', '/', "/uploads/goods/$saveName");
    //         echo json_encode(['msg'=>'上传成功','icon'=>6,'err'=>1,'path'=>$path]);
    //     }else{
    //         no($file->getError());
    //     }
    // }

    // public function uploads()
    // {
    //     $file = Request::file('file');
    //     $confing = [
    //         's'=>['width'=>100,'height'=>100,'path'=>'./uploads/goods/small/'.date('Ymd').'/','name'=>uniqid().'.jpeg'],
    //         'm'=>['width'=>200,'height'=>200,'path'=>'./uploads/goods/middle/'.date('Ymd').'/','name'=>uniqid().'.jpeg'],
    //         'b'=>['width'=>300,'height'=>300,'path'=>'./uploads/goods/big/'.date('Ymd').'/','name'=>uniqid().'.jpeg']
    //     ];
    //     $path = [];
    //     foreach($confing as $k => $v){
    //         $image = \think\Image::open($file);
    //         if(!is_dir($v['path'])){
    //             mkdir($v['path'],0777,true);
    //         }
    //         $image->thumb($v['width'], $v['height'])->save($v['path'].$v['name']);
    //         $path[$k] = ltrim($v['path'].$v['name'],'.');        
    //     }
    //     echo json_encode($path);
    // }

    public function upload()
    {
        $file = Request::file('file');
        $info = $file->validate(['size'=>204800,'ext'=>'jpg,png,jpeg'])->move('./uploads/goods');
        if($info){
            // $path = "uploads/goods/".$info->getSaveName();
            $saveName = $info->getSaveName();
            $path = str_replace('\\', '/', "/uploads/goods/$saveName");
            echo json_encode(['msg'=>'添加成功','icon'=>6,'err'=>1,'path'=>$path]);
        }else{
            no($file->getError());
        }
    }

    public function uploads()
    {
        $file = Request::file('file');
        $confing = [
            's'=>['width'=>100,'height'=>100,'path'=>"./uploads/goods/small/".date('Ymd')."/",'name'=>uniqid().".jpeg"],
            'm'=>['width'=>200,'height'=>200,'path'=>"./uploads/goods/middle/".date('Ymd')."/",'name'=>uniqid().".jpeg"],
            'b'=>['width'=>300,'height'=>300,'path'=>"./uploads/goods/big/".date('Ymd')."/",'name'=>uniqid().".jpeg"]
        ];
        $path = [];
        foreach($confing as $k => $v){
            $image = \think\Image::open($file);
            if(!is_dir($v['path'])){
                mkdir($v['path'],0777,true);
            }
            $image->thumb($v['width'], $v['height'])->save($v['path'].$v['name']);
            $path[$k] = ltrim($v['path'].$v['name'],'.');
        };
        echo json_encode($path);
    }
    public function aa()
    {
        $data = model('Goods')->select();
        $this->assign('data',$data);
        return $this->fetch();
    }
}