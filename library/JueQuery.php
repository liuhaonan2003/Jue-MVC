<?php

/**
* @package     JueQuery
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.9.19
**/

/*
* base 主要做数据封装
*/
class BaseJueQuery extends Jue{ 

    /*
    * sql => array
    */
    public $sql ='';

    /*
    * orderType => DESC/ASC
    */
    protected $orderBy = 'DESC';
    protected $orderKey = "`id`";
    /*
    * 
    */
    protected $whereTo = '';

    /*
    * select key, default => *
    */
    protected $selectKey = '*';

    /* 
    * select, update limit
    */
    protected $offset=0;
    protected $limit=1; 

    /*
    * affcet num
    */
    protected $rowNum=0;
    protected $insertId=0;  

    function __construct(){
        $this->load_config();
        //初始化后，自动链接数据库
        $conn = mysql_connect( $this->config['db']['host'], $this->config['db']['user'],$this->config['db']['password'] );
        if (!$conn){
            die("连接数据库失败：" . mysql_error());
        }else{
            mysql_select_db($this->config['db']['database'], $conn);
            mysql_query("set character set 'utf8'");
            mysql_query("set names 'utf8'");
        }
    }

    /**
    * init vartue
    * @return  none
    */
    protected function initVartue(){
        $this->orderBy='DESC';
        $this->orderKey = "`id`";
        $this->whereTo='';
        $this->selectKey='*';
        $this->offset=0;
        $this->limit=1;
    }
    
    /**
    * init vartue
    * @return  none
    */
    protected function initFunction(){
        $this->sql='';
        $this->rowNum=0;
        $this->insertId=0;
        $this->safer();
    } 

    /**
    * call when destory
    * @return  none
    */
    protected function destoryFuncton(){

    }

    /**
    * call unknown function
    * @param method => string
    * @param args => string => args for method
    */
    function __call( $method, $args ){
        exit(json_encode( array('result'=>false,'data'=>'Unknown Methd!') ));
    }

    /*
    * $parms => array
    * 将数组转化为sql可用的语句
    */
    protected function insertBuild( $params ){
        $strA="";
        $strB="";
        foreach($params as $key=>$value){
            if(is_null($key)) continue;
            if(is_null($strA)) { 
                $strA=$key;  
            } else{ 
                $strA.="`".$key."`, ";
            }
            if(is_null($strB)) {
                $strB="'$value'";  
            } else {
                $strB.="'$value', ";
            }
        }
        $strA=rtrim($strA, ", ");
        $strB=rtrim($strB, ", ");

        return array('value1'=>$strA, 'value2'=>$strB);
    }

    protected function whereBuild($params, $isSet=false){
        if( !is_array($params) ){
            return '';
        }
        $val=null;
        foreach($params as $key=>$value){ 
            if(is_null($key)) continue;
            if(is_null($val)) {
                $val = $this->whereRebuildSingle( $key, $value );
            }else{ 
                if( $isSet ){    
                    $v = $this->whereRebuildForSet( $key, $value );
                }else{
                    $v = $this->whereRebuildMore( $key, $value );
                }
                $val.=$v;
            }
        }
        $result=ltrim($val," AND");
        return $result;
    }

    /*
    * for selectRebuild()
    * array to string => string
    */
    private function whereRebuildSingle( $key, $value ){

        $key = ltrim($key);
        $key = rtrim($key);

        if( substr ($key,-1,1)=='<' || substr ($key,-1,1)=='>'){
            
            $mark = substr ($key,-1,1);
            $key = substr_replace($key,'',-1);
            $key = rtrim($key);
            $result =  is_int($value) ? "`{$key}` {$mark} $value" : "`{$key}` {$mark} '$value'";

        } else if( substr ($key,-2,2)=='<=' || substr ($key,-2,2 )=='>='){

            $mark = substr ($key,-2,2);
            $key = substr_replace($key,'',-2);
            $key = rtrim($key);
            $result =  is_int($value) ? "`{$key}` {$mark} $value" : "`{$key}` {$mark} '$value'";

        } else{
            $result =  is_int($value) ? "`$key`=$value" : "`$key`='$value'"; 
        }
        return $result;
    }

    /**
    * for selectRebuild()
    * array to string => string
    * @param key => string
    * @param value =>string
    */
    private function whereRebuildMore( $key, $value ){

        $key = ltrim($key);
        $key = rtrim($key);

        if(  substr ($key,-1,1)=='<' || substr ($key,-1,1 )=='>' ){
            
            $mark = substr ($key,-1,1);
            $key = substr_replace($key,'',-1);
            $key = rtrim($key);
            $result =  is_int($value) ? " AND `{$key}` {$mark} $value" : " AND `{$key}` {$mark} '$value'"; 
        
        }else if(  substr ($key,-2,2)=='<=' || substr ($key,-2,2 )=='>=' ){    
            
            $mark = substr ($key,-2,2);
            $key = substr_replace($key,'',-2);
            $key = rtrim($key);
            $result =  is_int($value) ? " AND `{$key}` {$mark} $value" : " AND `{$key}` {$mark} '$value'"; 
        
        }else{
            $result =  is_int($value) ? " AND `$key`=$value" : " AND `$key`='$value'"; 
        }
        return $result;
    }

    private function whereRebuildForSet( $key, $value ){

        $key = ltrim($key);
        $key = rtrim($key);

        if(  substr ($key,-1,1)=='<' || substr ($key,-1,1 )=='>' ){
            
            $mark = substr ($key,-1,1);
            $key = substr_replace($key,'',-1);
            $key = rtrim($key);
            $result =  is_int($value) ? ", `{$key}` {$mark} $value" : ", `{$key}` {$mark} '$value'"; 
        
        }else if(  substr ($key,-2,2)=='<=' || substr ($key,-2,2 )=='>=' ){    
            
            $mark = substr ($key,-2,2);
            $key = substr_replace($key,'',-2);
            $key = rtrim($key);
            $result =  is_int($value) ? ", `{$key}` {$mark} $value" : ", `{$key}` {$mark} '$value'"; 
        
        }else{
            $result =  is_int($value) ? ", `$key`=$value" : ", `$key`='$value'"; 
        }
        return $result;
    }

    /**
    * for selectRebuild()
    * array to string => string
    * @param key => string
    * @param value =>string
    */
    private function safer() {
        if(!get_magic_quotes_gpc()) {
            $_REQUEST = array_map( 'stripslashes', $_REQUEST); 
        }
        $_REQUEST = array_map( 'mysql_real_escape_string', $_REQUEST);
    }

    /*
    * $query => sql
    * 执行sql语句
    */
    protected function exce( $query ){
        return mysql_query( $query );
    }

    /**
    * loop for array to string
    * array to string => string
    * @param params=>array
    */
    protected function arrayToString($params){
        $result = 'array( <br>';
        if(is_array($params)){
            foreach ($params as $key => $value) {
                if(is_array($value)) {
                    $result = $this->arrayToString($value);
                }else{
                    $res = $key.' => '.$value.',<br>';
                    $result .= $res; 
                }
            }
        }
        $result.=" )";
        return $result;
    }
}

class JueQuery extends BaseJueQuery{

    function __construct(){
        //parent::__construct(); 
        BaseJueQuery::__construct(); 
    }

    /*=========================================  help  ===========================================*/

    /**
    * sercond call
    * orderBy => string => order by type 
    */
    public function order_by( $key, $type="DESC" ){
        $this->orderBy = $type;
        $this->orderKey = "`".$key."`";
        return $this;
    }

    /*
    * second call
    * where => string => select form where
    */
    public function where( $where ){
        if (!$where){
            // send a null, get error
            $this->whereTo ='';
        }else{
            $this->whereTo = $where;
        }
        return $this;
    }

    /**
    * select elem
    * @param select => string => like 'xx|yy|zz' 
    */
    public function select( $select='*' ){

        $res = explode('|', $select);
        $result = '';
        // arrat to string
        if(is_array($res)){
            foreach ($res as $key => $value) {
                $string = '`'.$res[$key].'`,';
                $result.= $string;
            }
        }else{
            $result = '`'.$select.'`';
        }
        $result = rtrim($result);
        $result = rtrim($result,',');  

        $this->selectKey = $result;
        return $this;
    }

    /** 
    * set limit 
    * @param offset => int
    * @param limit => int
    */
    public function limit($offset,$limit){
        $this->offset = $offset;
        $this->limit = $limit;
        return $this; 
    }

    /*=========================================  select/delete/insert/  ===========================================*/
    
    /*
    *  get insert id
    */
    public function insert_id(){
        return $this->insertId;
    }

    /*
    *  get affect id
    */
    public function row_num(){
        return $this->rowNum;
    }

    /*
    *  get sql
    */
    public function sql(){
        return $this->sql;
    }

    /**
    * @param params => array
    * @return boolean
    */
    public function insert_where($table,$params){
        // init for function
        $this->initFunction();

        if(!is_array($params)||is_null($table)) return;

        $args = $this->insertBuild($params);

        $this->sql = "INSERT INTO `{$table}` ({$args['value1']}) VALUES ({$args['value2']})";

        if(mysql_query( $this->sql )){
            // affect row
            $this->rowNum = mysql_affected_rows();
            $inserdId = mysql_fetch_row( mysql_query("SELECT LAST_INSERT_ID()") );
            $this->insertId = $inserdId[0]; 
            
            return $this->insertId;
        }else{
            return false;
        }
    }

    /**
    * @param key => string
    * @param values => array
    * @return boolean
    */
    public function delete($table=null,$key,$values=null){
        // init for function
        $this->initFunction();

        if(is_array($values)){
            foreach ($values as $k => $v) {
                $this->sql = "DELETE FROM `$table` WHERE `$key`='$v' ";        
                $flag = mysql_query( $this->sql );
                // affect row
                $this->rowNum = mysql_affected_rows();
                if (!$flag){
                    return false;
                }
            }
        }else{
            $sql="DELETE FROM `$table` WHERE `$key`='$values' ";
            return mysql_query($sql);    
        }
        return true;
    }

    /**
    * delete sql
    * @param value => array 
    * @return boolean
    */
    public function delete_where($table=null,$value){
        // init for function
        $this->initFunction();
        // for key and check
        $key = $this->whereBuild($value);

        $this->sql = "DELETE FROM `{$table}` WHERE {$key}";

        return mysql_query( $this->sql );
    }

    /**
    * call like : select+table+key+value+limit
    * @param params => array selete filter
    * @param single => boolean , select to array or row
    * @return array
    */
    public function get_where( $table=NULL, $params, $single=false ){
        // init for function
        $this->initFunction();
        // build params
        $params = $this->whereBuild($params);
        // build sql 
        $this->sql = "SELECT {$this->selectKey} FROM `{$table}` WHERE {$params} ORDER BY {$this->orderKey} {$this->orderBy} LIMIT {$this->offset},{$this->limit}";
        // select mysql
        $query = mysql_query( $this->sql );

        // affect row
        $this->rowNum = mysql_affected_rows();// fetch data
        //init for vartue
        $this->initVartue();

        if($this->rowNum==0){
            return null;
        }else{
            /* if table is not null */
            if ($query) {
                $data=array();
                // select row
                if($single) return mysql_fetch_array($query);
                // for array
                while($row=mysql_fetch_array($query)){
                    array_push($data,$row);
                }
                return $data;
            }else{
                /* select data error */
                return false;
            }
        } 
        return false; 
    }

    /**
    * update mysql
    * @param where => array
    * @param set => array
    */
    public function update_where( $table, $where, $set){
        // init for function
        $this->initFunction();
        // build vartue
        $set = $this->whereBuild($set, true);
        $where = $this->whereBuild($where);

        $this->sql = "UPDATE `{$table}` SET {$set} WHERE {$where}";
        $query = mysql_query( $this->sql );
        // affect row
        $this->rowNum = mysql_affected_rows();
        // return 
        if( $this->rowNum ){
            return true;
        }else{  
            return false;
        }
    }

    /**
    * update mysql
    * @param where => array
    * @param set => array
    */
    public function check_where($table,$params=null){
        // init for function
        $this->initFunction();
        
        $params = $this->whereBuild($params);
        
        $this->sql = "SELECT {$this->selectKey} FROM `{$table}` WHERE {$params} LIMIT {$this->offset},{$this->limit}";
        
        $result = mysql_fetch_array(mysql_query( $this->sql )); 

        if( $result ){
            return true;
        }else{
            return false;
        }
    }

    public function create_db($db){
        $creat="CREATE DATABASE IF NOT EXISTS `$db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci";
        if(mysql_query($create)){
            return true;
        }else{
            return false;
        }
    }

    /**
    * run mysql
    * @param where => array
    * @param query => string => sql
    */
    public function run($query){
        // init for function
        $this->initFunction();

        $this->sql = $query;

        $row_num=mysql_fetch_row( mysql_query($query) );

        // affect row
        $this->rowNum = mysql_affected_rows();

        if($row_num==0){
            return null;
        }else{
            $result = mysql_query($query);      
            if ($result) {
                $data=array();
                while($row=mysql_fetch_array($result)){
                    array_push($data,$row);
                }
                return $data;
            }else{
                return false;
            }
        } 
    }

    /**
    * count data
    * @param params => array
    */
    public function count_where($table,$params=null){
        /*SELECT COUNT( * ) AS count FROM  `post` WHERE  `post_id` =16*/
        
        // init for function
        $this->initFunction();
        
        $params = $this->whereBuild($params);

        $this->sql = "SELECT count(*) as count FROM {$table} WHERE {$params}";
        $query= mysql_query( $this->sql );
        $result = mysql_fetch_array( $query );
        
        // affect row
        $this->rowNum = mysql_affected_rows();

        if ($result) {
            return $result['count'];
        }else{
            return false;
        }
    }

    /**
    * debug
    * @param key => string 
    * @param value => array or string
    */
    public function debug( $key, $value ){

        if (is_array($value)){
            $res = $this->arrayToString($value);
        }else if( is_object($value) ){
            $res = json_encode($value);
        }else{
            $res = $value;
        }

        echo "<br>==========================<br>Debug start...<br>".$key." => ".$res."<br>==========================<br>";
    }
}
?>