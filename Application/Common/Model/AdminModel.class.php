<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/22
 * Time: 上午9:09
 */

namespace Common\Model;

use Think\Model;

class AdminModel extends Model{

    private $_db = '';

    public function __construct()
    {
        $this->_db = M('admin');
    }

    public function  getAdminByUsername($username){


        return $this->_db->where("username='$username'")->find();
    }

    //显示
    public function getAllAdmin(){

        dump($this->_db->getField('password'));
        return $this->_db->select();
    }

    //增加
    public function addAdmin($data){

        if(!$data || !is_array($data)){
            return 0;
        }

        return $this->_db->add($data);
    }

    //删除
    public function deleteAdmin($id, $data){

        if(!is_numeric($id) || !$id){
            return 0;
        }

        $data = array(
            'status' => -$data['status']
        );

     return  $this->_db->where('admin_id='.$id)->save($data);
    }

}