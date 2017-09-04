<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/24
 * Time: 上午11:01
 */

namespace Common\Model;

use Think\Model;

class PositionContentModel extends Model{

    private $_db = '';

    public function __construct()
    {
        parent::__construct();
        $this->_db = M('position_content');
    }

    //获取所有的数据
    public function getAllPositionContent($data = array()){

        $condition = $data;

        if(isset($data) && $data){
            $condition['title'] = array('like', '%'.$data['title'].'%');
        }

        $condition['status'] = Array('neq', -1);

        $res = $this->_db->where($condition)->order('listorder desc, id desc')->select();

        return $res;
    }

    //根据id获取内容
    public function getPositionById($positionId){

        if(!is_numeric($positionId)){
            return 0;
        }

        return $this->_db->where('id='.$positionId)->find();

    }

    //更新排序
    public function updateListorder($id, $newListorder){

        if(!is_numeric($newListorder) || !is_numeric($id)){
            return 0;
        }

        $data['listorder'] = $newListorder;

        return $this->_db->where('id='.$id)->save($data);
    }

//    推送文章
    public function pushContent($condition){

        if(!$condition || !is_array($condition)){
            return 0;
        }
//        定义被写入内容的字段,不属于范围内的会被过滤
        $data = array(
            'position_id',
            'title',
            'thumb',
            'news_id',
            'listorder',
            'status',
            'create_time',
            'update_time',
        );

//        dump($condition);
//        $this->_db->filed($data)->date($condition)->add();

        $this->_db->data($condition)->add();
    }

    //推送文章
    public function insert($data =array()){

        if(!isset($data) || !$data){
//            throw_exception('数据不符合要求');
            return 0;
        }

        if(!$data['create_time']){
            $data['create_time'] = time();
        }

       return $this->_db->add($data);
    }

    public function updatePosition($id, $data){

        if(!is_numeric($id)){
            return 0;
        }
        if(!isset($data) || !$data){
            return 0;
        }

        return $this->_db->where('id='.$id)->save($data);
    }

}