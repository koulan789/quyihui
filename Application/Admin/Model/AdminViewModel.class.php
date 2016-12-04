<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class AdminViewModel extends ViewModel{
    public $viewFields = array(     
        'admin'=>array('ID','name','p_id'),     
        'power'=>array('power','name'=>'p_name', '_on'=>'admin.p_id=power.ID'),
    );
}
