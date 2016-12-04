<?php
namespace Home\Controller;
use Think\Controller;
class IntroduceController extends PublicController {
    public function introduce(){
		$this->head();
		$intro=M('introduce')->select();
		$this->assign('introduce',$intro);
		$this->display();
    }
}