<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/22
 * Time: 上午9:36
 */

namespace Admin\Controller;


use Think\Controller;

class BasicController extends Controller{

    public function index(){
        $this->display();
    }
}