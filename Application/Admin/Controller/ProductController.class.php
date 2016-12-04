<?php
namespace Admin\Controller;
use Think\Controller;
class ProductController extends BackController{
 
    public function product(){
        /**
         * 实现分页
         */
        // 第一步查询信息的总数
        $pro=M('product'); //先实例化表
        $num=$pro->count();
        $lenth='2';
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
        $res=$pro->page($page.','.$lenth)->order('ID desc')->select();
        /**
         * 获取尺码
         */
        $size=C('SIZE'); //实例化尺码
        //第一步查询相应的尺码数据
        foreach($size as $k=>$val){
            $data_size[$val['id']]=$val['name'];
        }
        //第二步遍历product表中的尺码字段数据，与实例化尺码数据相关联
        foreach($res as $k=>$va){
            $data_size2=array();
            $size1=explode(',',$va['p_size']);
            foreach($size1 as $v){
                $data_size2[]=$data_size[$v];
            }
            $res[$k]['size']=$data_size2;  //得到最终的尺码数据
        }
        /**
         *获取产品类型 调用视图层
         */
        $procate=D('ProductView');
        $data_cate=$procate->select();
        foreach($data_cate as $v){
            $data[$v['po_id']]=$v['p_name'];
        }
        foreach($res as $k=>$v1){
            $res[$k]['cate']=$data[$v1['po_id']];
        }
        
        $this->assign('data',$res);
        $this->assign('page',$page);
        $this->assign('totalpage',$totalpage+1);
        $this->display();
    }
    /**
     * 编辑产品
     */
    public function edit(){
        $id=I('post.id',0,'int');
        if(IS_POST){
            $re=M('product');
            $data1['p_size']=implode(',',I('post.p_size','','htmlspecialchars'));
            $data1['name']=I('post.name','','htmlspecialchars');
            $data1['img1']=I('post.img1','','htmlspecialchars');
            $data1['img2']=I('post.img2','','htmlspecialchars');
            $data1['img3']=I('post.img3','','htmlspecialchars');
            $data1['pro_price']=I('post.pro_price','','htmlspecialchars');
            $data1['p_color1']=I('post.p_color1','','htmlspecialchars');
            $data1['p_color2']=I('post.p_color2','','htmlspecialchars');
            $data1['color_img1']=I('post.color_img1','','htmlspecialchars');
            $data1['color_img2']=I('post.color_img2','','htmlspecialchars');
            $data1['p_introduce']=I('post.p_introduce','','htmlspecialchars');
            $data1['p_source']=I('post.p_source','','htmlspecialchars');
            $data1['po_id']=I('post.po_id','','htmlspecialchars');
            if($re->create($data1)){
                if($re->where('ID='.$id)->save()){
                    $this->success("修改成功！！正在跳转至列表界面，请稍候....",U('Product/product'),1);
                }else{
                    $this->error("修改失败！！请刷新重试");
                }
            }
        }else{
            $result=D('ProductView');
            $id=I('get.id',0,'int');
            $size=C('SIZE'); //实例化尺码
            //添加之前显示分类
            $procate=D('procate');
            $data=$procate->get_list();//分类信息
            //根据get.id 获取所有信息
            $res=$result->where('product.ID='.$id)->find();
            $p_size=explode(',',$res['p_size']);
            $this->assign('p_size',$p_size);
            $this->assign('res',$res);
            $this->assign('size',$size);
            $this->assign('data',$data);
            $this->display();
        }  
    }
    /**
     * 删除产品
     */
   public function del(){
       if(IS_AJAX){
               $id=I('post.id',0,'int');{
               $product =M('product');
               $product->where('ID='.$id)->delete();
               if($product){
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
    * 添加产品
    */
   public function add(){
       if(IS_POST){
           $data['p_size']=implode(',',I('post.p_size','','htmlspecialchars'));
           $data['name']=I('post.name','','htmlspecialchars');
           $data['img1']=I('post.img1','','htmlspecialchars');
           $data['img2']=I('post.img2','','htmlspecialchars');
           $data['img3']=I('post.img3','','htmlspecialchars');
           $data['pro_price']=I('post.pro_price','','htmlspecialchars');
           $data['p_color1']=I('post.p_color1','','htmlspecialchars');
           $data['p_color2']=I('post.p_color2','','htmlspecialchars');
           $data['color_img1']=I('post.color_img1','','htmlspecialchars');
           $data['color_img2']=I('post.color_img2','','htmlspecialchars');
           $data['p_introduce']=I('post.p_introduce','','htmlspecialchars');
           $data['p_source']=I('post.p_source','','htmlspecialchars');
           $data['po_id']=I('post.po_id','','htmlspecialchars');
           $data['pro_off']=I('post.pro_off','','htmlspecialchars');
           $data['sendprice']=I('post.sendprice','','htmlspecialchars');
           $product=D('Product');
           if($product->create($data)){
               if($product->add()){
                   $this->success("添加成功！！正在跳转列表界面，请稍候....",U('Product/product'),1);
               }else{
                   $this->error("添加失败！！",U('Product/add'),1);
               }
           }else{
               $this->error($product->getError(),U('Product/add'));
           }
       }else{
           $size=C('SIZE'); //实例化尺码
           //添加之前显示分类
           $procate=D('procate');
           $data=$procate->get_list();
           foreach($data as $k=>$val){
               $data1=$procate->get_list($val['id']);
               $data[$k]['son']=$data1;
           }
           $this->assign('size',$size);
           $this->assign('data',$data);
           $this->display();
       }
       
   }
    /**
      * ajax查询分类的方法
      */
     public function change_cate() {
         if(IS_AJAX) {
             $id = I('post.p_id',0,'int');
             $cate = D('procate');
             $data = $cate->get_list($id);
         }else {
             $data = array('error'=>2,'msg'=>'请求类型错误');
         }
         echo json_encode($data);
     }
}