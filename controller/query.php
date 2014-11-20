<?php

/**
* @package     string
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.10.29
**/ 

class query extends Jue{
	
	function __construct(){

	}

	# post、get  			函数为<form>表单发送
	# post_xhr、get_xhr		为ajax发送
	# 可以声明其他函数，均在Jue这个类里，均可调用Jue内其他对象。
	# 注意防止变量重复声明

	function get(){

/* 导入类 */		
$this->load_library('JueQuery','xxx');


/*=================================== insert ===========================================*/
/**
* @return insert id
*/
$insert_data = array(
	'email'=>'xiaocao.grasses@gmail.com', 
	'username'=>"xiaocao", 
	"password"=>md5( rand().time() ),
);
$insert_test = $this->xxx->insert_where('user', $insert_data );



/*=================================== select ===========================================*/
/**
* @return select data
* @param single => boolean => select single array
* @param where => array => select filter array
* default => "SELECT * FROM `$table` WHERE `$key`='$value' LIMIT 0,1" 
*/
$single = true;
$where = array(
	'username'=>'xiaocao', 
	'id <'=>30,
);
$select_test = $this->xxx->select('id|username|email')->order_by('id', 'ASC')->get_where('user', $where, $single);
$this->xxx->debug('Select Test', $select_test);
$this->xxx->debug('Select Test Sql', $this->xxx->sql() );
$this->xxx->debug('Select Test Affact Row Num', $this->xxx->row_num() );



/*=================================== update ===========================================*/
/**
* @return update data
* @param where => array
* @param set => array
*/

$where = array(
	'username'=>'xiaocao', 
	'id <'=>5,
);
$set = array(
	'username'=>'update',
	'email'=>'test@example.com',
);
$update_test = $this->xxx->update_where('user', $where, $set);
$this->xxx->debug('Update Test', $update_test);
$this->xxx->debug('Update Test Sql', $this->xxx->sql());



/*=================================== delete ===========================================*/
/**
* @return boolean
* @param where => array
* @param set => array
*/
$where = array(
	'username'=>'update',
	'id >'=>3,
);
$delete_test = $jue->delete_where('user', $where);
$this->xxx->debug('Delete Test', $delete_test);
$this->xxx->debug('Delete Test Sql', $this->xxx->sql());

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