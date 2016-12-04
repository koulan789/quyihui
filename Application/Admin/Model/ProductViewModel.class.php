<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class ProductViewModel extends ViewModel{
    public $viewFields = array(
        'product'=>array('ID','po_id','name','img1','img2','img3','pro_price','sendprice','pro_off','p_size','p_color1','p_color2','color_img1','color_img2','p_introduce','p_source'),
        'procate'=>array('p_id','name'=>'p_name', '_on'=>'product.po_id=procate.ID'),
    );
}