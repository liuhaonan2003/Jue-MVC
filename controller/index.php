<?php

/**
* @package     Index
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.9.23
**/ 

class index extends Jue{
	
	function __construct(){

	}

	# post、get  			函数为<form>表单发送
	# post_xhr、get_xhr		为ajax发送
	# 可以声明其他函数，均在Jue这个类里，均可调用Jue内其他对象。
	# 注意变量重复声明现象

	function get(){
		
		$this->load_language( 'index', 'zh-cn' );

		$data = array(//这是渲染时候的传递的
			'base'=>__Base__,
			'public'=>__Public__,
			'time'=> date('Y-m-d H:i:s'),
		);	

		$this->load_help('Loggerss');

		$this->load_view('header');
		$this->load_view('index', $data); # $data放在上面或下面，一样效果。
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