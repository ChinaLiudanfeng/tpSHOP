<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Request;

class Brand extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data = model('Brand')->where('brand_show',1)->select();
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
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
            if(!validate('Brand')->check($data)){
                no(validate('Brand')->getError());
            }
            $res = model('Brand')->save($data);
            $res ? ok('添加成功') : no('添加失败');
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read()
    {
        $brand = model('Brand')->all()->toArray();
        $data = getBrandInfo($brand);
        dump($data);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $brand = model('Brand')->find($id);
        $this->assign('brand',$brand);
        return $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update()
    {
        if(Request::isPost()&&Request::isAjax()){
            $id = Request::param('brand_id');
            $brand = Request::param();
            if(!validate('Brand')->check($brand)){
                no(validate('Brand')->getError());
            }
            $res = model('Brand')->save($brand,['brand_id'=>$id]);
            $res ? ok('修改成功') : no('修改失败');
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        if(Request::isGet()&&Request::isAjax()){
            // $id = Request::param('id');
            // $data = model('Brand')::where('pid',$id)->count();
            // // echo $sql=model('Brand')->getLastSql();die;
            // // echo $data;die;
            // if($data>0){
            //     no('此分类下有子类');
            // }
            $res = model('Brand')::destroy($id);
            $res ? ok('删除成功') : no('删除失败');
        }
    }

    // public function edittable()
    // {
    //     if(Request::isPost()&&Request::isAjax()){
    //         $id = Request::param('brand_id');
    //         $data = Request::post();
    //         if(!validate('Brand')->check($data)){
    //             no(validate('Brand')->getError());
    //         }
    //         $res = model('Brand')->save($data,['brand_id'=>$id]);
    //         $res ? ok() : no();
    //     }
    // }

    public function upload()
    {
        $file = Request::file('brand_logofile');
        $info = $file->validate(['size'=>204800,'ext'=>'jpg,png'])->move( 'uploads/brand');
        if($info){
            $saveName = str_replace('\\', '/', $info->getSaveName());
            $path = "/uploads/brand/$saveName";
            echo json_encode(['msg'=>'上传成功','icon'=>6,'err'=>1,'path'=>$path]);
        }else{
            no($file->getError());
        }
    }
}
