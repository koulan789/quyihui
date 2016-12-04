<?php
namespace Home\Controller;
use Think\Controller;
class ProductController extends PublicController {
    public function products(){
        $this->head();
        /**
         * 导航切换产品列表
         */
        $p_id=I('get.id','1','int');  //接收静态页面传来的值
        $result=M('procate')->where('p_id='.$p_id)->select();
        foreach($result as $val){
            $a[]=$val['id'];
        }
        $id=implode(',',$a);
        /**
         * 产品分页
         */
        // 第一步查询信息的总数
        $pro=M('product');//先实例化表
        $result2=$pro->where('po_id in('.$id.')')->select();
        $num=count($result2);
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
        $param='id='.$p_id;
        $pageup=$page<=1?1:$page-1;
        $pagedown=$page>=$totalpage?$totalpage:$page+1;
        $res=$pro->page($page.','.$lenth)->where('po_id in('.$id.')')->order('ID desc')->select();
        $this->assign('id',$p_id);
        $this->assign('param',$param);
        $this->assign('page',$page);
        $this->assign('pageup',$pageup);
        $this->assign('pagedown',$pagedown);
        $this->assign('totalpage',$totalpage+1);
		$this->assign('product',$res);
		/**
		 * 产品导航栏
		 */
		$pronav1=M('procate')->where('p_id=0')->select();
		foreach($pronav1 as $val){
		    $nav[$val['id']]=$val['name'];
		}
		$a=reset($nav);
		$b=end($nav);
		$this->assign('a',$a);
		$this->assign('b',$b);
		$this->assign('procate',$pronav1);
		$this->display();
    }
	public function products_center(){
		$this->head();
		/**
		 * 显示产品类型导航
		 */
		// 猜你喜欢
		if(isset($_GET['id2']) && !empty($_GET['id2']) && empty($_GET['inid'])){
		    $product_id=I('get.id2',0,'int');
		//首页
		}elseif(isset($_GET['inid']) && !empty($_GET['inid']) && empty($_GET['id2'])){
		    $product_id=I('get.inid',0,'int');
		}else{
		    $product_id=I('get.ids',0,'int');
		}
		$p_id=I('get.id',0,'int');
		$pronav=M('procate')->where('p_id=0')->select();
		$this->assign('pronav',$pronav);
		$product=D('Admin/ProductView')->where('product.ID='.$product_id)->select();
		$size1=C('SIZE');
		foreach($size1 as $k=>$va){
		    $psize[$va['id']]=$va['name'];
		}
		foreach($product as $k=>$val){
		    $a=array();
		    $p_size=explode(',',$val['p_size']);
		    foreach($p_size as $v){
		        $a[]=$psize[$v];
		    }
		    $product[$k]['size']=$a;
		}
		$this->assign('p_id',$p_id);
		$this->assign('psize',$psize);
		$this->assign('product_id',$product_id);
		$this->assign('product',$product);
		$this->display();
		
    }
	public function addcart(){
	    if(IS_POST){
		  if(session('?user1')){
		       $user=M('user');
		       $a=$user->field('ID')->where('name="'.$_SESSION['user1'].'"')->find();
		       $data['product_id']=I('post.product_id','','htmlspecialchars');
		       $data['num']=I('post.num',1,'int');
		       $data['user_id']=$a['id'];
		       $data['img']=I('post.img','','htmlspecialchars');
		       $data['size']=I('post.size','','htmlspecialchars');
		       $data['status']='1';
		       $cart=M('cart');
		       /**
		        * 先判断用户购物车中是否买过此商品且颜色尺码都一样的
		        */
		       $old_data1=$cart->where('user_id='.$data['user_id'].' and product_id='.$data['product_id'].' and img="'.$data['img'].'" and size="'.$data['size'].'"')->find();
		       if($old_data1){
		              $data['num']+=$old_data1['num']; //购买量增加
		              if($cart->where('ID='.$old_data1['id'])->save($data)){
		                  echo 1;
		              }
		       }
		         /**
		          * 用户购物车中没有买过此商品
		          */
		         else{  //第一次购买
		           if($cart->create($data)){
		               if($cart->add()){
		                   echo 1;
		               }else{
		                   echo 0;
		               }
		           }
		           
		       }
		  }else{
		          echo -1;
		       }           
         }
	}
	public function shopping_cart(){
	    $this->head();
	    /**
	     * 从购物车中获取当前用户
	     */
	    $user=M('user');
	    $data=$user->field('ID')->where('name="'.$_SESSION['user1'].'"')->find();
	    $res=D('ProductView');
	    $result=$res->where('user_id='.$data['id'].' and status=1')->select();
	    $this->assign('result',$result);
	    $this->display();
	}
	//修改购物车
	public function change(){
	    if(IS_POST){
	        $id=I('post.cartid','','int');
	        $data['num']=I('post.num','','int');
	        $data['status']=I('post.status','','int');
	        $res=M('cart');
	        if($res->create($data)){
	            if($res->where('ID='.$id)->save()){
	                $this->ajaxReturn(1);
	            }else{
	                $this->ajaxReturn(-1);
	            }
	        }
	    }
	}
	
	
	
	public function shopping_address(){
		$this->head();
		$this->display();
    }
    /**
     * 删除购物订单
     */
    function del(){
        if(IS_AJAX){
            $id=I('post.id','0','int');
            $cart=M('cart');
            $res=$cart->where('ID='.$id)->delete();
            if($res){
                $this->ajaxReturn(0);
            }else{
                $this->ajaxReturn(1);
            }
        }else{
            $this->ajaxReturn(-1);
        }
    }
    public function order_confirm(){
        $this->head();
        // 购物车提交过来
        if(strstr($_SERVER['HTTP_REFERER'],'Product/shopping_cart')){
            $path=2;
        }
        $id=M('user')->field('ID')->where('name="'.$_SESSION['user1'].'"')->find();
        $result=M('address')->where('user_id='.$id['id'])->order('address_default desc')->select();
        $this->assign('result',$result);
        $res=D('ProductView')->where('status=3')->select();
        $this->assign('res',$res);
        $this->assign('path',$path);
        $this->display('User:order_confirm');
    }
}