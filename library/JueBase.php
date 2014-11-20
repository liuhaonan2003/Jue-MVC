<?php

/**
* @package     JueQuery
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.9.21
**/

class JueBase extends Jue{

	//private $string = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-+*#@";
	private $string = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	private $base = 62;

	public function base62_encode($str) {
		$out = '';
		for($t=floor(log10($str)/log10( $this->base )); $t>=0; $t--) {
			$a = floor($str / pow( $this->base, $t));
			$out = $out.substr($this->string, $a, 1);
			$str = $str - ($a * pow( $this->base, $t));
		} 	
		return $out;
	}

	public function base62_decode($str) {
		$out = 0;
		$len = strlen($str) - 1;
		for($t=0; $t<=$len; $t++) {
			$out = $out + strpos($this->string, substr($str, $t, 1)) * pow( $this->base, $len - $t);
		} 
		return substr(sprintf("%f", $out), 0, -7);
	} 
}

/*$str = time();
$object = new Base();
echo $object->base62_encode($str) . "\n";
echo "<br>";
echo $object->base62_decode($object->base62_encode($str)) . "\n";
*/
?>