<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/22
 * Time: 上午9:30
 */

namespace Admin\Controller;

use Think\Controller;

class AdminController extends Controller
{

    public function index()
    {

        $res = D('Admin')->getAllAdmin();
        $this->assign('admins',$res);
        $this->display();
    }

    //增加用户
    public function add()
    {

        if ($_POST) {

            $_POST['password'] = getMd5($_POST['password']);

            $res = D('Admin')->addAdmin($_POST);
            if ($res) {
                show(1, '添加成功');
            } else {
                show(0, '添加失败');
            }
        }

        $this->display();
    }

    //删除
    public function delete()
    {

        if ($_POST) {

            if (D('Admin')->deleteAdmin($_POST['id'], $_POST)) {
                show(1, '删除成功');
            } else {
                show(0, '删除失败');
            }
        }
    }

}