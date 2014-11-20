<?php

/**
* @package     Index
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.9.23
**/ 

class test extends Jue{
	
	function __construct(){

	}

	# post、get  			函数为<form>表单发送
	# post_xhr、get_xhr		为ajax发送
	# 可以声明其他函数，均在Jue这个类里，均可调用Jue内其他对象。
	# 注意变量重复声明现象

	function get(){
		
		$this->load_language( 'index' );

		$data = array(//这是渲染时候的传递的
			'base'=>__Base__,
			'public'=>__Public__,
			'time'=> date('Y-m-d H:i:s'),
		);

		/*===============================================================================*/

		// cache缓存测试
		echo 'cache测试.....<br>';
		$this->load_library('JueCache', 'cache');
		echo '添加cache.....<br>';
		$this->cache->add( 'data', $data );
		echo '添加成功.....<br>';

		echo '删除cache.....<br>';
		$this->cache->delete( 'data');
		echo '删除成功.....<br><hr><br>';

		/*===============================================================================*/

		echo 'mail测试.....<br>';
		$this->load_library( 'JueMail','mail' );
		echo '发送email.....<br>';
		$flag = $this->mail->sendmail( '626184755@qq.com', "subject=>瞎写点什么", "body=>空的也无所谓"); 
		if ($flag)
			echo '发送成功！！！<br><hr><br>';
		else 
			echo '发送失败.....<br><hr><br>';
	

		$this->load_view('header');
		//$this->load_view('index', $data); # $data放在上面或下面，一样效果。
		$this->load_view('footer');
	}

	function post_xhr(){

		$this->json( false, 'Ajax post is forbidden here!' );
	}

	function get_xhr(){
		$this->json( false, 'Ajax get is forbidden here!' );
	}

	function post(){
		$this->json( false, 'POST is forbidden here!' );
	}
}

?>