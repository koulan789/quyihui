<?php 
namespace Admin\Model;
use Think\Model;
class NewsModel extends Model{
    /**
     * 自动验证
     */
    protected $_validate = array(     
        array('title','require','新闻标题不能重复',0,'unique',1)
        
    );
}