<?php

/**
* @package     JueSystem
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.9.22
**/

class Base{

	protected $requestArray = array();
	protected $renderArray = array();
	protected $languageArray = array();
	public $config;

	function __construct(){
	}

	function __destruct(){
		// render view page
		$this->render();
	}

	function __call( $method, $args ){
        exit(json_encode( array('result'=>false,'info'=>'Unknown Methd!') ));
    }

	public function load_view( $path, $param=null ){
		// build param
		$data = isset($param) ? $param : null;
		if ( is_array($data) ){
			foreach ($data as $key => $value) {
				$this->requestArray[ $key ] = $data[$key];	
			}
		}

		// build path
		$path = rtrim( $path, '.php' );
		$file = './view/'.$path.'.php';

		if( file_exists($file) ){
			//require( $file );
			array_push( $this->renderArray, $file );
		}else{
			$msg='File `'.__View__.$path.'.php` not found !';
			$this->expected($msg);
			header("HTTP/1.1 404 Not Found!");
			exit( json_encode( array('result'=>false, 'info'=> $msg) ) );
		}
	}

	public function load_help( $path, $name=null ){
		// build path
		$path = trim( $path, '.php' );
		$file = __Help__.$path.'.php';
		
		if( file_exists($file) ){
			require($file);
		}else{
			$msg = 'File `'.__Help__.$path.'.php` not found !';
			$this->expected($msg);
			header("HTTP/1.1 404 Not Found!");
			exit( json_encode( array('result'=>false, 'info'=> $msg) ) );
		}	
	}

	public function load_language( $path, $type=null ){

		if( $type ){
			$langType = $type; 
		}else{
			$langType = $this->config['lang'];
		}
		$file = __Language__.$langType.'/'.$path.'.php';
		if( file_exists( $file ) ){
			require( $file );
			$this->languageArray = $lang;
		}else{
			$msg='File `'.$langType.'/'.$path.'.php` not found !';
			$this->expected($msg);
			header("HTTP/1.1 404 Not Found!");
			exit( json_encode( array('result'=>false, 'info'=> $msg) ) );
		}
	}

	public function load_package( $package, $file=null ){
		$file = $file ? trim( $file, '.php' ) : null;
		$file = __Package__.$path.'.php';
	}

	public function load_library( $path, $name ){
		// build path
		$path = trim( $path, '.php' );
		$file = __Library__.$path.'.php';
		// build class
		$array = explode( '/', $path );
        $index = count( $array )-1;
        $class = $array[$index];

		if( file_exists($file) ){
			require($file);
			// new class
			$tmp = new $class;
			$this->$name = $tmp;
		}else{
			$msg='File `'.__Library__.$path.'.php` not found !';
			$this->expected($msg);
			header("HTTP/1.1 404 Not Found!");
			exit( json_encode( array('result'=>false, 'info'=> $msg) ) );
		}	
	}

	// load config
	public function load_config(){
		$config = array();

		$data = getFile( __Config__ );
		
		foreach ($data as $key => $value) {
			require( $data[$key] );
		}
		$this->config=$config;
		$lang = strtolower( substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) );
		$this->config['lang'] = $lang;
	}

	/**
	* @param data => array , render =>array
	*/
	public function render(){
		// build data
		$data = $this->requestArray;
		foreach ($data as $key => $value) {
			$$key = $data[$key];
		}

		// language
		$lang = $this->languageArray;

		// require php 
		$render = $this->renderArray;
		foreach ($render as $key => $value) {
			require ($render[$key]);
		}
	}

	public function json( $bool = true, $msg ){
		exit( json_encode( array('result'=>$bool, 'msg'=>$msg) ) );
	}

	public function expected ( $msg, $file='system.log' ){
		require(__Help__.'Logger.php');
		$log = new Logger(__Log__.$file);
		$log->log( $msg, Logger::FATAL);
	}
}

class Jue extends Base{
	function __construct(){
		//$this->load_config();
		Base::__construct(); 
	}

	function __destruct(){
		unset( $this );
		Base::__destruct();
	}
}
	
?>