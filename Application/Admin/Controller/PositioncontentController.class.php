<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/22
 * Time: 上午9:33
 */

namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class PositionContentController extends Controller{

    public function index(){

        $data = array();

        if(isset($_REQUEST['title'])){
            $data['title'] = $_REQUEST['title'];
        }
        $position_id = isset($_REQUEST['position_id']) ? $_REQUEST['position_id'] : 2;

        $data['position_id']= $position_id;


        $positions = D('Position')->getAllPosition();

        $res = D('PositionContent.class')->getAllPositionContent($data);

        $this->assign('positionId',$position_id);
        $this->assign('title',$data['title']);
        $this->assign('contents', $res);
        $this->assign('positions' ,$positions);

        $this->display();

    }

//    public function ajaxShowPosition(){
//
//
//        $position_id = isset($_REQUEST['position_id']) ? $_REQUEST['position_id'] : 2;
//
//        $data['position_id']= $position_id;
//
//        $res = D('PositionContent.class')->getAllPositionContent($data);
//
//        $this->assign('contents', $res);
//
//
//        exit(json_encode($res));
//
//        //不能用display(),display返回的是相关的html文件,而且还是解析后的
////        $this->display(index);
//    }

    public function edit(){

        if($_GET['id']){
            $positionId = $_GET['id'];

           $res = D('PositionContent.class')->getPositionById(intval($positionId));

            $positions = D('Position')->getAllPosition();


            $this->assign('positions',$positions);
            $this->assign('vo',$res);
            $this->display();
        }
    }

    public function listorder(){

        if($_POST){

            $listorder = $_POST['listorder'];

            try{
                foreach ($listorder as $key => $value){
                    D('PositionContent.class')->updateListorder(intval($key), intval($value));
                }
                show(1, '更新成功');
            } catch (Exception $e){
                $e->getMessage();
            }

        }

    }

    public function add(){

        if($_POST){
            if(!isset($_POST['position_id']) || !$_POST['position_id']){
                return show(0, '推荐为不能为空');
            }
            if(!isset($_POST['thumb']) || !$_POST['thumb']){
                return show(0, '必须上传分面图');
            }
            if(!$_POST['url'] || !$_POST['news_id']){
                return show(0, 'url和文章ID不能同时为空');
            }

            $res = D('PositionConent')->insert($_POST);

            if($res){
                return show(1, '添加成功');
            } else {
                return show(0, '添加失败');
            }

        }

        $positions = D('Position')->getAllPosition();

        $this->assign('positions' ,$positions);

        $this->display();
    }

    public function update(){

        if($_POST){

            $id = $_POST['id'];
            unset($_POST['id']);

            $res = D('PositionContent.class')->updatePosition($id, $_POST);

            if($res){
                return show(1, '更新成功');
            } else {
                return show(0, '更新成功');
            }
        }
    }
}