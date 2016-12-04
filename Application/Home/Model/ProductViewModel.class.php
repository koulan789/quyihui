<?php
namespace Home\Model;
use Think\Model\ViewModel;
class ProductViewModel extends ViewModel{
    public $viewFields = array(
        'product'=>array('name','img1','pro_price','pro_off','sendprice'),
        'cart'=>array('ID','num','img','size','user_id','status','_on'=>'product.ID=cart.product_id'),
        'procate'=>array('name'=>'cate_name','_on'=>'product.po_id=procate.ID'),
    );
}