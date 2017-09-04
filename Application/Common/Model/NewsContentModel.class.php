<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/9/2
 * Time: 下午8:02
 */

namespace Common\Model;


use Think\Model;

class NewsContentModel extends Model{

    private $_db = '';

//    protected $tableName = 'ContentDetail';

    public function __construct()
    {
        $this->_db = M('newsContent');
    }

    public function getContentDetailById($id){

        return $this->_db->where('news_id='.$id)->find();
    }
}