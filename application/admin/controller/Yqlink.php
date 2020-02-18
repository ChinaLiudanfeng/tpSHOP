<?php

namespace app\admin\controller;

use think\Controller;
use think\facade\Request;

class Yqlink extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return $this->fetch();
    }

    public function info()
    {
        $page = Request::param('page');
        $limit = Request::param('limit');
        $data = model('Yqlink')->page($page,$limit)->select();
        $count = model('Yqlink')->count();
        return [
            'code'=>0,
            'msg'=>'',
            'count'=>$count,
            'data'=>$data
        ];

      // "code": res.status, //解析接口状态
      // "msg": res.message, //解析提示文本
      // "count": res.total, //解析数据长度
      // "data": res.data.item //解析数据列表
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

    public function upload()
    {
        $file = Request::file('file');
        // dump($file);die;
        $info = $file->move('uploads/yqlink');
        if($info){
            $str = "/uploads/yqlink/".$info->getSaveName();
            $path = str_replace("\\", "/", $str);
            echo json_encode(['msg'=>'上传成功','icon'=>6,'err'=>1,'path'=>$path]);
        }else{
            no($file->getError());
        }
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
            $info = model('Yqlink')->where(['name'=>$data['name']])->count();
            if($info>0){
                no('该昵称已存在');
            }
            $res = model('Yqlink')->save($data);
            $res ? ok() : no();
        }
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
        if(Request::isPost()&&Request::isAjax()){

        }else{
            $id = Request::param('id');
            $yqlink = model('Yqlink')->find($id);
            $this->assign('yqlink',$yqlink);
            return $this->fetch();
        }
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
        $data = Request::post();
        $res = model('Yqlink')->save($data,['id'=>$data['id']]);
        $res? ok() : no();
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $res = model('Yqlink')->destroy($id);
        $res ? ok() : no();
    }
}
