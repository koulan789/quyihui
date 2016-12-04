<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
    /**
     * 自动验证
     */
    protected $_validate = array(
        array('name','require','该用户名称已存在',0,'unique',1),
        array('email','require','该邮箱已被注册',0,'unique',1),   
    );
    /**
     * 在数据层，查询分类
     */
    public function get_list($pid=1) {
        $cate = M('region');
        $data = $cate->where('pid='.$pid)->select();
        return $data;
    }
    public function get_list2($pid=1) {
        $cate = M('ymd2');
        $data = $cate->where('pid='.$pid)->select();
        return $data;
    }
}