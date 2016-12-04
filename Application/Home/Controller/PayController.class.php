<?php
namespace Home\Controller;
class PayController extends PublicController{
   public  function pay(){
        $this->head();
        if(IS_POST){
            //直接购买过来的
            if($_POST['path']==1){
                $order=M('order1');
                //把获得的信息写入订单表
                $id=M('user')->field('ID')->where('name="'.$_SESSION['user1'].'"')->find();
                $data['user_id']=$id['id'];
                $data['address_id']=I('post.address','','int');
                $data['content']=I('post.other','','htmlspecialchars');
                $cart_id=I('post.cart_id','','htmlspecialchars');
                $data['order_num']='JS'.date('ymdHis').substr(microtime(),2,4);
                $data['order_time']=date('Y-m-d H:i:s');
                $res=D('CartView')->where('user_id='.$id['id'].' and status=2')->select();
                $data['goods']=json_encode($res);
                $data['status']='0';
                $price=I('post.price','','htmlspecialchars');
                foreach($price as $v){
                    $a+=$v;
                }
                $data['totalprice']=$a;
                $del=M('cart')->where('user_id='.$id['id'].' and status=2')->delete();
                if($del){
                    if($order->create($data)){
                        if($order->add()){
                            $this->assign('price',$a);
                            $this->assign('order_num',$data['order_num']);
                            $this->display();
                        }
                    }
                }
                
               // 购物车提交过来
            }elseif($_POST['path']==2){
                $order=M('order1');
                //把获得的信息写入订单表
                $id=M('user')->field('ID')->where('name="'.$_SESSION['user1'].'"')->find();
                $data['user_id']=$id['id'];
                $data['address_id']=I('post.address','','int');
                $data['content']=I('post.other','','htmlspecialchars');
                $cart_id=I('post.cart_id','','htmlspecialchars');
                $data['cart_id']=implode(',',$cart_id);
                $data['order_num']='JS'.date('ymdHis').substr(microtime(),2,4);
                $data['order_time']=date('Y-m-d H:i:s');
                $res=D('CartView')->where('user_id='.$id['id'].' and status=3')->select();
                $data['goods']=json_encode($res);
                $data['status']='0';
                $price=I('post.price','','htmlspecialchars');
                foreach($price as $v){
                    $a+=$v;
                }
                $data['totalprice']=$a;
                $del=M('cart')->where('user_id='.$id['id'].' and status=3')->delete();
                if($del){
                    if($order->create($data)){
                        if($order->add()){
                            $this->assign('price',$a);
                            $this->assign('order_num',$data['order_num']);
                            $this->display();
                        }
                    }
                }
            }
        }
        
    }
    
}
