<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends PublicController {
    public function index(){
		$this->head();
		$product=M('product')->select();
		$this->assign('pro',$product);
		$this->display();
    }
}
?> 