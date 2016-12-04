<?php
namespace Home\Controller;
use Think\Controller;
class NewsController extends PublicController {
    public function news(){
		$this->head();
		/**
		 * 导航切换产品列表
		 */
		$news_id=I('get.id','1','int');  //接收静态页面传来的值
		$result2=M('newsnav')->where('ID='.$news_id)->select();
		foreach($result2 as $val){
		    $a[]=$val['id'];
		}
		$id=implode(',',$a);
		/**
		 * 新闻分页
		 */
		// 第一步查询信息的总数
		$news=M('news');//先实例化表
		$result=$news->where('news_id in('.$id.')')->select();
		$num=count($result);
		$lenth='6';
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
		$pageup=$page<=1?1:$page-1;
		$pagedown=$page>=$totalpage?$totalpage:$page+1;
		$res=$news->page($page.','.$lenth)->where('news_id in('.$id.')')->order('ID desc')->select();
		$this->assign('page',$page);
		$this->assign('pageup',$pageup);
		$this->assign('pagedown',$pagedown);
		$this->assign('totalpage',$totalpage+1);
		$this->assign('news',$res);
		/**
		 * 新闻导航栏
		 */
		$newsnav1=M('newsnav')->select();
		foreach($newsnav1 as $val){
		    $nav[$val['id']]=$val['name'];
		}
		$a=reset($nav);
		$b=end($nav);
		$this->assign('news_id',$news_id);
		$this->assign('a',$a);
		$this->assign('b',$b);
		$this->assign('newsnav',$newsnav1);
		$this->display();
    }
	public function news_center(){
		$this->head();
		$news_id=I('get.n_id',1,'int');
		$nav_id=I('get.nav_id',1,'int');
		$newsnav1=M('newsnav')->select();
		foreach($newsnav1 as $val){
		    $nav[$val['id']]=$val['name'];
		}
		$news=M('news')->where('ID='.$news_id)->select();
		$b=end($nav);
		$this->assign('news',$news);
		$this->assign('newsnav',$newsnav1);
		$this->assign('b',$b);
		$this->assign('id',$nav_id);
		$this->display();
	}
}