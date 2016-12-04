<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_PARSE_STRING'  =>array(     
        '__COMMON__' => '/Jimson/Application/Admin/Common/',  //设置常量
        ),
    //配置权限导航
    'MENU' => array(
        array(
            'id' => '1',
            'name' => '产品管理',
            'son' => array(
                array('id'=>'11','name'=>'产品分类','link'=>'Procate/procate'),
                array('id'=>'12','name'=>'产品中心','link'=>'Product/product'),
            )
        ),
        array(
            'id' => '2',
            'name' => '用户管理',
            'son' => array(
                array('id'=>'21','name'=>'会员管理','link'=>'User/user'),
                array('id'=>'22','name'=>'订单管理','link'=>'User/order'),
                array('id'=>'23','name'=>'留言管理','link'=>'User/contactus'),
            )
        ),
        array(
            'id' => '3',
            'name' => '管理员管理',
            'son' => array(
                array('id'=>'31','name'=>'角色管理','link'=>'Power/power'),
                array('id'=>'32','name'=>'管理员管理','link'=>'Admin/admin')
            )
        ),
		array(
            'id' => '4',
            'name' => '新闻管理',
            'son' => array(
                array('id'=>'41','name'=>'新闻类型管理','link'=>'Newsnav/index'),
                array('id'=>'42','name'=>'新闻管理','link'=>'News/index')
            )
        )
        
    ),
    'SIZE' =>array(
        array('id' =>'1',
               'name' =>'XS|(155 80A)'
            ),
        array('id' =>'2',
               'name' =>'S|(160 88A)'
        ),
        array('id' =>'3',
               'name' =>'M|(165 96A)'
        ),
        array('id' =>'4',
               'name' =>'L|(170 104A)'
        ),
        
    ),
  );