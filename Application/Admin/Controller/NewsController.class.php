<?php
namespace Admin\Controller;
use Think\Controller;
class NewsController extends BackController{
	/**
	*  显示列表界面
	**/
	public function index(){
	    /**
	     * 实现分页
	     */
	    // 第一步查询信息的总数
	    $pro=M('news'); //先实例化表
	    $num=$pro->count();
	    $lenth='2';
	    $totalpage=ceil($num/$lenth);
	    if($totalpage==0){
	        $totalpage=1;
	    }
	    $page=I('get.page','0','int');
	    if($page<1){
	        $page=1;
	    }
	    if($page>$totalpage){
	        $page=$totalpage;
	    }
	    $res=$pro->page($page.','.$lenth)->order('ID desc')->select();
		$news_nav=M('newsnav');
		$nav=$news_nav->select();
		foreach($nav as $k=>$v){
			$data[$v['id']]=$v['name'];
		}
		foreach($res as $k=>$v1){
			$res[$k]['cate']=$data[$v1['news_id']];
		}
		$this->assign('res',$res);
		$this->assign('page',$page);
		$this->assign('totalpage',$totalpage+1);
		$this->display();
	}
	/**
	*  添加新闻
	**/
	public function add(){
		$news=D('News');
		$data['title']=I('post.title','','htmlspecialchars');
		$data['source']=I('post.source','','htmlspecialchars');
		$data['eidtor']=I('post.eidtor','','htmlspecialchars');
		$data['text1']=I('post.text1','','htmlspecialchars');
		$data['text2']=I('post.text2','','htmlspecialchars');
		$data['text3']=I('post.text3','','htmlspecialchars');
		$data['text4']=I('post.text4','','htmlspecialchars');
		$data['news_id']=I('post.news_id','','htmlspecialchars');
		if(IS_AJAX){
			if($news->create($data)){
				if($news->add()){
					echo 0;
				}else{
					echo 1;
				}
			}else{
				echo -1;
			}
		}else{
			//获取新闻类型
		$nav=M('newsnav');
		$result=$nav->select();
		$this->assign('result',$result);
		$this->display();
		}
	}
	/**
	*  删除新闻
	**/
	public function del(){
		if(IS_POST){
			$id=I('post.id','0','int');
			$news=M('news');
			$res=$news->where('ID='.$id)->delete();
				if($res){
					echo 1;
				}else{
					echo 0;
				}
		}else{
			echo 2;
		}
	}
	/**
	*  编辑新闻
	**/
	public function edit(){
		$news=M('news');
		if(IS_AJAX){
			$id=I('post.id',0,'int');
			$data['title']=I('post.title','','htmlspecialchars');
			$data['source']=I('post.source','','htmlspecialchars');
			$data['eidtor']=I('post.eidtor','','htmlspecialchars');
			$data['text1']=I('post.text1','','htmlspecialchars');
			$data['text2']=I('post.text2','','htmlspecialchars');
			$data['text3']=I('post.text3','','htmlspecialchars');
			$data['text4']=I('post.text4','','htmlspecialchars');
			$data['news_id']=I('post.news_id','','htmlspecialchars');
			if($news->create($data)){
				if($news->where('ID='.$id)->save()){
					echo 0;
				}else{
					echo 1;
				}
			}
		}else{
			$id=I('get.id',0,'int');
				//获取新闻类型
			$nav=M('newsnav');
			$result=$nav->select();
			$result2=$news->where('ID='.$id)->find();
			$this->assign('result',$result);
			$this->assign('result2',$result2);
			$this->display();
		}
		
	}
}
?>