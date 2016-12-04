<?php
namespace Home\Model;
use Think\Model\ViewModel;
class ProcateViewModel extends ViewModel{
    public $viewFields = array(
        'product'=>array('ID','name','img1','pro_price','pro_off','sendprice'),
        'procate'=>array('name'=>'cate_name','_on'=>'product.po_id=procate.ID'),
    );
}