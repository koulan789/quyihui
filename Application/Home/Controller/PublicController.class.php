<?php	
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {
	public function head(){
		$href=str_replace(__MODULE__,'',__ACTION__);
		$nav=M('nav')->select();
		$this->assign('nav',$nav);
		$uname=session('user1');
		$this->assign('user',$uname);
		$this->assign('href',$href);
	}
	public function foot(){
	}
	public function a(){
		if(isset($_GET['id'])){
			session('user1',null);
		}
		$this->success('正在注销，请稍候.....','userlogin',1);
	}
	
}