<?php 
namespace Admin\Model;
use Think\Model;
class NewsnavModel extends Model{
    /**
     * 自动验证
     */
    protected $_validate = array(     
        array('name','require','新闻标题不能重复',0,'unique',1)
        
    );
}