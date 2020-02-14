<?php

namespace SQLi;

use SQLi\DataBase as DataBase;
use SQLi\SQLiException as SQLiException;
use SQLi\Result as Result;

class SQLi {

    private static $databases = [];

    /**
     *  clonagem e construtor estão impossiblitados para uso
     */
    private function __construct() {}
    private function __clone() {}
	
	/**
	 *  Add new Data Base
	 */
    public static function addDB(string $alias, string $driver, string $host, string $dbname, string $user, string $pass, $port = null){
        
        self::$databases[$alias] = new DataBase(
            $driver, 
            $host, 
            $dbname, 
            $user, 
            $pass, 
            $port
        );

    }
	
	/**
	 *  Add new Data Bases using JSON
	 */

    public static function setDB(string $json){

        $json = json_decode($json, true);
        if(!$json) throw new SQLiException(1);
        
        foreach ($json as $alias => $values) {

            $port = isset($values['port']) ? $values['port'] : null;
            self::hasKeys(array_keys($values));
            self::addDB(
                $alias, 
                $values['driver'], 
                $values['host'], 
                $values['dbname'], 
                $values['user'],
                $values['pass'], 
                $port
            );

        }
        
    }
	
	public static function getDB(string $aliasDB = ""):DataBase{
	
		if(count(self::$databases) === 0) throw new SQLiException(3);
		$key = $aliasDB === ""? array_keys(self::$databases)[0] : $aliasDB;
		if(!isset(self::$databases[$key])) throw new SQLiException(4);
		
		return self::$databases[$key];
     
	}
	
	/**
	 *  Using selects in Data Base
	 *  @param $query string
	 *  @param $values array
	 *  @param $aliasDB string - Use this if you need select in other data base 
	 */	
    public function query(string $query, array $values = [], string $aliasDB = ""):Result{
            
        $pdo = self::getDB($aliasDB)->get();
        $st = $pdo->prepare($query);
		
		if(count($values) > 1)
			self::setBinds($st, $values);
        
		$st->execute();
		
        return new Result($st);
        
    }
	
	/**
	 *  Using this function for inset new row and get your id
	 *  @param $insert string
	 *  @param $values array - ['ssi', 'value1', 'value2']
	 *  @param $aliasDB string - Use this if you need insert in other data base 
	 */	
	public static function insert(string $insert, array $values, string $aliasDB = ""):int{
		
		$pdo = self::getDB($aliasDB)->get();
        $st = $pdo->prepare($insert);
		
		if(count($values) < 2) throw new SQLiException(5); 
		self::setBinds($st, $values);
        
		$st->execute();
		return $pdo->lastInsertId;
		
	}
	
	/**
	 *  Using this function for inset many rows in same time
	 *  @param $insert string - "table (value1, value2)"
	 *  @param $values array - ['ssi', ['value1A', 'value2A'],['value1B', 'value2B']]
	 *  @param $aliasDB string - Use this if you need insert in other data base 
	 */	
	public static function multiInsert(string $insert, array $values, string $aliasDB = ""){
		
		$pdo = self::getDB($aliasDB)->get();
	
		if(count($values) < 2) throw new SQLiException(5); 
		
		$binds  = array_shift($values);
		$insert = "INSERT INTO ".trim($insert)." VALUES ";
		
		$insert .= substr(str_repeat("(".substr(str_repeat("?,", count($values[0])), 0, -1).")," , count($values)), 0, -1);
		
		$st = $pdo->prepare($insert);
		$arr = [];
		
		$y = 1;
		foreach($values as $k => $rows){
			$i = 0;
			foreach($rows as $key => $val){
				$var = &$values[$k][$key];
				self::bind($st, $var, $y, $binds[$i]);
				$i++; $y++;
			}
		}
		
		$st -> execute();

	}
	
	/**
	 *  Using this function for inset/updates/creates/etc - NOT SELECT
	 *  This function will not return rows
	 *  @param $exec string
	 *  @param $values array - ['ssi', 'value1', 'value2']
	 *  @param $aliasDB string - Use this if you need insert in other data base 
	 */
	public static function exec(string $exec, array $values = [], string $aliasDB = ""){
		
		$pdo = self::getDB($alias)->get();
        $st = $pdo->prepare($query);
		
		if(count($values) > 1)
			self::setBinds($st, $values);
        
		$st->execute();
		
	}
	
    private static function hasKeys(array $keys){
        
        $ks = ['driver', 'host', 'dbname', 'user', 'pass'];
        $list = [];

        foreach ($ks as $value) if(!in_array($value, $keys)) $list[] = $value;
        if(count($list) > 0) throw new SQLiException(2, join(", ", $list));

    }

    private static function setBinds($st, array $values){
	
		$binds = array_shift($values);
		
		for($i = 0, $y = 1; $i < strlen($binds); $i++, $y++){
			
			$var = &$values[$i];
			self::bind($st, $var, $y, $binds[$i]);
			
		}
        
    }
	
	private static function bind($st, &$var, $y, $bind){

		switch ($bind) {
			case 'i':
				$bind = \PDO::PARAM_INT;
				break;
			case 'b':
				$bind = \PDO::PARAM_BOOL;
				break;
			case 'd':
				$var = strval($var);
				$bind = \PDO::PARAM_STR;
				break;
			case 's':
				$bind = \PDO::PARAM_STR;
				break;
			default:
				$bind = false;
				break;
		}
		!$bind ? $st->bindParam($y, $var) :
		$st->bindParam($y, $var, $bind);
	}

}