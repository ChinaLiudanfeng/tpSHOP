<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Request;

class Category extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $cate = model('Cate')->select();
        $data = getCateInfo($cate);
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
        $cate = model('Cate')->where(['cate_show'=>1])->select();
        $data = getCateInfo($cate);
        $this->assign('data',$data);
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
            if(!validate('Category')->check($data)){
                no(validate('Category')->getError());
            }
            $res = model('Cate')->save($data);
            $res ? ok() : no();
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
       // $data = model('Cate')->select()->toArray();
       // $arr = getCateInfo($data);
       // dump($arr);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $data = model('Cate')->find($id);
        $this->assign('data',$data);
        $cates = model('Cate')->where(['cate_show'=>1])->select();
        $cate = getCateInfo($cates);
        $this->assign('cate',$cate);
        return view();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request)
    {
        $data = $request->post();
        if(!validate('Category')->check($data)){
                no(validate('Category')->getError());
        }
        $res = model('Cate')->save($data,['cate_id'=>$data['cate_id']]);
        $res ? ok('修改成功') : no('修改失败');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete()
    {
        $id = request()->post('cate_id');
        $res = model('Cate')::destroy($id);
        $res ? ok('删除成功') : no('删除失败');
    }
    public function editTable(){
        if(Request::isPost()&&Request::isAjax()){
            $id = Request::post('cate_id');
            $name = Request::post('cate_name');
            // if(!validate('Category')->check($name)){
            //     no(validate('Category')->getError());
            // }
            $res = model('Cate')->save(['cate_name'=>$name],['cate_id'=>$id]);
            $res ? ok() : no();
        }
    }
}
