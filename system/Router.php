<?php

/**
* @package     Jue
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.10.1
**/

class JueRouter{

    public static function serve($routes) {

        JueHook::fire('before_request', compact('routes'));

        // 解析http报头
        $request_method = strtolower($_SERVER['REQUEST_METHOD']);
        $path_info = '/';
        if (!empty($_SERVER['PATH_INFO'])) {
            $path_info = $_SERVER['PATH_INFO'];
        } else if (!empty($_SERVER['ORIG_PATH_INFO']) && $_SERVER['ORIG_PATH_INFO'] !== '/index.php') {
            $path_info = $_SERVER['ORIG_PATH_INFO'];
        } else {
            if (!empty($_SERVER['REQUEST_URI'])) {
                $path_info = (strpos($_SERVER['REQUEST_URI'], '?') > 0) ? strstr($_SERVER['REQUEST_URI'], '?', true) : $_SERVER['REQUEST_URI'];
            }
        }
        
        // include file
        $path = null;
        $class = null;
        $regex_matches = array();

        if (isset($routes[$path_info])) {
            $class = JueHook::get_class( $routes[$path_info] );
            $path = __Controller__.$routes[$path_info].'.php';
        } else if ($routes) { 
            $tokens = array(
                ':string' => '([a-zA-Z]+)',
                ':number' => '([0-9]+)',
                ':alpha'  => '([a-zA-Z0-9-_]+)'
            );
            foreach ($routes as $pattern => $handler_name) {
                $pattern = strtr($pattern, $tokens);
                if (preg_match('#^/?' . $pattern . '/?$#', $path_info, $matches)) {
                    $class = JueHook::get_class( $handler_name );
                    $path = __Controller__.$handler_name.'.php';
                    $regex_matches = $matches;
                    break;
                }
            }
        }   

        // 404 or 200
        if( $path && $class ){
            if (file_exists( $path )){
                require( $path );
            }else{
                $msg='Controller does not exists.';
                JueHook::expected($msg);
                header("HTTP/1.1 404 Not Found!");
                exit( json_encode( array( 'result'=>false, 'info'=>$msg) ) );
            }
        }else{
            $msg='The page you fetch is not exist!';
            JueHook::expected($msg);
            header("HTTP/1.1 404 Not Found!");
            exit( json_encode( array( 'result'=>false, 'info'=>$msg ) ) );
        }

        $result = null;
        $class_instance = null;

        if ($class) {
            if (is_string($class)) {
                $class_instance = new $class();
            } elseif (is_callable($class)) {
                $class_instance = $class();
            }
            $class_instance->load_config();
        }

        if ($class_instance) {
            unset($regex_matches[0]);

            if (self::is_xhr_request() && method_exists($class_instance, $request_method . '_xhr')) {
                header('Content-type: application/json');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');        
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
                header('Cache-Control: no-store, no-cache, must-revalidate');
                header('Cache-Control: post-check=0, pre-check=0', false);
                header('Pragma: no-cache');
                $request_method .= '_xhr';
            }

            if (method_exists($class_instance, $request_method)) {
                JueHook::fire('before_handler', compact('routes', 'class', 'request_method', 'regex_matches'));
                $result = call_user_func_array(array($class_instance, $request_method), $regex_matches);
                JueHook::fire('after_handler', compact('routes', 'class', 'request_method', 'regex_matches', 'result'));
            } else {
                JueHook::fire('404', compact('routes', 'class', 'request_method', 'regex_matches'));
            }
        } else {
            JueHook::fire('404', compact('routes', 'class', 'request_method', 'regex_matches'));
        }

        JueHook::fire('after_request', compact('routes', 'class', 'request_method', 'regex_matches', 'result'));
    }

    private static function is_xhr_request() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}

class JueHook {

    private static $instance;

    private $hooks = array();

    private function __construct() {}
    private function __clone() {}

    public static function add($hook_name, $fn) {
        $instance = self::get_instance();
        $instance->hooks[$hook_name][] = $fn;
    }

    public static function fire($hook_name, $params = null) {
        $instance = self::get_instance();
        if (isset($instance->hooks[$hook_name])) {
            foreach ($instance->hooks[$hook_name] as $fn) {
                call_user_func_array($fn, array(&$params));
            }
        }
    }

    public static function expected ( $msg, $file='system.log' ){
        require(__Help__.'Logger.php');
        $log = new Logger(__Log__.$file);
        $log->log( $msg, Logger::FATAL);
    }

    public static function get_instance() {
        if (empty(self::$instance)) {
            self::$instance = new JueHook();
        }
        return self::$instance;
    }

    public static function get_class( $path ) {
        
        $path = rtrim( $path, '/' );
        $array = explode( '/', $path );
        $index = count( $array )-1;

        return $array[ $index ];
    }
}


?>







