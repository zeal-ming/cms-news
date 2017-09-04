<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/23
 * Time: 下午5:35
 */

namespace Common\model;

use think\model;

class ContentModel extends model{

    private $_db = '';

//    protected $tableName = 'content';

    public function __construct()
    {
//        parent::__construct();
        $this->_db = M('news');

    }

    //显示所有内容
    public function getAllContent($data =array()){

        $condition = $data;

        if(isset($data['title']) || $data['title']){
            $condition['title'] = array('like','%'.$data['title'].'%');
        }

        if(!is_array($data)){
            return 0;
        }

        if(!$data['catid']){
            $data['catid'] = 0;
        }

        if($data['catid']){
            $condition['catid'] = $data['catid'];
        }
        return $this->_db->where($condition)->order('listorder desc, news_id desc')->select();
    }

    //根据栏目id显示部分内容
    public function getContentByCatId($catid){

//        dump('hahah');
        return $this->_db->where('catid='.$catid)->select();
    }

    //根据id,查询一条记录
    public function getOneContent($new_id){

        return $this->_db->where('news_id='.$new_id)->find();
    }

    //添加数据
    public function addContent($data){
//        dump($data);
        if(!is_array($data) || !$data){

            return 0;
        }


        return $this->_db->add($data);
    }

    //删除数据
    public function deleteContent($id, $status){
        if(!is_numeric($id) || !is_numeric($status)){
            return 0;
        }

        $condition = array(
            'status' => -$status
        );
        return $this->_db->where('news_id='.$id)->save($condition);
    }

    //修改数据
    public function updateContent($id, $condition){

        if(!is_numeric($id) || !is_array($condition) || !$condition){
            return 0;
        }

        return $this->_db->where('news_id='.$id)->save($condition);
    }


    //更新排序
    public function updateListorder($id, $newListorder){

        if(!is_numeric($newListorder) || !is_numeric($id)){
            return 0;
        }

        $data['listorder'] = $newListorder;

        return $this->_db->where('news_id='.$id)->save($data);
    }

    //查询多条,通过ID
    public function getNewsByIdIn($newsId = array()){

        if(!is_array($newsId) || !$newsId){
            return 0;
        }

        $data = array(
            'news_id' => array('in', implode(',', $newsId))
        );

        return $this->_db->where($data)->select();
    }
}