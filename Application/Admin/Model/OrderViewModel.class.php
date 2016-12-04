<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class OrderViewModel extends ViewModel{
    public $viewFields = array(
        'user'=>array('name'),
        'order1'=>array('ID','totalprice','order_num','user_id','order_time','content','status','goods','_on'=>'user.ID=order1.user_id'),
        'address'=>array('name'=>'add_name','tel','province','city','city2','street','_on'=>'address.ID=order1.address_id'),
        'status'=>array('name'=>'status_name','_on'=>'status.order_status=order1.status'),
    );
    public function get_list($pid=1) {
        $cate = M('region');
        $data = $cate->where('pid='.$pid)->select();
        return $data;
    }
}