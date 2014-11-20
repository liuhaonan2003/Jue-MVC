<?php

/**
* @package     JueMail
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.9.22
**/


$config['mail']['host'] = "smtp.163.com"; 			/* 邮件服务器地址 */
$config['mail']['port'] = 25; 						/* smtp服务器的端口，一般是25 */
$config['mail']['user'] = "xxx@gmail.com"; 		/* 您登录smtp服务器的用户名 */
$config['mail']['pwd'] = ""; 				/* 您登录smtp服务器的密码 */
$config['mail']['type'] = "HTML"; 					/* 邮件的类型，可选值是 TXT 或 HTML ,TXT 表示是纯文本的邮件,HTML 表示是 html格式的邮件 */
$config['mail']['sender'] = "xxx@gmail.com";
$config['mail']['auth'] = true; 
$config['mail']['debug'] = false; 
$config['mail']['timeout'] = 20;
	
	/* 发件人,一般要与您登录smtp服务器的用户名($smtpuser)相同,否则可能会因为smtp服务器的设置导致发送失败 */ 
	// public $smtp = new smtp($smtpserver,$port,true,$smtpuser,$smtppwd,$sender); 
	// public $smtp->debug = false; //是否开启调试,只在测试程序时使用，正式使用时请将此行注释 
	// public $to = "626184755@qq.com"; //收件人 
	// public $subject = "你好"; 
	// public $body = "你发送的内容 ";
	// $send=$smtp->sendmail($to, $sender,$subject, $body, $type);  

?>