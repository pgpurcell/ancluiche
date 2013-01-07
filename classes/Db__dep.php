<?php

class Db {

	static $instance = NULL;
    
    function __construct() 
    {
    }
	
    function __clone()
    {
    }
	
	static function getInstance(){
		if(is_null(self::$instance)){
			self::$instance = self::buildInstance();
		}
		return self::$instance;
	}
	
	private static function buildInstance(){
		try{
			$instance = new PDO(DB_DSN, DB_USER, DB_PASS);
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		return $instance;
    }

    function one($query){
        return self::getInstance()->query($query)->fetch();
    }

    function all($query){
        return self::getInstance()->query($query)->fetchAll();
    }
    
    // }}}
    // {{{ save()
    /**
     * active reccord that saves data to the database
     * @params $table      : the table in which we save the data
     * @params $fields     : the data to be saved
     * @params $where      : key of the where clause
     * @params $whereValue : value of the where clause
     *
     *
     * if insert lastInsertId is returned.
     * if update affected rows are returned.
     **/

    function save($table, $fields, $where = 'id', $whereValue=NULL){
        $keys = $values = '';
        $db     = Db::getInstance();
        if( is_null($whereValue) ){
            foreach($fields as $key=>$value){
                    $keys   .= $key . ', ';
                    $values .= "'$value', ";
            }     
            $insert = sprintf("insert into $table (%s) values (%s)", trim($keys, ', '), trim($values, ', ') ); 
            $db->exec($insert);
        }else{
            foreach($fields as $key=>$value){
                $keys .= "$key = '$value', ";
            } 
            $update  = sprintf("update $table set %s where $where = '$whereValue'", trim($keys, ', ') );
            $affRows = $db->exec($update);
        }
        
        if($db->errorCode() == '00000'){
            return is_null($whereValue) ? $db->lastInsertId() : $affRows;
        }else{
            $error = $db->errorInfo();
            trigger_error($error[2], E_USER_ERROR);
        }
    }
}
