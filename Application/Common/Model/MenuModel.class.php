<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/22
 * Time: 上午9:22
 */

namespace Common\Model;

use function PHPSTORM_META\type;
use Think\Model;

class MenuModel extends Model
{

    private $_db = '';

    public function __construct()
    {

        $this->_db = M('menu');
    }

    //获取右边导航栏中的数据(所有的模块)
    public function getMenu($type)
    {
        $condition = '';

        if(!isset($type)){
            $type = 1;
        }

        $condition = array(
            'status' => 1,
            'type' => $type
        );

        return $this->_db->where($condition)->select();
    }

    //获取右边导航栏中菜单模块的数据
    public function getMenuContent($condition, $pageNow, $pageSize)
    {

        if (!is_array($condition)) {

            return 0;
        }
        if (!is_numeric($pageNow) || !is_numeric($pageSize)) {
            return 0;
        }

        if (in_array(intval($condition['type']), array(0, 1)) && !is_null($condition['type'])) {
            $arr['type'] = $condition['type'];
        }

//        $arr['status'] = array('neq', -1);


        $offset = ($pageNow - 1) * $pageSize;

        $res = $this->_db->where($arr)->order('listorder desc, menu_id desc')->limit($offset, $pageSize)->select();

        return $res;

    }

    //获取前端的名称
    public function getWebSite(){

        $data = array(
            'status' => 1,
            'type' => 0
        );

        return $this->_db->where($data)->select();
    }

    //获取菜单模块的数据总数
    public function getMenuCount($data)
    {


        if (in_array(intval($data['type']), array(0, 1)) && !is_null($data['type'])) {
            $condition['type'] = $data['type'];
        }

        $condition['status'] = array('neq', -1);


        return $this->_db->where($condition)->count();
    }

    //插入数据到菜单模块
    public function addMenu($data)
    {
        if (!is_array($data) || !$data) {
            return 0;
        }

        return $this->_db->add($data);
    }

    //删除指定id的菜单模块
    public function updateMenu($data)
    {
        if (!$data || !is_array($data)) {
            return 0;
        }

        $dataCon = array(
            'status' => -$data['status']
        );

        return $this->_db->where("menu_id=$data[id]")->save($dataCon);
    }

    //根据指定的id查出相应的记录
    public function getMenuById($menu_id)
    {

        if (!is_numeric($menu_id)) {
            return 0;
        }

        return $this->_db->where("menu_id=" . $menu_id)->find();

    }

    //根据id更新相应的信息
    public function updateMenuById($menu_id, $data)
    {

        if (!is_numeric($menu_id) || !is_array($data)) {
            return 0;
        }

        return $this->_db->where("menu_id=" . $menu_id)->save($data);
    }

    public function updateListorderById($menu_id, $newListorder)
    {

        if (!is_numeric($newListorder) || !is_numeric($menu_id)) {
            return 0;
        }

        $data = array(
            'listorder' => $newListorder,
        );

        $res = $this->_db->where("menu_id=".$menu_id)->save($data);

            return $res;
    }
}