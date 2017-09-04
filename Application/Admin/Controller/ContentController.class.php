<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/22
 * Time: 上午9:34
 */

namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class ContentController extends Controller{

    //显示到首页所有的内容
    public function index(){

        $data = array();

        if($_REQUEST['title']){
            $data['title'] = $_REQUEST['title'];
        }

        if($_REQUEST['catid']){
            $data['catid'] = $_REQUEST['catid'];
        }
        $res = D('Content')->getAllContent($data);

        $webSiteMenu = D('Menu')->getWebSite();

        $this->assign('webSiteMenu',$webSiteMenu);
        $this->assign('catid',$data['catid']);
        $this->assign('title',$data['title']);
        $this->assign('news',$res);
        $this->assign('positions', D('Position')->getAllPosition());
        $this->display();
    }

    //ajax根据栏目发送过来的相关id,查找对应的文章返回
    public function showContentByCatId(){


        if($_POST){

            $res = D('Content')->getContentByCatId($_POST['catid']);

            $this->assign('news',$res);

            //1.dump表示返回数据,2.$this->fecth()只渲染,不输出
            dump($this->fetch('contentByCatId'));

//            $this->fetch('contentByCatId');
            $this->display('contentByCatId');
        }
    }

    //删除
    public function delete(){

        if($_POST){

            $news_id = $_POST['id'];
            $status = $_POST['status'];

            if(D('Content')->deleteContent($news_id, $status)){
                show(1,'删除成功');
            } else {
                show(0, '删除失败');
            }
        }
    }

    //进入编辑界面
    public function edit(){
        if($_GET){
            $news_id = $_GET['id'];

            $res = D('Content')->getOneContent($news_id);

            $this->assign('news',$res);
            $this->display();

        }
    }

    //更新
    public function update(){

        if($_POST){
            $new_id = $_POST['news_id'];
            unset($_POST['news_id']);

            if(D('Content')->updateContent($new_id,$_POST)){
                show(1,'更新成功');
            } else {
                show(0,'更行失败');
            }
        }
    }

    //增加
    public function add(){

        if($_POST){

            if(!$_POST['title']){
                show(0,'标题不能为空');
            }
            if(!$_POST['small_title']){
                show(0,'标题不能为空');
            }
            if(!$_POST['copyfrom']){
                show(0,'来源不能为空');
            }
            if(!$_POST['content']){
                show(0,'内容不能为空');
            }

            $_POST['username'] = $_SESSION['adminName']['username'];

            $newsId = D('Content')->addContent($_POST);

            if($newsId){

                $newsContent['news_id'] = $newsId;
                $newsContent['content'] = $_POST['content'];

                if(D('newsContent')->insert($newsContent)){
                    show(1,'添加成功');
                } else {
                    show(1, '主表插入成功, 副表插入失败');
                }
            } else {
                show(0, '添加失败');
            }
        }

        $title = C('TITLE_FONT_COLOR');
        $this->assign('titleFontColor', $title);
        $menu = D('Menu')->getMenu();
        $this->assign('webSiteMenu',$menu);
        $copyfrom = C('COPY_FROM');
        $this->assign('copyfrom',$copyfrom);
        $this->display();

    }

    //排序
    public function listorder(){

        if($_POST){

            $listorder = $_POST['listorder'];

            try{
                foreach ($listorder as $key => $value){
                    D('Content')->updateListorder(intval($key), intval($value));
                }
                show(1, '更新成功');
            } catch (Exception $e){
                $e->getMessage();
            }

        }

    }

    //推送
    public function push(){

        //获取前端推送过来的news_id, position_id

        $news_ids = $_REQUEST['news_ids'];

        dump($news_ids);
        dump($_REQUEST['position_id']);
        if(!$news_ids || !$_REQUEST['position_id']){
            return 0;
        }

        try{
            foreach ($news_ids as $value){

                //获取文章的全部信息
                $content = D('Content')->getOneContent($value);

                $data = $content;
                $data['position_id'] = $_REQUEST['position_id'];

                $arr = D('PositionContent.class')->pushContent($data);
                dump('arr:'.$arr);

            }
        } catch (Exception $e){
            $e->getMessage();
        }

        show(1, '推送成功');
    }

    //推送
//    public function push(){
//
//        if(!isset($_POST['newsIDs']) || !$_POST['newsIDs']){
//            return 0;
//        }
//
//        $newIDs = $_POST['newsIDs'];
//        $position_id = $_POST['position_id'];
//
//
//        $newArray =  D('Content')->getNewsByIdIn($newIDs);
//
//       try{
//           foreach ($newArray as $news){
//
//               $data = array(
//                   'position_id' => $position_id,
//                   'title' => $news['title'],
//                   'news_id' => $news['news_id'],
//                   'thumb' => $news['thumb'],
//                   'create_time' => $news['create_time'],
//                   'status' => $news['status']
//               );
//
//              D('PositionContent.class')->insert($data);
//
//           }
//
//       } catch (Exception $e){
//           return show(0, $e->getMessage());
//       }
//
//       show(1, '添加到推荐为成功');
//
//
//    }
}