<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model{
    /**
     * 自动验证
     */
    protected $_validate = array(
        array('name','require','管理员名称不能重复',0,'unique',1)

    );
    /**
     * 在数据层，查询分类
    */
    public function get_list() {
        $cate = M('power');
        $data = $cate->select();
        return $data;
    }
}