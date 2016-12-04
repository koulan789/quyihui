<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_PARSE_STRING'  =>array(
        '__COMMON__' => '/Jimson/Application/Home/Common/',  //设置常量
    ),
    'Alipay'=>array(
        //合作身份者id，以2088开头的16位纯数字
        'partner'		=> '2088021119469553',
        
        //收款支付宝账号
        'seller_email'	=> '2355908671@qq.com',
        
        //安全检验码，以数字和字母组成的32位字符
        'key'			=> '6x7f5gin1grq6wvpfwji07m7rtqtx6ey',
        
        
        //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        
        
        //签名方式 不需修改
       'sign_type'   => strtoupper('MD5'),
        
        //字符编码格式 目前支持 gbk 或 utf-8
        'input_charset'=> strtolower('utf-8'),
        
        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        'cacert'    => getcwd().'\\cacert.pem',
        
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        'transport'    => 'http'
    ),
);