<?php 
namespace Admin\Model;
use Think\Model;
class ProcateModel extends Model{
    /**
     * 自动验证
     */
    protected $_validate = array(     
        array('name','require','分类名称必须存在，且唯一',0,'unique',1)
        
    );
    /**
     * 在数据层，查询分类
     */
    public function get_list($p_id=0) {
        $cate = M('procate');
        $data = $cate->where('p_id='.$p_id)->order('ID desc')->select();
        return $data;
    }
}

?>