<?php
	header("Content-Type:text/html;charset=utf-8");
	define('APP_DEBUG',true);
	// 定义应用目录
    define('APP_PATH','./Application/');
	define('__JS','/Jimson/Application/Home/Public/js/');
	define('__CSS','/Jimson/Application/Home/Public/css/');
	define('__IMG','/Jimson/Application/Home/Public/images/');
	require_once('./ThinkPHP/ThinkPHP.php');