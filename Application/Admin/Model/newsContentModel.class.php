<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/9/4
 * Time: 上午9:44
 */

namespace Admin\Model;

use Think\Model;

class newsContentModel extends Model{

    private $_db = '';

    public function __construct()
    {
        $this->_db = M('newsContent');
    }

    public function insert($data){

        if(!is_array($data) || !$data){
            return 0;
        }

        return $this->_db->where($data)->select();
    }
}