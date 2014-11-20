<?php

/**
* @package     Jue
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.10.1
**/

# 每个层路径设计，均可更改，更改后连同文件夹名字一起更改。
define('__Controller__', './controller/');
define('__Library__', './library/');
define('__Help__', './help/');
define('__View__', './view/');
define('__Config__', './config/');
define('__Cache__', './cache/');
define('__Package__', './package/');
define('__Language__', './language/');					
define('__Log__', './log/');
		
define('__Title__', '觉');						//每个页面默认title
define('__Base__', 'http://localhost/');		//基础目录路径(写你的服务器IP+根目录路径)
define('__Public__', '/public/');				//静态文件路径
define('__ExpiredTime__', 60 );					//session超时时间设置
define('__Prefix__', '/');    					//uri的前缀

define('HTTP_HOST', preg_replace('~^www\.~i', '', $_SERVER['HTTP_HOST']));

?>