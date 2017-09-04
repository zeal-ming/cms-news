<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/8/22
 * Time: 上午9:02
 */

//判断完成后,退出返回
function show($status, $message, $data)
{
    $data = array(
        'status' => $status,
        'message' => $message,
        'data' => $data
    );

    exit(json_encode($data));

}

//把密码进行md5加密
function getMd5($password){

    return md5($password.'sing_cms');
}

//获取相关模块的连接
function getUrl($res){

    return '/admin.php?c='.$res['c'].'&a='.$res['f'];
}

function getActive($conName){

//    CONTROLLER_NAME;  //获取当前控制器的名称
//    ACTION_NAME;获取当前的方法名
//    strtolower()将字符串字母全部转换为小写
    $c = strtolower(CONTROLLER_NAME);

    if($c == strtolower($conName)){

        return 'class="active"';

    }
    return '';
}


//根据type返回对应的汉字名称
function getMenuType($type){

    return $type == 1 ? '后台模块' : ($type == 0 ? '前台模块' : '');
}

//根据状态的值,对应一名称
function status($sta){

    return $sta == 1 ? '正常' : ($sta == -1 ? '关闭' : '');

}

//写一个数据的过滤器,每次进库操作之前,先过滤数据
function dataFilter(){

}

function isThumb($thumb){
    if($thumb){
        return '<span style="color: red">有</span>';
    }

    return '无';
}


function getCopyFromById($id){

    if(C('COPY_FROM')[$id]){
        return C('COPY_FROM')[$id];
    } else {
        return "未知";
    }
}

function getCatName($webStateMenu, $catid){

    foreach ($webStateMenu as $index => $value){
        if($value['menu_id'] == $catid){
            return $value['name'];
        }
    }
}