<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/22
 * Time: 上午8:53
 */

namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller{

    public function index(){
        $this->display();
    }

    public function check(){

        $username = I('username');
        $password  = I('password');

        $res = D('Admin')->getAdminByUsername($username);
        if(!$res){
            show(0,'用户名不存在');
        }

        if(getMd5($password) != $res['password']){
            show(0,'密码错误');
        }

        $_SESSION['adminName'] = $res;

        show(1,'登录成功');

//        $this->display('index');
    }

    public function loginout(){

        $_SESSION['adminName'] = null;

        redirect('admin.php?c=login&a=index');
    }
}