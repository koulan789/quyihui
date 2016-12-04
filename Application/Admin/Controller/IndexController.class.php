<?php 
namespace Admin\Controller;
use Think\Controller;
/**
 *后台首页
 */
class IndexController  extends BackController{
    public function index(){
        $id=(session('admin')['id']);
        $a=(session('admin')['name']);
        $this->assign('user',$a);
        $this->assign('id',$id);
        $power=D('AdminView')->field('power')->where('admin.ID='.$id)->find();
        $p=explode(',',$power[power]);
       
        //读取配置文件
        $menu=C('MENU');
        foreach($menu as $k=>$v){
            foreach($v['son'] as $ke=>$va){
                $me[$va['id']]=$va['name'];
            }
        } 
        $this->assign('menu',$menu);
        $this->assign('p',$p);
        $this->display();
    }
    public function reset(){
        session('admin',null);
        $this->success("正在注销，请稍候.....",U('Login/login'),1);
    }
    /**
     * 返回网站首页
     */
    public  function goback(){
        $this->success('正在进入网站首页，请稍候.....',U('Home/Index/index'),1);
    }
    
}

?>