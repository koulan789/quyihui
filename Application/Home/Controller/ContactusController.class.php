<?php
namespace Home\Controller;
use Think\Controller;
class ContactusController extends PublicController {
    public function contact_us(){
        if(IS_POST){
            $res=M('message');
            if($res->create()){
                if($res->add()){
                    $this->success("恭喜，留言成功！！谢谢您的参与",U('Contactus/contact_us'),1);
                }
            }
            
        }else{
            $this->head();
            $contactus=M('contactus')->select();
            $this->assign('contactus',$contactus);
            $this->display();
        }
    }
}