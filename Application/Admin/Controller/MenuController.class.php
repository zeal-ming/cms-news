<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/22
 * Time: 上午9:31
 */

namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class MenuController extends Controller
{

    public function index()
    {

        //声明每一页有多少数据,这里默认为3
        $everyPage = 3;

        $data = array();

        if (isset($_REQUEST['type']) && in_array($_REQUEST['type'], array(0, 1))) {
            $data['type'] = $_REQUEST['type'];
            $this->assign('type', $_REQUEST['type']);
        } else {

            $this->assign('type', -1);
        }

        $pageNow = $_REQUEST['p'] ? $_REQUEST['p'] : 1;


        //获得菜单总数
        $menuCount = D('Menu')->getMenuCount($data);

        //通过菜单总数获取总页数
        $pageSum = $menuCount % $everyPage ? ($menuCount/$everyPage + 1) : ($menuCount/$everyPage);

        //点击下一页时,判断是是否到达最大
        if($pageNow >= $pageSum){
            $pageNow = $pageSum;
        }

        //点击下一页判断是否达到最小
        if($pageNow < 2){
            $pageNow = 1;
        }

        //显示首页的菜单信息
        $res = D('Menu')->getMenuContent($data, $pageNow, $everyPage);


        //调用thinkPHP封装的分页对象
//        $pageObj = new \Think\Page($menuCount, $everyPage);
//        $pageString = $pageObj->show();
//        dump($pageString);
//        $this->assign('pageStr', $pageString);



        //对分页的连接进行字符串拼接,返回前台,以供前台使用
        $page = '';  //定义所有分页链接
        $page .= "<a href='javascript:void(0);' value='$pageNow' class='btn btn-primary'>上一页</a>";

        foreach ($res as $index => $value) {

            $index += 1;
            $page .= "<a href='javascript:void(0)' value='$index' class='btn btn-primary'>$index</a>";

        }
        $page .= "<a href='javascript:void(0);' value='$pageNow' class='btn btn-primary'>下一页</a>";


        $this->assign('pageStr', $page);
        $this->assign('menus', $res);

        if ($_POST) {

            $this->display('page');

        } else {

            $this->display();
        }
    }

    //分页跳转时不进入,因为这里跟上面功能相似,所以使用上面进行加工后,省略下面的
    public function page()
    {

        $everyPage = 3;

        $data = array();

        if (isset($_REQUEST['type']) && in_array($_REQUEST['type'], array(0, 1))) {
            $data['type'] = $_REQUEST['type'];
            $this->assign('type', $_REQUEST['type']);
        } else {

            $this->assign('type', -1);
        }

        $pageNow = $_REQUEST['p'] ? $_REQUEST['p'] : 1;

        if ($pageNow == '上一页') {

        }
//        file_put_contents('zhangming.txt','pagenow='.$pageNow);

        //显示首页的菜单信息
        $res = D('Menu')->getMenuContent($data, $pageNow, $everyPage);

//        dump($res);
        //获得总页数
        $menuCount = D('Menu')->getMenuCount($data);

        $page = '';  //定义所有分页链接

        if($pageNow > 1){

            $page .= "<a href='javascript:void(0);' value='$pageNow'>上一页</a>";

        }

        foreach ($res as $index => $value) {

            $index += 1;
            $page .= "<a href='javascript:void(0)' value='$index'>$index</a>";

        }

        if($pageNow <= 3){

            $page .= "<a href='javascript:void(0);' value='$pageNow'>下一页</a>";
        }

//        dump($page);


        $this->assign('pageStr', $page);
        $this->assign('menus', $res);

        $this->display();

    }

    //处理前端点击添加按钮时,从common.js提交过来的数据
    public function add()
    {

        //判断数据
        if ($_POST) {

            //不能直接进入数据库,让数据库中的表做判断,否则我一直点提交,一直连接数据库,浪费资源
            if (!$_POST['name'] || !isset($_POST['name'])) {
                show(0, '菜单名不能为空');
            }
            if (!isset($_POST['type'])) {
                show(0, '菜单名类型不能为空');
            }
            if (!$_POST['m'] || !isset($_POST['m'])) {
                show(0, '模块名不能为空');
            }
            if (!$_POST['c'] || !isset($_POST['c'])) {
                show(0, '控制器名不能为空');
            }
            if (!$_POST['f'] || !isset($_POST['f'])) {
                show(0, '方法名不能为空');
            }
            if (!$_POST['status'] || !isset($_POST['status'])) {
                show(0, '状态名不能为空');
            }

            //获取表单中的数据
            $data = array();
            $data['name'] = I('name');
            $data['type'] = I('type');
            $data['status'] = I('status');
            $data['m'] = I('m');
            $data['c'] = I('c');
            $data['f'] = I('f');


            if (D('Menu')->addMenu($data)) {
                show(1, '添加成功');
            } else {
                show(0, '添加失败');
            }
        }
        $this->display();
    }

    //处理前端点击删除按钮时,从common.js提交过来的数据
    public function delete()
    {


        if ($_POST) {

            $res = D('Menu')->updateMenu($_POST);

            if ($res) {
                return show(1, '删除成功');
            } else {
                return show(0, '删除失败');
            }

        }
    }

    //处理前端点击添加编辑时,从common.js提交过来的数据
    public function edit()
    {
        if ($_GET) {

            $menu_id = $_GET['id'];
            $res = D('Menu')->getMenuById($menu_id);


            $this->assign('menu', $res);
//                redirect('/admin.php?c=menu&a=edit');
            $this->display();

        }

    }

    //根据获取的id更新信息
    public function update()
    {
        if ($_POST) {
            $menu_id = $_POST['id'];
            unset($_POST['id']);

            $res = D('Menu')->updateMenuById($menu_id, $_POST);
            if ($res) {
                show(1, '更新成功');
            }

            show(0, '更新失败');
        }
    }

    public function listorderUpdate()
    {
        if ($_POST) {

            $listorderArray = $_POST['listorder'];

            try {
                foreach ($listorderArray as $key => $value) {
                    D('Menu')->updateListorderById(intval($key), intval($value));
                }
            } catch (Exception $e) {

                show(0, $e->getMessage());

            }

            show(1, '更新成功');
        }
    }

}