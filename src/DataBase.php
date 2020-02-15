<?php 

namespace SQLi; 

class DataBase {
    
    private $pdo;
    private $driver, $host, $dbname, $user, $pass, $port, $charset;
    private $open = false;

    public function __construct($driver, $host, $dbname, $user, $pass, $charset, $port){
        
        $this->driver = $driver;
        $this->host   = $host;
        $this->dbname = $dbname;
        $this->user   = $user;
        $this->pass   = $pass;
		$this->charset= $charset;
        $this->port   = $port;
    
    }

    public function get(){
        
        if(!$this->open){
        
            $strConn = $this->driver.":host=".$this->host.";";
            if($this->port) $strConn .= "port=".$this->port;
            $strConn .= "dbname=".$this->dbname.";";
			$strConn .= "charset=".$this->charset;

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
