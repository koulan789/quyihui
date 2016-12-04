<?php
namespace Admin\Controller;
class UserController extends BackController{
    public function user(){
        $res=M('user')->order('ID desc')->select();
        $this->assign('res',$res);
        $this->display();
    }
    public function del(){
        if(IS_POST){
            $id=I('post.id','','int');
            $res=M('user');
            if($res->where('ID='.$id)->delete()){
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn(-1);
            }
        }
    }
    public function order(){
        /**
         * 实现分页
         */
        // 第一步查询信息的总数
        $pro=D('OrderView'); //先实例化表
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
        //获取订单联表信息
       foreach($res as $k=>$val){
            $res[$k]['product']=json_decode($val['goods'],true);
        }
        $this->assign('page',$page);
        $this->assign('totalpage',$totalpage+1);
        $this->assign('res',$res);
        $this->display();
    }
    //删除订单表信息
    public function orderdel(){
        if(IS_POST){
            $orderid=I('post.id','1','int');
            $res=M('order1');
            if($res->where('ID='.$orderid)->delete()){
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn(-1);
            }
        }
    }
    //修改订单
    public function edit(){
        if(IS_POST){
            $res=D('OrderView');
            $data['order_num']=I('post.order_num','','htmlspecialchars');
            $province1=I('post.province','','htmlspecialchars');
            $city1=I('post.city','','htmlspecialchars');
            $city21=I('post.city2','','htmlspecialchars');
            $p=M('region')->where('id='.$province1)->find();
            $c=M('region')->where('id='.$city1)->find();
            $c2=M('region')->where('id='.$city21)->find();
            $data['province']=$p['name'];
            $data['city']=$c['name'];
            $data['city2']=$c2['name'];
            $data['street']=I('post.street','','htmlspecialchars');
            $data['totalprice']=I('post.totalprice','','htmlspecialchars');
            $id2=I('post.id','','htmlspecialchars');
                if($res->where('order1.ID='.$id2)->save($data)){
                    $this->success("修改成功！！正在跳转到订单列表页",U('User/order'),1);
                }
        }else{
            $id=I('get.id','','int');
            $res=D('OrderView');
            $order=$res->where('order1.ID='.$id)->select();
            foreach($order as $v){
                $city=$v['city'];
                $city2=$v['city2'];
            }
            $ci=M('region')->where('name="'.$city.'"')->find();
            $ci2=M('region')->where('name="'.$city2.'"')->find();
            $province=$res->get_list();
            $this->assign('province',$province);
            $this->assign('ci2',$ci2);
            $this->assign('city',$ci['id']);
            $this->assign('city2',$ci2['id']);
            $this->assign('id',$id);
            $this->assign('order1',$order);
            $this->display();
        }
        
    }
    /*
     * Ajax 操作省市联动
     *
     */
    public function change(){
        if(IS_POST){
            $pid=I('post.pid','','int');
            $region=D('OrderView');
            $data=$region->get_list($pid);
        }
        echo json_encode($data);
    }
    //联系我们
    public function contactus(){
        $res=M('message')->select();
        $this->assign('res',$res);
        $this->display();
    }
   //删除留言
   public function mesdel(){
   if(IS_POST){
            $id=I('post.id','','int');
            $res=M('message');
            if($res->where('ID='.$id)->delete()){
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn(-1);
            }
        }
   }
    public function put_out(){
        $id=I('get.id','','htmlspecialchars');
        $res=D('OrderView');
        $result=$res->where('order1.ID in('.$id.')')->select();
        Vendor('Excel.PHPExcel');
        $objPHPExcel=new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator('a')
        ->setLastModifiedBy('b')
        ->setTitle('标题')
        ->setSubject('主题')
        ->setDescription('描述')
        ->setKeywords('关键字')
        ->setCategory('c');
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1','订单号')
        ->setCellValue('B1','下单时间')
        ->setCellValue('C1','收货地址')
        ->setCellValue('D1','订单状态')
        ->setCellValue('F1','订单总价格')
        ->setCellValue('F1','商品详细信息');
        $i=2;
        foreach($result as $k=>$v){
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i,$v['order_num'])
            ->setCellValue('B'.$i,$v['order_time'])
            ->setCellValue('C'.$i,$v['add_name'].$v['tel'].$v['province'].$v['city'].$v['city2'].$v['street'])
            ->setCellValue('D'.$i,$v['status_name'])
            ->setCellValue('E'.$i,$v['totalprice']);
            $product=json_decode($v['goods'],true);
             foreach($product as $vv){
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('F'.$i,'商品名称:'.$vv['name'].'  商品数目:'.$vv['num'].'   商品价格:'.$vv['pro_price'].'  商品尺码:'.$vv['size']);
            }
            $i++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('商品');
        $objPHPExcel->setActiveSheetIndex(0);
        $filename=urlencode('商品订单统计表').'_'.date('Y-m-dHis');
        
        /*
         *生成xlsx文件
         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
         header('Cache-Control: max-age=0');
         $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        */
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}