<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/22
 * Time: 上午9:32
 */

namespace Admin\Controller;

use Think\Controller;

class PositionController extends Controller{

    //显示所有内容到首页面
    public function index(){


        $res = D('Position')->getAllPosition();

        //注意这里获取到的positions是个二位数组
        $this->assign('positions',$res);

        $this->display();
    }

    //添加操作,当用户从添加界面提交表单时,插入数据到数据空中
    public function add(){
            if($_POST){
                if(!isset($_POST['description']) || !$_POST['description']){
                    show(0,'描述不能为空');
                }

                $res = D('Position')->addPosition($_POST);

                if(!$res){
                    show(0,'添加失败');
                }

                show(1,'添加成功');
            }

            $this->display();
    }

    //删除操作,根据从前端获取的id,删除相应的记录(这是其实并没有真正的删除,只是更新数据库中的status=-1)
    public function delete(){

        if($_POST){


            $id = $_POST['menu_id'];
            $status = $_POST['status'];

            //这里var_dump也返回给了前端,而前端规定以json数据接收,如果不是json格式,则进不了回调函数
//            var_dump($id.'='.$status);

            $res = D('Position')->setStatusById(intval($id), intval($status));

            if(!$res){
                show(0,'删除失败');
            }

            show(1,'删除成功');

        }
    }

    //编辑操作1,根据前端获取的id,从数据库中查找出对应的数据,显示到编辑界面
    public function edit(){
        if($_GET){
            $id = $_GET['id'];

            $res = D('Position')->getOnePosition($id);

            $this->assign('vo',$res);
            $this->display();
        }

    }

    //编辑操作2,根据前端获取的表单,更新数据库中的相应的数据
    public function update(){

        if($_POST){

            $id = $_POST['id'];
            unset($_POST['menu_id']);

            $res = D('Position')->updatePosition(intval($id),$_POST);

            if(!$res){
                show(0,'更新失败');
            }

            show(1,'更新成功');
        }
    }


}