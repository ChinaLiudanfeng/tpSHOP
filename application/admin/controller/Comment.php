<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Comment extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //获取列表信息
        $info = model('Comment')->alias('c')->join('goods g',"g.goods_id=c.goods_id")->join('users u',"u.user_id=c.user_id")->paginate(3);
        // dump($info);die;
        $this->assign('info',$info);
        // $this->assign('str',$str);
        return $this->fetch();
    }


    //修改状态
    public function upd()
    {
        $c_id = input('post.c_id');
        $status = input('post.status');
        $res = model('Comment')->where('c_id',$c_id)->update(['status'=>$status]);
        if($res>0){
            echo 1;
        }else{
            echo 2;
        }
    }
    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
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
    public function edit($id)
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
}
