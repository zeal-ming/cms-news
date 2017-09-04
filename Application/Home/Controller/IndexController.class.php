<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {

        //挑选出首页所有的内容
      $positionContent = D('PositionContent')->showAll();

      $contents = D('content')->getAllContent();
      $nav = D('Menu')->getMenu(0);
      $topSmallNews = array();
      $advNews = array();
      foreach ($positionContent as $key => $value){
          if($value['position_id'] == 2){
              $this -> assign('topPicNews',$value);
          }
          if($value['position_id'] == 3){
              $topSmallNews[] = $value;
          }
          if($value['position_id'] == 5){
            $advNews[] = $value;
          }
      }

//      dump($positionContent);
        $this->assign('news',$contents);
        $this -> assign('topSmallNews', $topSmallNews);
        $this->assign('advNews', $advNews);
        $this->assign('navs',$nav);
        $this->fetch('right');

        $this->display();

    }
}