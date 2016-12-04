<?php 
namespace Admin\Controller;
use Think\Controller;
/**
 * 产品分类页面
 */
class ProcateController extends BackController{
    /**
     * 首先获取父类分类
     */
    public function procate(){
        $get=D('Procate');     //事例化model自定的类
        $procate=$get->get_list();   //引用方法
        foreach($procate as $k=>$v){
            $procate1=$get->get_list($v['id']);
            $procate[$k]['son']=$procate1;
        }
        $this->assign('data',$procate);
        $this->display();
    }
    public function addprocate(){
        /**
         * 首先进行分类查询，实例化MODEL
         */
        $get=D('Procate');
        if(IS_POST){
            if($get->create()){ //创建数据对象
                if($get->add()){
                   $this->success("产品分类添加成功！！",U('Procate/procate'),1); 
                     }
                   }else {//获取创建数据对象失败信息
                            $this->error($get->getError(),U('Procate/procate'),3);
                      }
             }else{
                    $data=$get->get_list();
                    $this->assign('data',$data);
                    $this->display();
                   }
         }
         /**
          * ajax删除函数
          */
     public function del(){
         if(IS_POST){
             $id=I('post.id','','htmlspecialchars');
             /**
              * 先查询是否分类有商品
              */
             $product=M('product');
             $result=$product->where('po_id='.$id)->find();
             if($result){
                 echo 2;  //分类下有商品
             }else{
                 $product2=M('procate');
                 $result2=$product2->where('p_id='.$id)->find();
                 if($result2){
                     echo 1;    //分类下有子分类
                 }else{
                     $res=$product2->where('ID='.$id)->delete();
                     if($res){
                         echo 0;  //删除成功
                     }else{
                         echo -1;
                     }
                 }
             }
         }else {
           echo -2; //非法请求,不是ajax请求过来数据 
        }
     }
     /**
      * 编辑函数
      */
     public function edit(){
         $data=D('procate');
         if(IS_POST){
             $id=I('post.ID','1','int');
             if($data->create()){
                 $res=$data->where('ID='.$id)->save();
                 if($res){
                     $this->success("恭喜您!!更新成功",U('Procate/procate'));
                 }else{
                     $this->error("更新失败!!",U('Procate/procate'));
                 }
             }
         }else{
             $id=I('get.id','1','int');// 获取值
             $data_cate=$data->where('ID='.$id)->find(); //查询选择的分类
             $cate=$data->get_list();  //获取分类列表
             $this->assign('cate',$cate);
             $this->assign('data',$data_cate);
             $this->display();
         }
     }
   }
?>