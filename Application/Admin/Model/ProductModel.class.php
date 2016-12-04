<?php
namespace Admin\Model;
use Think\Model;
class ProductModel extends Model{
    /**
     * 自动验证
     */
    protected $_validate = array(
        array('name','require','该产品已存在',0,'unique',1)
    
    );
    public function get_list($p_id=0){
        $cate = M('procate');
        $data = $cate->where('p_id='.$p_id)->select();
        return $data;
    }
}