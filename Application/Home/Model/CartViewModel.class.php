<?php
namespace Home\Model;
use Think\Model\ViewModel;
class CartViewModel extends ViewModel{
    public $viewFields = array(
        'cart'=>array('num','img','size','status','user_id'),
        'product'=>array('ID','name','img1','pro_price','_on'=>'cart.product_id=product.ID'),
        'procate'=>array('name'=>'cate_name','_on'=>'product.po_id=procate.ID'),
    );
}