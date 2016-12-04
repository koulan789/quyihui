<?php
namespace Admin\Controller;
use Think\Controller;
class NewsnavController extends BackController{
	/**
	*  显示列表界面
	**/
	public function index(){
		$nav=M('newsnav')->select();
		$this->assign('nav',$nav);
		$this->display();
	}
	/**
	*  删除类型
	**/
	public function del(){
		$nav=M('newsnav');
		if(IS_AJAX){
			$id=I('post.id',0,'int');
			$news=M('news');
			if($news->where('news_id='.$id)->find()){
				echo -1;
			}else{
				if($nav->where('ID='.$id)->delete()){
					echo 0;
				}else{
					echo 1;
				}
			}	
		}else{
			echo 2;
		}
	}
	/**
	*  添加类型
	**/
	public function add(){
		$data['name']=I('post.name','','htmlspecialchars');
		if(IS_AJAX){
			$nav=D('Newsnav');
			if($nav->create($data)){
				if($nav->add()){
					echo 0;
				}else{
					echo 1;
				}
			}else{
				echo -1;
			}
		}else{
		$this->display();
		}
	}
	/**
	*  修改类型
	**/
	public function edit(){
		$id=I('post.id',0,'int');
		if(IS_AJAX){
			$nav=D('Newsnav');
			if($nav->where('ID='.$id)->save()){
				echo 0;
			}else{
				echo 1;
			}
		}else{
			$id=I('get.id','0','int');
			$res=M('newsnav')->where('ID='.$id)->find();
			$this->assign('res',$res);
			$this->display();
		}
		
	}
}