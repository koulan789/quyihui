<?php
namespace Home\Controller;
use Think\Controller;
use Org\Email\PHPMailer;
class UserController extends PublicController {
    public function userlogin(){
        /**
         * [HTTP_REFERER] 获取上一级路径
         * 注册路径：[HTTP_REFERER] => http://127.0.0.1/Jimson/index.php/Home/User/register
         * 登录路径：[HTTP_REFERER] => http://127.0.0.1/Jimson/index.php/Home/User/userlogin
         * 详情界面：[HTTP_REFERER] => http://127.0.0.1/Jimson/index.php/Home/Introduce/introduce
         * 注销界面：[HTTP_REFERER] => http://127.0.0.1/Jimson/index.php/Home/User/a?id=2'
         */
        if(!(strstr($_SERVER['HTTP_REFERER'],'User/userlogin') || strstr($_SERVER['HTTP_REFERER'],'User/register') || strstr($_SERVER['HTTP_REFERER'],'User/a?id=2'))){
            cookie('href',$_SERVER['HTTP_REFERER']);
        }
		if(IS_POST){
			$user=I('post.user','','htmlspecialchars');
			$pass=(I('post.pass','','htmlspecialchars'));
			if(isset($_POST['remenber']) && !empty($_POST['remenber'])){
				cookie('user1',$user,3600);
				cookie('pass1',$pass,3600);
				
			}else{
				cookie('user1',null);
				cookie('pass1',null);
			}
			$res=M('user')->where("email='".$user."' and password='".$pass."'")->find();
			if($res){
			    $name=$res['name'];
				session('user1',$name);
				if($_COOKIE['href']){
				    $this->success('恭喜您！！登录成功',$_COOKIE['href'],1);
				}else{
				    $this->success('恭喜您！！登录成功',U('User/vip_center'),1);
				}
			}else{
				$this->error('对不起！！登录失败','userlogin',2);
			}
		}else{
			if(!empty($_COOKIE['user1']) && !empty($_COOKIE['pass1'])){
				$user1 = $_COOKIE['user1'];
				$pass1 = $_COOKIE['pass1'];
				
				$this->assign('user1',$user1);
				$this->assign('pass1',$pass1);
			}else{
				$user='';
				$pass='';
			}
		}
		$this->head();
		$this->display();
    } 
	public function register(){
	    if(!(strstr($_SERVER['HTTP_REFERER'],'User/userlogin') || strstr($_SERVER['HTTP_REFERER'],'User/register'))){
	        cookie('href',$_SERVER['HTTP_REFERER']);
	    }
	    if(IS_POST){
	        $res=D('User');
	        $data['name']=I('post.name','','htmlspecialchars');
	        $data['email']=I('post.email','','htmlspecialchars');
	        $data['password']=(I('post.password','','htmlspecialchars'));
	        $code=I('post.code','','htmlspecialchars');
	        if($code==session('email_code')){
	            if($res->create()){
	                if($res->add($data)){
	                    if($_COOKIE['href']){
	                        $this->success("恭喜您！！注册成功",$_COOKIE['href'],1);
	                    }else{
	                        $this->success("恭喜您！！注册成功",U('User/vip_center'),1);
	                    }   
	                }else{
	                    $this->error("注册失败");
	                }
	            }else {
	                $this->error($res->getError());
	            }
	        }else{
	            echo "验证码错误";
	        }
	    }else{
	        $this->display();
	    }
    }
	public function vip_center(){
		$this->head();
		$user=M('user');
		$a=$user->field('ID')->where('name="'.$_SESSION['user1'].'"')->find();
		$res=M('user')->where('name="'.$_SESSION['user1'].'"')->select();
		//代收货、代付款
		$prepay=M('order1')->where('user_id='.$a['id'].' and status=0')->select();
		$prerev=M('order1')->where('user_id='.$a['id'].' and status=1')->select();
		$num1=count($prepay);
		$num2=count($prerev);
		//购物车
		$shopping=M('cart')->where('user_id='.$a['id'])->select();
		$num3=count($shopping);
		//购买记录
		$prerev=M('order1')->where('user_id='.$a['id'].' and status=1')->select();
		foreach($prerev as $k=>$v){
		    $prerev[$k]['product']=json_decode($v['goods'],true);
		}
		foreach($prerev as $vv){
		     $a[]=$vv['product'];
		}
		//猜你喜欢
		foreach($a as $v1){
		    $b=$v1;
		}
		
		$like=D('ProcateView')->select();
		$this->assign('num1',$num1);
		$this->assign('num2',$num2);
		$this->assign('num3',$num3);
		$this->assign('buy',$b);
		$this->assign('like',$like);
		$this->assign('res',$res);
		$this->display();
    }
	public function vip_information(){
		$this->head();
		$res=M('user')->where('name="'.$_SESSION['user1'].'"')->select();
		
		foreach($res as $va){
		    $city=$va['city1'];
		    $city2=$va['city3'];
		    $birthmonth=$va['birthmonth'];
		    $birthday=$va['birthday'];
		}
		/*
		 * 查询省市信息
		 */
		$region=D('User');
		$res3=$region->get_list();
		$region1=M('region');
		$res2=$region1->select();
		
		/*
		 * 查询年月日
		 */
		$ymd=M('ymd2');
		$res4=$region->get_list2(); //获得年
		$month=$ymd->where('pid=3')->select();
		$sex=M('sex')->select();
		$user=M('user');
		$a=$user->field('ID')->where('name="'.$_SESSION['user1'].'"')->find();
		$address=M('address')->where('user_id='.$a['id'])->order('address_default desc')->select();
		
		$this->assign('address',$address);
		$this->assign('region2',$res3);
		$this->assign('region',$res2);
		$this->assign('res_ymd2',$res4);
		$this->assign('res_ymd',$month);
		$this->assign('day',$birthday);
		$this->assign('city',$city);
		$this->assign('city2',$city2);
		$this->assign('sex',$sex);
		$this->assign('res',$res);
		$this->display();
    }
    /*
     * Ajax 操作省市联动
     * 
     */
    public function change(){
        if(IS_POST){
            $pid=I('post.pid','','int');
            $region=D('User');
            $data=$region->get_list($pid);
        }
        echo json_encode($data);
    }
    /*
     * Ajax 操作年份联动
     *
     */
    public function change2(){
        if(IS_POST){
            $pid=I('post.pid','','int');
            $region=D('User');
            $data=$region->get_list2($pid);
        }
        echo json_encode($data);
    }
	public function my_order(){
		$this->head();
		$v=M('user')->where('name="'.$_SESSION['user1'].'"')->find();
		/*
		 * 分页
		 */
		// 第一步查询信息的总数
		$pro=M('order1');//先实例化表
		$res=$pro->where('user_id='.$v['id'])->select();
		$num=count($res);
		$lenth='1';
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
		$res=$pro->page($page.','.$lenth)->where('user_id='.$v['id'])->order('ID desc')->select();
		$vip=M('user')->where('name="'.$_SESSION['user1'].'"')->select();
		foreach($res as $k=>$v){
		    $res[$k]['product']=json_decode($v['goods'],true);
		}
		$this->assign('vip',$vip);
		$this->assign('res',$res);
		$this->assign('page',$page);
		$this->assign('pageup',$pageup);
		$this->assign('pagedown',$pagedown);
		$this->assign('totalpage',$totalpage+1);
		$this->display();
    }
    //删除订单
    public function order_del(){
        if(IS_POST){
           $order_num=I('post.id','','htmlspecialchars'); 
           $res=M('order1')->where('order_num="'.$order_num.'"')->delete();
           if($res){
               $this->ajaxReturn(1);
           }else{
               $this->ajaxReturn(-1);
           }
        }
    }
	//修改信息
	public function edit(){
	    if(IS_POST){
	       $ad=I('post.address','','int');
	       $user=M('user');
	       $a=$user->field('ID')->where('name="'.$_SESSION['user1'].'"')->find();
	       if($user->create()){
	           if($user->where('ID='.$a['id'])->save()){
	                   $this->success("个人信息修改成功！！",U('User/vip_information'),1);
	               }
	           }
	       }
	       
	    }
	public function order_confirm(){
		$this->head();
		
		/**
		 * [HTTP_REFERER] 获取上一级路径
		 * 直接购买路径：[HTTP_REFERER] => http://http://127.0.0.1/Jimson/index.php/Home/Product/products_center
		 * 购物车路径：[HTTP_REFERER] => http://http://127.0.0.1/Jimson/index.php/Home/Product/shopping_cart
		 */
		//直接购买过来的
		if(strstr($_SERVER['HTTP_REFERER'],'Product/products_center')){
		    $path=1;
		}
		// 购物车提交过来,在Product 里设置
		$id=M('user')->field('ID')->where('name="'.$_SESSION['user1'].'"')->find();
		$result=M('address')->where('user_id='.$id['id'])->order('address_default desc')->select();
		$this->assign('path',$path);
		$this->assign('result',$result);
		/*
		 * 立即购买提交过来的订单
		 */
		if(IS_POST){
		     $data['id']=I('post.product_id','','int');
		     $data['image']=I('post.image','','htmlspecialchars');
		     $data['size']=I('post.size','','htmlspecialchars');
		     $data['num']=I('post.num','','htmlspecialchars');
		     $res=M('product')->field('name,img1,pro_price,pro_off,po_id,sendprice')->where('ID='.$data['id'])->find();
		     //添加到购物车列表。。并把status设置为2
		     $date['product_id']=$data['id'];
		     $date['user_id']=$id['id'];
		     $date['num']=$data['num'];
		     $date['img']=$data['image'];
		     $date['size']=$data['size'];
		     $date['status']='2';
             $cart=M('cart');
             $old_data1=$cart->where('user_id='.$date['user_id'].' and product_id='.$date['product_id'].' and img="'.$date['img'].'" and size="'.$date['size'].'"')->find();
             //先判断是否购物表中是否已有该商品
             if($old_data1){
                 $date['num']+=$old_data1['num']; //购买量增加
                 if($cart->where('ID='.$old_data1['id'])->save($date)){
                     $cate_name=M('procate')->field('name')->where('ID='.$res['po_id'])->find();
                     $this->assign('id',$data['id']);
                     $this->assign('cate_name',$cate_name['name']);
                     $this->assign('data',$data);
                     $this->assign('res1',$res);
                     $this->display();
                 }
             }else{
                 if($cart->create($date)){
                     if($cart->add()){
                         $cate_name=M('procate')->field('name')->where('ID='.$res['po_id'])->find();
                         $this->assign('id',$data['id']);
                         $this->assign('cate_name',$cate_name['name']);
                         $this->assign('data',$data);
                         $this->assign('res1',$res);
                         $this->display();
                     }
                }
             
             }
		}
    }
	public function order_details(){
		$this->head();
		$this->display();
    }
    //设置为默认地址
    public function add_default(){
        $user_id=M('user')->field('ID')->where('name="'.$_SESSION['user1'].'"')->find();
        if(IS_POST){
            $id=I('post.radio',0,'int');
            $res=M('address');
            $aa=$res->where('ID='.$id)->find();
            if($aa['address_default']!=1){
                $a=$res->where('user_id='.$user_id['id'])->setField('address_default',0);
                $b=$res->where('ID='.$id.' and user_id='.$user_id['id'])->setField('address_default',1);
                if($b){
                    $this->ajaxReturn(1);
                }else{
                    $this->ajaxReturn(0);
                }
            }else{
                $this->ajaxReturn(-1);
            }
        }
    }
    //删除地址
    public function del(){
        if(IS_POST){
            $id=I('post.radio',0,'int');
            $res=M('address');
            $a=$res->where('ID='.$id)->find();
            if($a['address_default']!=1){
                if($res->where('ID='.$id)->delete()){
                    $this->ajaxReturn(1);
                }else{
                    $this->ajaxReturn(0);
                }
            }else{
                $this->ajaxReturn(-1);
            }
        }
    }
	public function add_address(){
	    $user=M('user');
	    $a=$user->field('ID')->where('name="'.$_SESSION['user1'].'"')->find();
	    if(IS_POST){
	        //dump($_POST);
	        //EXIT();
	        $province=I('post.province','','int');
	        $city=I('post.city','','int');
	        $city2=I('post.city2','','int');
	        $data['address_default']=I('post.radio','0','htmlspecialchars');
	        $data['name']=I('post.name','','htmlspecialchars');
	        $data['tel']=I('post.tel','','htmlspecialchars');
	        $data['code']=I('post.code','','htmlspecialchars');
	        $data['street']=I('post.street','','htmlspecialchars');
	        $p=M('region')->field('name')->where('id='.$province)->find();
	        $data['province']=$p['name'];
	        $c=M('region')->field('name')->where('id='.$city)->find();
	        $data['city']=$c['name'];
	        $c1=M('region')->field('name')->where('id='.$city2)->find();
	        $data['city2']=$c1['name'];
	        $data['user_id']=$a['id'];
	        //dump($data);
	        //exit();
	        //添加之前先检查该用户收获地址是否超出最大限制（6）
	        $res=M('address')->where('user_id='.$a['id'])->select();
	        $count=count($res);
	        if($count<6){
	            $address=M('address');
	            if($data['address_default']==1){  //设置默认地址
	                $a=$address->where('user_id='.$a['id'])->setField('address_default',0);
	                if($address->create($data)){
	                    if($address->add()){
	                        $this->success("添加收货地址成功",U('User/add_address'),1);
	                    }
	                }
	            }else{
	                if($address->create($data)){
	                    if($address->add()){
	                        $this->success("添加收货地址成功",U('User/add_address'),1);
	                    }
	               }
	            }
	        }else{
	            $this->error('对不起！！收货地址数目超出限定数目',U('User/vip_information'),1);
	        }
	    }else{
	        /*
	         * 查询省市信息
	         */
	        $region=D('User');
	        $res=$region->get_list();
	        $this->head();
	        $this->assign('region',$res);
	        $this->display();
	    }

    }
    /**
     * ajax发送验证码
     */
    public function send_mail() {
        if(IS_POST) {
            //接收提交过来的邮箱
            $email = I('post.mail','','addslashes');
            //实例化邮件核心类文件
            $mail = new PHPMailer();
            //获取验证码
            $code = '';
            for($i=1;$i<5;$i++) {
                $code .=mt_rand(0,9);
            }
            //保存验证码
            session('email_code',$code);
            //发送验证码内容
            $body = '您的注册验证码是:'.$code.'请及时注册,以免过期';
            $mail->IsSMTP();
            $mail->SMTPDebug  = 1;
            $mail->SMTPAuth   = true;   // enable SMTP authentication
            $mail->Host       = "smtp.126.com"; // sets the SMTP server
            $mail->Port       = 25;                    // set the SMTP port for the GMAIL server
            $mail->Username   = "phpe1418@126.com"; // SMTP account username
            $mail->Password   = "phpe1418";        // SMTP account password
            $mail->SetFrom('phpe1418@126.com', 'Jimson collection（占臣品牌）');//设置接收来源
            $mail->AddReplyTo("phpe1418@126.com","First Last");//回复邮箱
            $mail->Subject    = "用户注册验证码";//标题
            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->MsgHTML($body);//内容使用html格式
            $address = $email;//发送地址
            $mail->AddAddress($address, "亲");//有多个邮箱地址，使用多次
            if(!$mail->Send()) {
                echo 0; //没有发送
            } else{
                echo 1; //已经发送
            }
        }else {
            echo -2; //非法请求
        }
    }
    public function change_password(){
        if(IS_POST){
            $pass = I('post.pass','','htmlspecialchars');
            $data['password'] = I('post.pass1','','htmlspecialchars');
            $pass2 = I('post.pass2','','htmlspecialchars');
            $res=M('user')->where("name='".$_SESSION['user1']."' and password='".$pass."'")->find();
            if($res){
               if($data['password']==$pass2){
                    if($res->create($data)){
                        if($res->save()){
                            
                            $this->ajaxReturn('1');
                        }
                    }
                }else{
                     $this->ajaxReturn('-2'); //两次密码不同
                }
                echo -2;
            }else{
                 $this->ajaxReturn('-1'); //原始密码错误
            }
        }else{
            $this->head();
            $this->display();
        }
    }
    public function chang_head(){
        if(IS_POST){
            $data['headimg']=I('post.img','','htmlspecialchars');
            if(M('user')->where('name="'.$_SESSION['user1'].'"')->save($data)){
                $this->success("修改成功，正在跳转用户中心",U('User/vip_information'),1);
            }
        }else{
            $res=M('user')->where('name="'.$_SESSION['user1'].'"')->select();
            $this->assign('res',$res);
            $this->display();
        }
       
    }
}