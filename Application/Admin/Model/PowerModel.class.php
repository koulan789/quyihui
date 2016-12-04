<?php
namespace Admin\Model;
use Think\Model;
class PowerModel extends Model{
    /**
     * 自动验证
     */
    protected $_validate = array(
        array('name','require','该角色已存在',0,'unique',1)
    );
    
}