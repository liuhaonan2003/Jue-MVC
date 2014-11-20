<?php

/**
* @package     system
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.9.29
**/ 

class system extends Jue{
	
	function __construct(){

	}

	# post、get  			函数为<form>表单发送
	# post_xhr、get_xhr		为ajax发送
	# 可以声明其他函数，均在Jue这个类里，均可调用Jue内其他对象。
	# 注意变量重复声明现象

	function get(){
		echo json_encode($this);
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