<?php 
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{
    /**
     * 登录函数
     */
    public function login(){
        if(IS_AJAX){
            $data['name']=I('post.name','','htmlspecialchars');
            $data['pass']=I('post.pass','','htmlspecialchars');
            $verify=I('post.verify','','htmlspecialchars');
            $remember=I('post.remember','','htmlspecialchars');
            if($remember){
                cookie('user',$data['name'],3600);
                cookie('pass',$data['pass'],3600);
            
            }else{
                cookie('user',null);
                cookie('pass',null);
            }
            if(strtolower($verify)==strtolower(session('verify'))){
                $res=M('admin')->where($data)->find();
                if($res){
                    session('admin',$res);
                    session('verify',null);
                    $this->ajaxReturn(0);
                }else{
                    $this->ajaxReturn(1);
                } 
            }else{
                $this->ajaxReturn(2);
            }
            
            }else{
                if(!empty($_COOKIE['user']) && !empty($_COOKIE['pass'])){
                    $user1 = $_COOKIE['user'];
                    $pass1 = $_COOKIE['pass'];
                    $this->assign('user',$user1);
                    $this->assign('pass',$pass1);
                }else{
                    $this->assign('user',null);
                    $this->assign('pass',null);
                }
        }
        $this->display();
    }
    /**
     * 设计验证码样式
     */
    public function verify(){
        $config = array(
            'fontSize'   =>   15,  //字体大小
            'useCurve'   =>   true,  //使用曲线
            'useNoise'   =>   false,  //使用杂点
            'length'     =>    4,  //位数
            'imageW'     =>   100, //宽度
            'imageH'     =>    50, //高度
        );
        $Verify =     new \Think\Verify($config);
        $Verify->entry();
    }
}

?>