<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/9/2
 * Time: 下午8:00
 */

namespace Home\Controller;

use Think\Controller;

class DetailController extends Controller{

    public function index(){

        if($_REQUEST['id']){
            $res = D('NewsContent')->getContentDetailById($_REQUEST['id']);
//            dump($res);
            $res['content'] = htmlspecialchars_decode($res['content']);
            $this->assign('new',$res);

        }

        $this->display();

    }
}