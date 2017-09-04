<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/28
 * Time: 上午9:47
 */

namespace Common\model;

use Think\Model;

class UploadImageModel extends Model{

    private $_uploadObj = ''; //上传文件对象

    const UPLOAD = 'upload'; //图片根路径名称

    public function __construct()
    {
        $this->_uploadObj = new \think\Upload();

        $this->_uploadObj->rootPath = './'.self::UPLOAD.'/';

        //设置文件夹的层次
        $this->_uploadObj->subName = date(Y).'/'.date(m).'/'.date(d);
    }

    public function imageUpload(){

        //调用thinkPHP中upload对象中的上传文件方法
        $res = $this->_uploadObj->upload();
        //$res是一个数组
        //$this->_uploadObj是一个对象
//        dump($this->_uploadObj);
//        dump($res);
//            dump($this->_uploadObj->rootPath);
        if($res){

            return '/'.self::UPLOAD.'/'.$res['file']['savepath'].$res['file']['savename'];

        }
        else {
            dump($this->_uploadObj->getError());
            return false;
        }
    }
}