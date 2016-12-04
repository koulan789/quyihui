<?php
namespace Admin\Controller;
use Think\Controller;
class BackController extends Controller{
    /**
     * 后台的入口文件，进行初始化，调用基类的构造函数
     */
    public function __construct(){
        header('content-type:text/html;charset=utf-8');
        parent::__construct(); //引用基类的构造函数
        if(!session('?admin')){
            $this->error("对不起！！你还未登陆，请登录.....",U('Login/login'),2);
            
        }
    }
}

?>