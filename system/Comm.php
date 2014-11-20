<?php

/**
* @package     Jue
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.10.1
**/


/**
 * 获取当前目录及子目录下的所有文件
 * @param string $dir 路径名
 * @return array 所有文件的路径数组
 */
function getFile($dir) {
    $files = array();
 
    if(!is_dir($dir)) {
        return $files; 
    }
    
    $handle = opendir($dir);
    if($handle) {
        while(false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $filename = $dir . "/"  . $file;
                if(is_file($filename)) {
                    $files[] = $filename;
                }else {
                    $files = array_merge($files, get_files($filename));
                }
            }
        }   //  end while
        closedir($handle);
    }
    return $files;
} 

function arrayToObject($array) {
    if (!is_array($array)) {
        return $array;
    }
    $object = new stdClass();
    if (is_array($array) && count($array) > 0) {
        foreach ($array as $name=>$value) {
            $name = strtolower(trim($name));
            if (!empty($name)) {
                $object->$name = arrayToObject($value);
            }
        }
        return $object; 
    } else {
        return FALSE;
    }
}

/**
* 跳转页面
* @param url, title, body, code
* @return exit 
*/
function redirect( $url, $title='Not Found', $body='Sorry, the page you fetched is not exist!', $code=404 ){
	
	$_SESSION['error']['title'] = $title;
	$_SESSION['error']['body'] = $body;
	$_SESSION['error']['code'] = $code;
	
	header("HTTP/1.1 ".$code);
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); 
	header("Location: ".$url);
}

/**
* @param bool, msg
* @return exit 
*/
function json( $bool = true, $msg ){
	exit( json_encode( array('result'=>$bool, 'msg'=>$msg) ) );
}

?>