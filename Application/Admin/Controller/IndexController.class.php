<?php

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        if(!$_SESSION['adminName']){
            redirect('admin.php?c=login&index');
        }
        $this->display();
    }
}