<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/9/2
 * Time: 下午7:40
 */

namespace Home\Controller;

use Think\Controller;

class CatController extends Controller{

    public function index(){

        if($_GET){
            $res = D('Content')->getContentByCatId($_GET['id']);
        }
        $this->assign('listNews',$res);
        $this->display();
    }


}