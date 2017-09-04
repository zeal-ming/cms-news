<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/23
 * Time: 下午3:11
 */

namespace Admin\Model;

use Think\Model;

class PositionModel extends Model
{

    private $_db = '';

    //初始化构造方法,获取变得数据模型对象,以对表进行操作
    public function __construct()
    {
        $this->_db = M('position');
    }

    //获取推荐模块的所有内容
    public function getAllPosition()
    {

        return $this->_db->select();
    }

    //根据ID获取对应的数据
    public function getOnePosition($id){

        if(!is_numeric($id)){
            return 0;
        }
        return $this->_db->where('id='.$id)->find();
    }

    //添加数据
    public function addPosition($data)
    {
        if(!$data || !is_array($data)){
            return 0;
        }
        return $this->_db->add($data);
    }

    //删除数据
    public function setStatusById($id, $status){

        if(!is_numeric($id) || !is_numeric($status)){
            return 0;
        }



        //注意,这里把获取到的status取反
        $arr = array(
            'status' => - $status
        );
        return $this->_db->where('id='.$id)->save($arr);
    }

    //更新数据
    public function updatePosition($id, $data){

        if(!is_numeric($id) || !$data || !is_array($data)){
            return 0;
        }
        return $this->_db->where('id='.$id)->save($data);
    }
}