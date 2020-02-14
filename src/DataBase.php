<?php 

namespace SQLi; 


class DataBase {
    
    private $pdo;
    private $driver, $host, $dbname, $user, $pass, $port;
    private $open = false;

    public function __construct($driver, $host, $dbname, $user, $pass, $port){
        
        $this->driver = $driver;
        $this->host   = $host;
        $this->dbname = $dbname;
        $this->user   = $user;
        $this->pass   = $pass;
        $this->port   = $port;
    
    }

    public function get(){
        
        if(!$this->open){
        
            $strConn = $this->driver.":host=".$this->host.";";
            if($this->port) $strConn .= "port=".$this->port;
            $strConn .= "dbname=".$this->dbname;
            
            try {
                $this->pdo = new \PDO($strConn, $this->user, $this->pass);
            } catch (\PDOException $e){
                echo $e;
            }
            
            $this->open = true;

        }
        return $this->pdo;
    }

}
