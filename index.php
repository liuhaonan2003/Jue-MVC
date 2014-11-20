<?php

/**
* @package     Jue
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.9.22
**/

header("Content-type: text/html; charset=utf-8"); 
// session
session_start();

require("config.inc.php");      // define 
require("system/Comm.php");     // common fuction
require("system/System.php");   // system model
require("system/Router.php");   // router

# 路由表设计,不区分大小写，全部自由设计
$prefix=__Prefix__; #设置前缀
$req = array( 
	/*============================ php ============================*/
    $prefix => "index",
    $prefix.'this' => "this",
    $prefix.'test' => "test",                   //模块测试
    $prefix.'system' => "system",				//查看系统 this 类
    $prefix.'ajax' => "ajax", 					//ajax测试页面
    $prefix.'number/:number' => "number", 		//数字参数调用
    $prefix.'string/:string' => "string", 		//字符参数调用
    $prefix.'alpha/:alpha' => "alpha", 			//混合参数调用
    $prefix.'query' => "query",

    $prefix.'user/index/:number' => "user/Index",
    $prefix.'index/:alpha' => "Index",
    $prefix.'info' => "info",
    $prefix.'oss' => "oss",
    
    /*============================ ajax ============================*/
    $prefix.'ajax/index'=>'ajax/Index',

);
# 导入路由表
JueRouter::serve( $req );

?>