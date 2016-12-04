<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends BackController{
    public function admin(){
        $admin=D('AdminView');
        $data=$admin->select();
        $this->assign('admin',$data);
        $this->display();
    }
    /**
     * 修改管理员
     */
    public function manage(){
        $power=C('MENU');
        $this->display();
        
    }
   /**
    * 添加管理员
    */ 
    public function add(){
        if(IS_POST){
            $manage=D('Admin');
            $data['p_id']=I('post.id','0','int');
            $data['name']=I('post.name','','htmlspecialchars');
            $data['pass'] =(I('post.pass'));
            if($manage->create($data)){
                if($manage->add()){
                    echo json_encode(array('msg'=>1));
                } else{
                    echo json_encode(array('msg'=>0));
                }
            }else{
                echo json_encode(array('msg'=>2));
            }
        }else{
            /**
             * 添加之前显示角色类型
             */
            $get=D('Admin');
            $data=$get->get_list();
            $this->assign('data',$data);
            $this->display();
        }
        
    }
    /**
     * 删除管理员
     */
    public function del(){
        if(IS_AJAX){
            $id=I('post.id',0,'int');
            $data=M('admin')->where('ID='.$id)->delete();
            if($data){
                echo 1;
            }else{ 
                echo 0;
            }
          }else{
                echo 2;
        }
    }
    /**
     * 修改管理员
     */
    public function edit(){
        if(IS_AJAX){
            $manage=M('admin');
            $id2=I('post.id2','0','int');
            $data['name']=I('post.name','','htmlspecialchars');
            $data['pass'] =I('post.pass');
            $data['p_id'] =I('post.id');
            //dump($data);
            if($manage->create($data)){
                if($manage->where('ID='.$id2)->save()){
                    //echo 1;
                    //$this->ajaxReturn(array('msg'=>1),'json');
                    echo json_encode(array('msg'=>1));
                } else{
                    //echo 0;
                    //$this->ajaxReturn(array('msg'=>0),'json');
                    echo json_encode(array('msg'=>0));
                }
            }
        }else{
            /**
             * 修改之前显示admin所有信息
             */
            $id=I('get.id','0','int');
            $admin=M('admin')->where('ID='.$id)->find();
            $get=D('Admin');
            $data=$get->get_list();
            $this->assign('admin',$admin);
            $this->assign('data',$data);
            $this->display();
        }
    }
}