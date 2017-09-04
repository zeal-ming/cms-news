<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/9/2
 * Time: 上午10:47
 */

namespace Home\Model;

use Think\Model;

class PositionContentModel extends Model{

    private $_db = '';
    public function __construct()
    {
        $this->_db = M('positionContent');
    }

    public function showAll($data = array()){

        $data = array(
          'p.status' => array('neq',-1),

        );

        $res =  M('PositionContent p')->join('left join cms_news as n on p.news_id = n.news_id')->where($data)->select();

        return $res;
    }
}