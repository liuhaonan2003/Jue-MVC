<?php

/**
* @package     Index
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.9.23
**/ 

class oss extends Jue{
	function get(){
		require( __Package__.'oss/aliyun.php' );
		require( __Package__.'oss/samples/MultipartSample.php' );
	}
}

?>