<?php
namespace Admin\Controller;
class PowerController extends BackController{
    public function power(){
        /**
         * 获取配置文件里的权限菜单
         */
       $data_menu=C('MENU'); //实例这个权限菜单
       $data=array();
       //第一步先查询出该权限菜单中的权限列表
       foreach($data_menu as $val){     
             foreach($val['son'] as $va){
                  $data[$va['id']]=$va['name'];
         }
       }
       //第二步根据power中的信息与第一步中的值进行匹配
        $manage=M('power')->select();
        foreach($manage as $k=>$v){
            $data_power=array();  //定义新的空数组，避免重写入
            $power=explode(',',$v['power']);
            foreach($power as $v1){
                $data_power[]=$data[$v1];
            }
            $manage[$k]['power']=$data_power; //最终得到以power为下标的权限数组
        }
        $this->assign('data',$data);
        $this->assign('manage',$manage);
        $this->display();
    }
    /**
     * 添加角色
     */
    public function add(){
        if(IS_POST){  
            $manage=M('power'); 
            $data['name']=I('post.name','','htmlspecialchars');
            $data['power'] =(I('post.power'));
            if($manage->create($data)){  
                if($manage->add()){
                    //echo 1;
                    //$this->ajaxReturn(array('msg'=>1),'json');
                    echo json_encode(array('msg'=>1));
                } else{
                    //echo 0;
                    //$this->ajaxReturn(array('msg'=>0),'json');
                    echo json_encode(array('msg'=>0));
                }
            }else{
                echo json_encode(array('msg'=>2));
                //$this->ajaxReturn(array('msg'=>2),'json');
            }
        } else{
            /**
             * 添加前先显示所有权限
             */
            $power=C('MENU');
            $this->assign('data1',$power);
            $this->display();
        }
    }
    /**
     * 删除角色
     */
    public function del(){
        if(IS_AJAX){
            $id=I('post.id',0,'int');
            $data=M('admin')->where('p_id='.$id)->find();
            if($data){
                echo -1;
            }else{
                $power =M('power');
                $power->where('ID='.$id)->delete();
                if($power){
                    echo 0;
                }else{
                    echo 1;
                }
            }
        }else{
            echo 2;
       }
    }
    /**
     * 编辑角色
     */
    public function edit(){
        if(IS_AJAX){
            $manage=M('power');
            $id1=I('post.id','0','int');
            $data['name']=I('post.name','','htmlspecialchars');
            $data['power'] =I('post.power');
            //dump($data);
            if($manage->create($data)){
                if($manage->where('ID='.$id1)->save()){
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
             * 修改前先显示所有权限
             */
            $power=C('MENU');  //实例化配置文件
            $id=I('get.id','1','int');
            $data=M('power')->where('ID='.$id)->find();
            $a=explode(',',$data['power']);
            $this->assign('a',$a);
            $this->assign('data',$data);
            $this->assign('data1',$power);
            $this->display();
        }
    }
}