<?php

/**
* @package     Index
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.9.23
**/ 

class Index extends Jue{
	
	function __construct(){

	}

	# post、get  			函数为<form>表单发送
	# post_xhr、get_xhr		为ajax发送
	# 可以声明其他函数，均在Jue这个类里，均可调用Jue内其他对象。
	# 注意变量重复声明现象

	function get( $param ){

		$data = array(
			'base'=>__Base__,
			'public'=>__Public__,
			'time'=>date('Y-m-d H:i:s'),
			'斜杠后变量的值'=>$param,
		);

		$this->load_library('JueQuery', 'mysql');
		
		#this->test();

		$this->load_view('test1');
		$this->load_view('test2', $data); # $data放在上面或下面，一样效果。
	}

	function post_xhr(){

		$this->json( false, 'Ajax post is forbidden here!' );
	}

	function get_xhr(){
		$this->json( false, 'Ajax get is forbidden here!' );
	}

	function post(){
		$this->redirect( $this->config->base_url.'error/' );
	}

	function text(){
		echo '自定义函数';
	}
}

?>