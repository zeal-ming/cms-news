<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/28
 * Time: 上午9:19
 */

namespace Admin\Controller;

use Think\Controller;

class ImageController extends Controller
{

    public function ajaxUploadImage()
    {
        $upload = D('UploadImage');
        //res是上传成功后的绝对路径
        $res = $upload->imageUpload();

        if($res === false){
            return show(0, '上传失败');
        }
        else
        {
            return show(1, '上传成功', $res);
        }
    }
};